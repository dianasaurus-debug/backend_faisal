<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Faisal',
            'email' => 'faisal@gmail.com',
            'phone' => '083162937284',
            'bb' => '65',
            'tb' => '170',
            'usia' => '22',
            'gender' => 'L',
            'alamat' => 'Desa Soko, Kab. Tuban',
            'password' => Hash::make('password')
        ]);
    }
}
