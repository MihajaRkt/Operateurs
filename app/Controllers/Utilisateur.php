<?php

namespace App\Controllers;

use App\Models\UtilisateurModel;
use App\Models\SoldeModel;

class Utilisateur extends BaseController
{
    public function login()
    {
        $model = new UtilisateurModel();
        $numero = trim($this->request->getPost('numero'));

        if (!preg_match('/^(032|033|034|037|038)[0-9]{7}$/', $numero)) {

            return redirect()->back()
                ->withInput()
                ->with('erreur', 'Numéro de téléphone invalide.');
        }
        $user = $model->where('telephone', $numero)->first();
        if (!$user) {

            return redirect()->back()
                ->withInput()
                ->with('erreur', 'Ce numéro n\'existe pas.');
        }

        session()->set('user', [
            'id' => $user['idUtilisateur'],
            'nom' => $user['nom'],
            'telephone' => $user['telephone'],
        ]);

        // Informations du client
        $soldeModel = new SoldeModel();
        $user = session()->get('user');
        $montant = $soldeModel
            ->where('idUtilisateur', $user['id'])
            ->first();

        return view('clients/accueil', [
            'user'   => $user,
            'solde'  => $montant['montant'],
        ]);
    }

    public function retraitForm()
    {
        return view('clients/retrait');
    }

    public function depotForm()
    {
        return view('clients/depot');
    }

    public function transfertForm()
    {
        return view('clients/transfert');
    }


}
