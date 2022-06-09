<?php

use App\Contact;
use Illuminate\Database\Seeder;

class ContactTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Contact::create([
           'name' => 'Ayah',
           'role' => 'Keluarga',
           'phone' => '087899991111',
           'user_id' => 1,
        ]);
        Contact::create([
            'name' => 'Ibu',
            'role' => 'Keluarga',
            'user_id' => 1,
            'phone' => '089582117821',
        ]);
    }
}
