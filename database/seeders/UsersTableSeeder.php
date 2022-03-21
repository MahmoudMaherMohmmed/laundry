<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->delete();

        \DB::table('users')->insert([
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => '$2y$10$u2evAW530miwgUb2jcXkTuqIGswxnSQ3DSmX1Ji5rtO3Tx.MtVcX2',
                'image' => '',
                'phone' => '01202600632',
                'remember_token' => 'Xo89ciaTqGbcUuPS2XLEaGySF3l7N8BC3JNc5qiPIdaju7PFrDPaMtzVziAN',
            ]);
    }
}
