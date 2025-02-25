<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController
{
    public function configuracoes(){

        return view('configuracoes.settings');

    }
}
