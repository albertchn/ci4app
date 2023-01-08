<?php

namespace App\Controllers;

class Coba extends BaseController
{
    public function index()
    {
        echo 'Ini Controller Coba method index!';
    }
    public function coba()
    {
        echo 'hello ini method coba';
    }
    public function about($nama = '', $umur = 0)
    {
        echo "hello $nama, umur sya $umur tahun";
    }
}
