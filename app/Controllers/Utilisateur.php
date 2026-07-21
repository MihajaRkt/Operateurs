<?php

namespace App\Controllers;

use App\Models\CommissionModel;
use App\Models\FraisModel;
use App\Models\UtilisateurModel;
use App\Models\SoldeModel;
use App\Models\OperateurModel;
use App\Models\OperationModel;
use App\Models\PromotionModel;
use App\Models\EpargneModel;
class Utilisateur extends BaseController
{
    private function connectDatabase()
    {
        return \Config\Database::connect();
    }

    private function renderClientForm(string $view, string $message = "")
    {
        return view($view, [
            "erreur" => $message,
            "user" => session()->get("user"),
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

        return redirect()->to('/accueil');
    }

    public function historique()
    {
        $user = session()->get("user");

        if (!$user) {
            return redirect()->to("/loginClient");
        }

        $operationModel = new OperationModel();
        $operations = $operationModel->getHistoriqueByUtilisateur(
            (int) $user["id"],
        );

        $model = new PromotionModel();
        $promotion = $model->where("idPromotion", 1)->first();
        $pourcentagePromotion = $promotion["pourcentage"];

        $epargneModel= new EpargneModel();
        $epargne= $epargneModel -> getEpargneByClient($user["id"]);

        return view("clients/historique", [
            "user" => $user,
            "operations" => $operations,
            "promotion" => $pourcentagePromotion,
        ]);
    }

    public function epargne()
    {
        $user = session()->get("user");

        if (!$user) {
            return redirect()->to("/loginClient");
        }

        $epargneModel = new EpargneModel();
        $epargne = $epargneModel->getEpargneByClient($user["id"]);

        if ($epargne != null) {
            return view("clients/epargne", [
                'epargne' => $epargne
            ]);
        }

        return view("clients/epargne");
    }

    public function modifierEpargne()
    {
        $user = session()->get("user");

        $epargneModel = new EpargneModel();
        $epargne = $epargneModel->getEpargneByClient($user["id"]);

        $ep = 0;
        foreach ($epargne as $e) {
            $ep = $epargneModel->find($e["idEpargne"]);
        }

        $pct = $this->request->getPost("pourcentage");

        $data = [
            "pourcentage" => $pct,
        ];

        $epargneModel->update($ep, $data);

        return redirect()->to("/epargne");
    }

    public function transfert()
    {
        $user = session()->get("user");
        $utilisateurModel = new UtilisateurModel();
        $operateurModel = new OperateurModel();
        $operationModel = new OperationModel();

        $montant = $this->request->getPost("montant");
        if (!is_numeric($montant) || $montant <= 0) {
            return $this->renderClientForm(
                "clients/transfert",
                "Le montant est invalide.",
            );
        }

        // Parsing des numéros (virgule, point-virgule ou saut de ligne)
        $numerosRaw = trim($this->request->getPost("numeros") ?? "");
        $numeros = array_values(
            array_unique(
                array_filter(
                    array_map("trim", preg_split("/[\s,;]+/", $numerosRaw)),
                ),
            ),
        );

        if (empty($numeros)) {
            return $this->renderClientForm(
                "clients/transfert",
                "Veuillez indiquer au moins un numéro.",
            );
        }

        foreach ($numeros as $num) {
            if (!preg_match('/^(032|033|034|037|038)[0-9]{7}$/', $num)) {
                return $this->renderClientForm(
                    "clients/transfert",
                    "Le numéro $num est invalide.",
                );
            }
            if ($num === $user["telephone"]) {
                return $this->renderClientForm(
                    "clients/transfert",
                    "Vous ne pouvez pas transférer vers votre propre numéro.",
                );
            }
            if (count($numeros) > 1 && !$utilisateurModel->sameOperateur($user["telephone"], $num)) {
                return $this->renderClientForm(
                    "clients/transfert",
                    "Envoi multiple : le numéro $num n'est pas du même opérateur.",
                );
            }
        }

        $montant = (float) $montant;
        $montantParPersonne = round($montant / count($numeros), 2);
        $montantTotal = 0;

        $fraisModel = new FraisModel();
        $frais = $fraisModel->getFraisByMontant($montant, 3);
        if (!$frais) {
            return $this->renderClientForm(
                "clients/transfert",
                "Aucun frais ne correspond à ce montant.",
            );
        }

        $operateur = $operateurModel->getByTelephone($user["telephone"]);
        if (!$operateur) {
            return $this->renderClientForm(
                "clients/transfert",
                "Aucun opérateur ne correspond à votre numéro.",
            );
        }

        // Calcul du total à débiter
        if (count($numeros) > 1) {
            $sameOperateur = true; // déjà validé ci-dessus

        } else {
            $sameOperateur = $utilisateurModel->sameOperateur(
                $user["telephone"],
                $numeros[0],
            );
            if (!$sameOperateur) {
                $commissionModel = new CommissionModel();
                $comm = $commissionModel->getByOperateurId(
                    $operateur["idOperateur"],
                );
                $commission = $comm ? $montant * ((float) $comm["pourcentage"] / 100) : 0.0;
                $montantTotal = $montant + (float) $frais["montant"] + $commission;
            } else {
                $model = new PromotionModel();
                $promotion = $model->where("idPromotion", 1)->first();
                $pourcentagePromotion = $promotion["pourcentage"];

                $fraisPromotion = $frais["montant"] * ($pourcentagePromotion / 100);
                $montantTotal = $montant + (float) $fraisPromotion;
            }
        }

        // Option : frais de retrait du destinataire (même opérateur uniquement)
        $inclureFraisRetrait = $this->request->getPost("inclure_frais_retrait") === "1";
        if ($sameOperateur && $inclureFraisRetrait) {
            $fraisRetrait = $fraisModel->getFraisByMontant($montantParPersonne, 2);
            if ($fraisRetrait) {
                $montantTotal += (float) $fraisRetrait["montant"] * count($numeros);
            }
        }

        // --- Transaction : uniquement des écritures ---
        $db = $this->connectDatabase();
        $db->transBegin();

        $soldeModel = new SoldeModel();
        $soldeActuelle = $soldeModel->getByUtilisateurId((int) $user["id"]);

        if ((float) $soldeActuelle["montant"] < $montantTotal) {
            $db->transRollback();
            return $this->renderClientForm(
                "clients/transfert",
                "Votre solde est insuffisant pour ce transfert.",
            );
        }

        $soldeModel->retirerMontant((int) $user["id"], $montantTotal);

        $dateOperation = $this->request->getPost("date") ?: date("Y-m-d");

        foreach ($numeros as $num) {
            $operationModel->enregistrerOperation([
                "idOperateur" => $operateur['idOperateur'],
                "idType_operation" => 3,
                "idFrais" => $frais["idFrais"],
                "idUtilisateur" => (int) $user["id"],
                "date_operation" => $dateOperation,
                "destinataire" => $num,
                "montant" => (float) $montantTotal,
            ]);
        }

        if (!$db->transCommit()) {
            return $this->renderClientForm(
                "clients/transfert",
                "Le transfert a échoué.",
            );
        }

        return redirect()->to('/accueil');
    }

    public function retrait()
    {
        $user = session()->get("user");

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

        if (!$soldeActuelle || (float) $soldeActuelle["montant"] < (float) $montant) {
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

        return redirect()->to('/accueil');
    }

    public function depot()
    {
        $user = session()->get("user");

        $montant = $this->request->getPost("montant");

        if (!is_numeric($montant) || $montant <= 0) {
            return $this->renderClientForm(
                "clients/depot",
                "Le montant est invalide.",
            );
        }

        $operateurModel = new OperateurModel();
        $operateur = $operateurModel->getByTelephone($user["telephone"]);

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

        return redirect()->to('/accueil');
    }
}
