<?php

namespace App\Controllers;

use App\Models\CommissionModel;
use App\Models\OperateurModel;
use App\Models\FraisModel;
use App\Models\OperationModel;
use App\Models\PromotionModel;
use App\Models\TypeOperationModel;

use App\Models\UtilisateurModel;

class Operateur extends BaseController
{
    public function login()
    {
        $model = new OperateurModel();
        $numero = $this->request->getPost("numero");

        $user = $model->where("prefixe", $numero)->first();

        if (!$user) {
            return view("auth/login-operateur", [
                "user" => null,
                "error" => "Numero non disponible",
            ]);
        }

        session()->set("user", [
            "id" => $user["idOperateur"],
            "nom" => $user["nom"],
            "numero" => $user["prefixe"],
        ]);

        $fraisModel = new FraisModel();
        $frais = $fraisModel->findAll();

        return view("operateurs/accueil", [
            "frais" => $frais,
            "user" => $user,
        ]);
    }

    public function accueil()
    {
        $user = session()->get("user");
        $fraisModel = new FraisModel();
        $frais = $fraisModel->findAll();

        return view("operateurs/accueil", [
            "frais" => $frais,
            "user" => $user,
        ]);
    }

    public function formFrais()
    {
        return view("operateurs/form-frais");
    }

    public function ajouterFrais()
    {
        $operateur = session()->get("user");

        $fraisModel = new FraisModel();

        $desc = $this->request->getPost("desc");
        $min = $this->request->getPost("min");
        $max = $this->request->getPost("max");
        $montant = $this->request->getPost("montant");

        $data = [
            "description" => $desc,
            "montantMin" => $min,
            "montantMax" => $max,
            "montant" => $montant,
        ];

        $fraisModel->insert($data);

        return redirect()->to("/accueilOperateur");
    }

    public function formModifierFrais($id)
    {
        $fraisModel = new FraisModel();
        $frais = $fraisModel->find($id);

        return view("operateurs/form-frais", [
            "frais" => $frais,
        ]);
    }

    public function modifierFrais($id)
    {
        $fraisModel = new FraisModel();
        $frais = $fraisModel->find($id);

        $desc = $this->request->getPost("desc");
        $min = $this->request->getPost("min");
        $max = $this->request->getPost("max");
        $montant = $this->request->getPost("montant");

        $data = [
            "description" => $desc,
            "montantMin" => $min,
            "montantMax" => $max,
            "montant" => $montant,
        ];

        $fraisModel->update($frais, $data);

        return redirect()->to("/accueilOperateur");
    }

    public function formPrefixe()
    {
        $user = session()->get("user");

        $operateurModel = new OperateurModel();

        $operateurs = $operateurModel
            ->where("operateurs.nom", $user["nom"])
            ->findAll();

        return view("operateurs/form-prefixe", [
            "operateurs" => $operateurs,
            "user" => $user,
        ]);
    }

    public function ajouterPrefixe()
    {
        $user = session()->get("user");

        $operateurModel = new OperateurModel();

        $prefixe = $this->request->getPost("prefixe");

        $data = [
            "prefixe" => $prefixe,
            "nom" => $user["nom"],
        ];

        $operateurs = $operateurModel
            ->where("operateurs.nom", $user["nom"])
            ->findAll();

        $roles = array_column($operateurs, "prefixe");

        if (!in_array($prefixe, $roles, true)) {
            $operateurModel->insert($data);
        }

        return redirect()->to("/ajouterPrefixe");
    }

    public function afficherGain($nom)
    {
        $operationModel = new OperationModel();
        $details = $operationModel->getDetailsOperations($nom);

        $somme = $operationModel->getGain($nom);

        return view("operateurs/gain", [
            "details" => $details,
            "somme" => $somme,
        ]);
    }

    public function afficherClients($nom)
    {
        $operationModel = new OperationModel();
        $details = $operationModel->getUtilisateurs($nom);

        return view("operateurs/clients", [
            "details" => $details,
        ]);
    }

    public function afficherGainsSepare()
    {
        $user = session()->get("user");

        $typeModel = new TypeOperationModel();
        $type = $typeModel->findAll();

        $operationModel = new OperationModel();
        $details = $operationModel->getGainOperateur();
        $transferts = $operationModel->getGainFiltre(3, $user["nom"]);

        $somme = $operationModel->getGain($user["nom"]);

        $commissionModel = new CommissionModel();
        $commission = $commissionModel->getByOperateurId($user["id"]);

        return view("operateurs/situation", [
            "somme" => $somme,
            "types" => $type,
            "details" => $details,
            "transferts" => $transferts,
            "commission" => $commission["pourcentage"] ?? 0,
        ]);
    }

    public function filtrerGain()
    {
        $user = session()->get("user");
        $id = $this->request->getPost("categorie");

        $typeModel = new TypeOperationModel();
        $type = $typeModel->findAll();

        $operationModel = new OperationModel();

        $details = $operationModel->getGainOperateur();
        $transferts = $operationModel->getGainFiltre(3, $user["nom"]);

        $somme = $operationModel->getGain($user["nom"]);

        $commissionModel = new CommissionModel();
        $commission = $commissionModel->getByOperateurId($user["id"]);

        if ($id != null) {
            if ($id == "all") {
                $details = $operationModel->getGainOperateur();
            } else {
                $details = $operationModel->getGainFiltre($id, $user["nom"]);
                $somme = $operationModel->getGainByFrais($id, $user["nom"]);
            }
        }

        return view("operateurs/situation", [
            "details" => $details,
            "types" => $type,
            "somme" => $somme,
            "transferts" => $transferts,
            "commission" => $commission["pourcentage"] ?? 0,
        ]);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to("/");
    }

    public function commission()
    {
        $user = session()->get("user");

        if (!$user) {
            return redirect()->to("/loginOperateur");
        }

        $model = new CommissionModel();
        $comm = $model->getByOperateurId((int) $user["id"]);

        return view("operateurs/commission", [
            "user" => $user,
            "commission" => $comm,
            "pourcentage" => $comm["pourcentage"] ?? 0,
        ]);
    }

    public function promotion()
    {
        $user = session()->get("user");

        if (!$user) {
            return redirect()->to("/loginOperateur");
        }

        $model = new PromotionModel();
        $comm = $model->where("idPromotion", 1)->first();

        return view("operateurs/promotion", [
            "user" => $user,
            "promotion" => $comm,
            "pourcentage" => $comm["pourcentage"] ?? 0,
        ]);
    }

    public function modifierCommission()
    {
        $user = session()->get("user");

        if (!$user) {
            return redirect()->to("/loginOperateur");
        }

        $pourcentage = $this->request->getPost("pourcentage");

        if (
            !is_numeric($pourcentage) ||
            $pourcentage < 0 ||
            $pourcentage > 100
        ) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    "erreur",
                    "La commission doit être comprise entre 0 et 100.",
                );
        }

        $model = new CommissionModel();
        if (!$model->saveCommission((int) $user["id"], (float) $pourcentage)) {
            return redirect()
                ->back()
                ->withInput()
                ->with("erreur", "La mise à jour de la commission a échoué.");
        }

        return redirect()
            ->to("/voirCommission")
            ->with("success", "Commission mise à jour avec succès.");
    }

    public function modifierPrommotion()
    {
        $user = session()->get("user");

        if (!$user) {
            return redirect()->to("/loginOperateur");
        }

        $pourcentage = $this->request->getPost("pourcentage");

        if (
            !is_numeric($pourcentage) ||
            $pourcentage < 0 ||
            $pourcentage > 100
        ) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    "erreur",
                    "La commission doit être comprise entre 0 et 100.",
                );
        }

        $model = new PromotionModel();
        if (!$model->savePromm((float) $pourcentage)) {
            return redirect()
                ->back()
                ->withInput()
                ->with("erreur", "La mise à jour de la commission a échoué.");
        }

        return redirect()
            ->to("/voirPrommotion")
            ->with("success", "Prommotion mise à jour avec succès.");
    }

    public function historique($id)
    {
        $utilisateurModel = new UtilisateurModel();
        $user = $utilisateurModel->find($id);

        $operationModel = new OperationModel();
        $operations = $operationModel->getHistoriqueByUtilisateur(
            (int) $user["idUtilisateur"],
        );

        return view("operateurs/historique", [
            "user" => $user,
            "operations" => $operations,
        ]);
    }
}
