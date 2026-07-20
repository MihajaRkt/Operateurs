<?php

namespace App\Controllers;

use App\Models\CommissionModel;
use App\Models\FraisModel;
use App\Models\UtilisateurModel;
use App\Models\SoldeModel;
use App\Models\OperateurModel;
use App\Models\OperationModel;

class Utilisateur extends BaseController
{
    private function getCurrentUser(): ?array
    {
        $user = session()->get("user");

        return is_array($user) ? $user : null;
    }

    private function getAccueilData(): array
    {
        $user = $this->getCurrentUser() ?? [];
        $solde = 0;

        if (!empty($user["id"])) {
            $soldeModel = new SoldeModel();
            $montant = $soldeModel->getByUtilisateurId((int) $user["id"]);
            $solde = $montant["montant"] ?? 0;
        }

        return [
            "user" => $user,
            "solde" => $solde,
        ];
    }

    private function connectDatabase()
    {
        return \Config\Database::connect();
    }

    private function renderClientForm(string $view, string $message = "")
    {
        return view($view, [
            "erreur" => $message,
            "user" => $this->getCurrentUser(),
        ]);
    }

    public function login()
    {
        $model = new UtilisateurModel();
        $numero = trim($this->request->getPost("numero"));

        if (!preg_match('/^(032|033|034|037|038)[0-9]{7}$/', $numero)) {
            return redirect()
                ->back()
                ->withInput()
                ->with("erreur", "Numéro de téléphone invalide.");
        }
        $user = $model->getByTelephone($numero);
        if (!$user) {
            return redirect()
                ->back()
                ->withInput()
                ->with("erreur", 'Ce numéro n\'existe pas.');
        }

        session()->set("user", [
            "id" => $user["idUtilisateur"],
            "nom" => $user["nom"],
            "telephone" => $user["telephone"],
        ]);

        return view("clients/accueil", $this->getAccueilData());
    }

    public function historique()
    {
        $user = $this->getCurrentUser();

        if (!$user) {
            return redirect()->to("/loginClient");
        }

        $operationModel = new OperationModel();
        $operations = $operationModel->getHistoriqueByUtilisateur(
            (int) $user["id"],
        );

        return view("clients/historique", [
            "user" => $user,
            "operations" => $operations,
        ]);
    }

    public function transfert()
    {
        $user = $this->getCurrentUser();

        if (!$user) {
            return redirect()->to("/loginClient");
        }

        $numero = trim($this->request->getPost("numero"));
        $montant = $this->request->getPost("montant");

        if (!is_numeric($montant) || $montant <= 0) {
            return $this->renderClientForm(
                "clients/transfert",
                "Le montant est invalide.",
            );
        }

        if (!preg_match('/^(032|033|034|037|038)[0-9]{7}$/', $numero)) {
            return $this->renderClientForm(
                "clients/transfert",
                "Le numéro est invalide.",
            );
        }

        $utilisateurModel = new UtilisateurModel();
        $destinataire = $utilisateurModel->getByTelephone($numero);

        if (!$destinataire) {
            return $this->renderClientForm(
                "clients/transfert",
                "Aucun utilisateur ne possède ce numéro.",
            );
        }

        if ((int) $destinataire["idUtilisateur"] === (int) $user["id"]) {
            return $this->renderClientForm(
                "clients/transfert",
                "Vous ne pouvez pas transférer vers votre propre numéro.",
            );
        }

        $fraisModel = new FraisModel();
        $frais = $fraisModel->getFraisByMontant($montant, 3);

        if (!$frais) {
            return $this->renderClientForm(
                "clients/transfert",
                "Aucun frais ne correspond à ce montant.",
            );
        }

        $montant = (float) $montant;

        // Récupérer l'opérateur de l'expéditeur (nécessaire pour commission et enregistrement)
        $operateurModel = new OperateurModel();
        $operateur = $operateurModel->getByTelephone($user["telephone"]);

        if (!$operateur) {
            return $this->renderClientForm(
                "clients/transfert",
                "Aucun opérateur ne correspond à votre numéro.",
            );
        }

        $sameOperateur = $utilisateurModel->sameOperateur(
            $user["telephone"],
            $destinataire["telephone"],
        );

        if (!$sameOperateur) {
            // Transfert inter-opérateur : appliquer la commission de l'opérateur expéditeur
            $commissionModel = new CommissionModel();
            $comm = $commissionModel->getByOperateurId(
                $operateur["idOperateur"],
            );
            if ($comm) {
                $commission = $montant * ((float) $comm["pourcentage"] / 100);
                $montantTotal =
                    $montant + (float) $frais["montant"] + $commission;
            } else {
                $montantTotal = $montant + (float) $frais["montant"];
            }
        } else {
            $montantTotal = $montant + (float) $frais["montant"];
        }

        // couvrir les frais de retrait du destinataire (même opérateur uniquement)
        $inclureFraisRetrait =
            $this->request->getPost("inclure_frais_retrait") === "1";
        if ($sameOperateur && $inclureFraisRetrait) {
            $fraisRetrait = $fraisModel->getFraisByMontant($montant, 2);
            if ($fraisRetrait) {
                $montantTotal += (float) $fraisRetrait["montant"];
            }
        }

        $dateOperation = $this->request->getPost("date") ?: date("Y-m-d");

        $db = $this->connectDatabase();
        $db->transBegin();

        $soldeModel = new SoldeModel($db);
        $soldeActuelle = $soldeModel->getByUtilisateurId((int) $user["id"]);

        if (!$soldeActuelle) {
            $db->transRollback();
            return $this->renderClientForm(
                "clients/transfert",
                "Votre compte ne possède pas de solde.",
            );
        }

        if ((float) $soldeActuelle["montant"] < $montantTotal) {
            $db->transRollback();
            return $this->renderClientForm(
                "clients/transfert",
                "Votre solde est insuffisant pour ce transfert.",
            );
        }

        $soldeDestinataire = $soldeModel->getByUtilisateurId(
            (int) $destinataire["idUtilisateur"],
        );
        if (!$soldeDestinataire) {
            $db->transRollback();
            return $this->renderClientForm(
                "clients/transfert",
                "Le destinataire ne possède pas de compte actif.",
            );
        }

        if (!$soldeModel->retirerMontant((int) $user["id"], $montantTotal)) {
            $db->transRollback();
            return $this->renderClientForm(
                "clients/transfert",
                "Le transfert a échoué pendant le débit.",
            );
        }

        if (
            !$soldeModel->ajouterMontant(
                (int) $destinataire["idUtilisateur"],
                $montant,
            )
        ) {
            $db->transRollback();
            return $this->renderClientForm(
                "clients/transfert",
                "Le transfert a échoué pendant le crédit.",
            );
        }

        // Opérateur du destinataire (pour tracer son côté)
        $operateurDestinataire = $operateurModel->getByTelephone(
            $destinataire["telephone"],
        );

        $operationModel = new OperationModel($db);

        // Opération côté expéditeur
        if (
            !$operationModel->enregistrerOperation([
                "idOperateur" => $operateur["idOperateur"],
                "idType_operation" => 3,
                "idFrais" => $frais["idFrais"],
                "idUtilisateur" => (int) $user["id"],
                "idDestinataire" => (int) $destinataire["idUtilisateur"],
                "date_operation" => $dateOperation,
                "montant" => $montant,
            ])
        ) {
            $db->transRollback();
            return $this->renderClientForm(
                "clients/transfert",
                "Le transfert a échoué lors de l'enregistrement (expéditeur).",
            );
        }

        // Opération côté destinataire (réception)
        if (
            !$operationModel->enregistrerOperation([
                "idOperateur" => $operateurDestinataire
                    ? $operateurDestinataire["idOperateur"]
                    : $operateur["idOperateur"],
                "idType_operation" => 3,
                "idFrais" => null,
                "idUtilisateur" => (int) $destinataire["idUtilisateur"],
                "idDestinataire" => (int) $user["id"],
                "date_operation" => $dateOperation,
                "montant" => $montant,
            ])
        ) {
            $db->transRollback();
            return $this->renderClientForm(
                "clients/transfert",
                "Le transfert a échoué lors de l'enregistrement (destinataire).",
            );
        }

        if (!$db->transCommit()) {
            return $this->renderClientForm(
                "clients/transfert",
                "Le transfert a échoué.",
            );
        }

        return view(
            "clients/accueil",
            array_merge($this->getAccueilData(), [
                "success" => "Transfert effectué avec succès.",
            ]),
        );
    }

    public function retrait()
    {
        $user = $this->getCurrentUser();

        if (!$user) {
            return redirect()->to("/loginClient");
        }

        $montant = $this->request->getPost("montant");

        if (!is_numeric($montant) || $montant <= 0) {
            return $this->renderClientForm(
                "clients/retrait",
                "Le montant est invalide.",
            );
        }

        $operateurModel = new OperateurModel();
        $operateur = $operateurModel->getByTelephone($user["telephone"]);

        if (!$operateur) {
            return $this->renderClientForm(
                "clients/retrait",
                "Aucun opérateur ne correspond à votre numéro.",
            );
        }

        $dateOperation = $this->request->getPost("date") ?: date("Y-m-d");

        $db = $this->connectDatabase();
        $db->transBegin();

        $soldeModel = new SoldeModel($db);
        $soldeActuelle = $soldeModel->getByUtilisateurId((int) $user["id"]);

        if (
            !$soldeActuelle ||
            (float) $soldeActuelle["montant"] < (float) $montant
        ) {
            $db->transRollback();
            return $this->renderClientForm(
                "clients/retrait",
                "Votre solde est insuffisant pour ce retrait.",
            );
        }

        if (!$soldeModel->retirerMontant((int) $user["id"], (float) $montant)) {
            $db->transRollback();
            return $this->renderClientForm(
                "clients/retrait",
                "Le retrait a échoué pendant le débit.",
            );
        }

        $operationModel = new OperationModel($db);
        if (
            !$operationModel->enregistrerOperation([
                "idOperateur" => $operateur["idOperateur"],
                "idType_operation" => 2,
                "idFrais" => null,
                "idUtilisateur" => (int) $user["id"],
                "date_operation" => $dateOperation,
                "montant" => (float) $montant,
            ])
        ) {
            $db->transRollback();
            return $this->renderClientForm(
                "clients/retrait",
                "Le retrait a échoué lors de l'enregistrement de l'opération.",
            );
        }

        if (!$db->transCommit()) {
            return $this->renderClientForm(
                "clients/retrait",
                "Le retrait a échoué.",
            );
        }

        return view(
            "clients/accueil",
            array_merge($this->getAccueilData(), [
                "success" => "Retrait effectué avec succès.",
            ]),
        );
    }

    public function depot()
    {
        $user = $this->getCurrentUser();

        if (!$user) {
            return redirect()->to("/loginClient");
        }

        $montant = $this->request->getPost("montant");

        if (!is_numeric($montant) || $montant <= 0) {
            return $this->renderClientForm(
                "clients/depot",
                "Le montant est invalide.",
            );
        }

        $operateurModel = new OperateurModel();
        $operateur = $operateurModel->getByTelephone($user["telephone"]);

        if (!$operateur) {
            return $this->renderClientForm(
                "clients/depot",
                "Aucun opérateur ne correspond à votre numéro.",
            );
        }

        $dateOperation = $this->request->getPost("date") ?: date("Y-m-d");

        $db = $this->connectDatabase();
        $db->transBegin();

        $soldeModel = new SoldeModel($db);
        if (!$soldeModel->getByUtilisateurId((int) $user["id"])) {
            $db->transRollback();
            return $this->renderClientForm(
                "clients/depot",
                "Votre compte ne possède pas de solde initialisé.",
            );
        }

        if (!$soldeModel->ajouterMontant((int) $user["id"], (float) $montant)) {
            $db->transRollback();
            return $this->renderClientForm(
                "clients/depot",
                "Le dépôt a échoué pendant le crédit.",
            );
        }

        $operationModel = new OperationModel($db);
        if (
            !$operationModel->enregistrerOperation([
                "idOperateur" => $operateur["idOperateur"],
                "idType_operation" => 1,
                "idFrais" => null,
                "idUtilisateur" => (int) $user["id"],
                "date_operation" => $dateOperation,
                "montant" => (float) $montant,
            ])
        ) {
            $db->transRollback();
            return $this->renderClientForm(
                "clients/depot",
                "Le dépôt a échoué lors de l'enregistrement de l'opération.",
            );
        }

        if (!$db->transCommit()) {
            return $this->renderClientForm(
                "clients/depot",
                "Le dépôt a échoué.",
            );
        }

        return view(
            "clients/accueil",
            array_merge($this->getAccueilData(), [
                "success" => "Dépôt effectué avec succès.",
            ]),
        );
    }
}
