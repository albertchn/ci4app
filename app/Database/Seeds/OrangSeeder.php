<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class OrangSeeder extends Seeder
{
    public function run()
    {
        // $data = [
        //     [
        //         'nama' => 'Albert Darwin',
        //         'alamat'    => 'Jl. ABC No. 11',
        //         'created_at' => Time::now('GMT+7'),
        //         'updated_at' => Time::now('GMT+7'),
        //     ],
        //     [
        //         'nama' => 'Albert Christian',
        //         'alamat'    => 'Jl. Mangga No. 1',
        //         'created_at' => Time::now('GMT+7'),
        //         'updated_at' => Time::now('GMT+7'),
        //     ],
        //     [
        //         'nama' => 'Charles Darwin',
        //         'alamat'    => 'Jl. Dago No. 33',
        //         'created_at' => Time::now('GMT+7'),
        //         'updated_at' => Time::now('GMT+7'),
        //     ],
        // ];
        // use the factory to create a Faker\Generator instance
        $faker = \Faker\Factory::create('id_ID');
        for ($i = 0; $i < 500; $i++) {
            $data = [
                'nama' => $faker->name,
                'alamat'    => $faker->address,
                'created_at' => Time::createFromTimestamp($faker->unixTime(), 'GMT+7'),
                'updated_at' => Time::now('GMT+7'),
            ];
            $this->db->table('orang')->insert($data);
        }

        // Simple Queries
        // $this->db->query('INSERT INTO orang (nama, alamat, created_at, updated_at) VALUES(:nama:, :alamat:, :created_at:, :updated_at:)', $data);

        // Using Query Builder
        // $this->db->table('orang')->insert($data);
        // $this->db->table('orang')->insertBatch($data);
    }
}
