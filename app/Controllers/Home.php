<?php

namespace App\Controllers;

use App\Models\SoldeModel;

class Home extends BaseController
{
    public function index()
    {
        return view('index');
    }

    public function operateur()
    {
        return view('auth/login-operateur');
    }

    public function client()
    {
        return view('auth/login-client');
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

    public function accueil()
    {
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
}
