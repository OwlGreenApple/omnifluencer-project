<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      // $this->call(UsersTableSeeder::class);
      DB::table('users')->insert([
        'name' => 'Puspitasari Nurhidayati',
        'email' => 'puspita.celebgramme@gmail.com',
        'username' => '',
        'password' => bcrypt('cobadeh'),
        'gender'=> 0, //female
        'point' => 0,
        'is_admin' => 1, //admin
        'is_confirm' => 1,
        'confirm_code' => null,
        'last_login' => null,
        'membership' => 'premium', 
        'referral_link' => null,
      ]);

      DB::table('users')->insert([
        'name' => 'Rizky R',
        'email' => 'celebgramme.dev@gmail.com',
        'username' => '',
        'password' => bcrypt('admin888'),
        'gender'=> 1, //male
        'point' => 0,
        'is_admin' => 0, //user
        'is_confirm' => 1,
        'confirm_code' => 'tes'.uniqid(),
        'last_login' => null,
        'membership' => 'premium', 
        'referral_link' => uniqid(),
      ]);

      DB::table('users')->insert([
        'name' => 'Michael',
        'email' => 'michaelsugih@gmail.com',
        'username' => '',
        'password' => bcrypt('admin888'),
        'gender'=> 1, //male
        'point' => 0,
        'is_admin' => 0, //user
        'is_confirm' => 1,
        'confirm_code' => 'tes'.uniqid(),
        'last_login' => null,
        'membership' => 'premium',
        'referral_link' => uniqid(),
      ]);

      DB::table('users')->insert([
        'name' => 'Puspitasari N',
        'email' => 'puspitanurhidayati@gmail.com',
        'username' => '',
        'password' => bcrypt('cobadeh'),
        'gender'=> 0, //female
        'point' => 0,
        'is_admin' => 0, //user
        'is_confirm' => 1,
        'confirm_code' => 'tes'.uniqid(),
        'last_login' => null,
        'membership' => 'premium',
        'referral_link' => uniqid(),
      ]);
    }
}
