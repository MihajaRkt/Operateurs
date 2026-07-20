<?php

namespace App\Controllers;

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
        $frais = $fraisModel->getFraisByMontant($montant);

        if (!$frais) {
            return $this->renderClientForm(
                "clients/transfert",
                "Aucun frais ne correspond à ce montant.",
            );
        }

        $montant = (float) $montant;
        $montantTotal = $montant + (float) $frais["montant"];

        $operateurModel = new OperateurModel();
        $operateur = $operateurModel->getByTelephone($user["telephone"]);

        if (!$operateur) {
            return $this->renderClientForm(
                "clients/transfert",
                "Aucun opérateur ne correspond à votre numéro.",
            );
        }

        $dateOperation = $this->request->getPost("date") ?: date("Y-m-d");

        $db = \Config\Database::connect();
        $db->transBegin();

        $soldeModel = new SoldeModel();
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

        $soldeModel->retirerMontant((int) $user["id"], $montantTotal);
        $soldeModel->ajouterMontant(
            (int) $destinataire["idUtilisateur"],
            $montant,
        );

        $operationModel = new OperationModel();
        $operationModel->enregistrerOperation([
            "idOperateur" => $operateur["idOperateur"],
            "idType_operation" => 3,
            "idFrais" => $frais["idFrais"],
            "idUtilisateur" => (int) $user["id"],
            "date_operation" => $dateOperation,
            "montant" => $montant,
        ]);

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

        $db = \Config\Database::connect();
        $db->transBegin();

        $soldeModel = new SoldeModel();
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

        $soldeModel->retirerMontant((int) $user["id"], (float) $montant);

        $operationModel = new OperationModel();
        $operationModel->enregistrerOperation([
            "idOperateur" => $operateur["idOperateur"],
            "idType_operation" => 2,
            "idFrais" => null,
            "idUtilisateur" => (int) $user["id"],
            "date_operation" => $dateOperation,
            "montant" => (float) $montant,
        ]);

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

        $db = \Config\Database::connect();
        $db->transBegin();

        $soldeModel = new SoldeModel();
        if (!$soldeModel->getByUtilisateurId((int) $user["id"])) {
            $db->transRollback();
            return $this->renderClientForm(
                "clients/depot",
                "Votre compte ne possède pas de solde initialisé.",
            );
        }

        $soldeModel->ajouterMontant((int) $user["id"], (float) $montant);

        $operationModel = new OperationModel();
        $operationModel->enregistrerOperation([
            "idOperateur" => $operateur["idOperateur"],
            "idType_operation" => 1,
            "idFrais" => null,
            "idUtilisateur" => (int) $user["id"],
            "date_operation" => $dateOperation,
            "montant" => (float) $montant,
        ]);

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
