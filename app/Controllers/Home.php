<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('welcome_message');
        // echo 'Hello, World!';
    }
    public function about()
    {
        // echo 'Halo, nama saya Albert';
        echo "Halo, nama saya $this->nama";
    }
    public function coba()
    {
        echo "ini Controller coba";
    }
}
