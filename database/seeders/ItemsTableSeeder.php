<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('items')->insert([
            [
                'name' => 'Item A',
                'description' => 'Description for Item A',
                'rate' => 10.00,
            ],
            [
                'name' => 'Item B',
                'description' => 'Description for Item B',
                'rate' => 20.00,
            ],
            [
                'name' => 'Item C',
                'description' => 'Description for Item C',
                'rate' => 30.00,
            ],
        ]);
    }
}
