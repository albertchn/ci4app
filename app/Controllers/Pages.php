<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function index()
    {
        // use the factory to create a Faker\Generator instance
        // $faker = \Faker\Factory::create();
        $data = [
            'title' => 'Home'
        ];
        // echo view('/layout/header', $data);
        return view('pages/home', $data);
        // echo view('/layout/footer');
    }
    public function about()
    {
        $data = [
            'title' => 'About Me'
        ];
        // echo view('/layout/header', $data);
        return view('pages/about', $data);
        // echo view('/layout/footer');s
    }
    public function contact()
    {
        $data = [
            'title' => 'Contact Me',
            'alamat' => [
                [
                    'tipe' => 'Rumah',
                    'alamat' => 'Jln. Menteng No. 1',
                    'kota' => 'DKI Jakarta'
                ],
                [
                    'tipe' => 'Kantor',
                    'alamat' => 'Jln. Jendral Sudirman No. Kav 58',
                    'kota' => 'DKI Jakarta'
                ]
            ]
        ];

        return view('pages/contact', $data);
    }
}
