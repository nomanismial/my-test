<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Admin::create([
            'name' => 'admin',
            'slug' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456789'),
            'slug' => _encrypt('admin'),
            's_image' => _encrypt('7FME82KR74'),
            'enc' => _encrypt('123456789'),
            'status' => 'on',
            'tries' => 0,
            'updated_at' => date("Y-m-d G:i:s"),
            'created_at' => date("Y-m-d G:i:s")
        ]);
    }
}
