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
        $data = [
            [
                'name' => 'Admin',
                'email' => 'admin123@gmail.com',
                'sdt' => '0989895802',
                'password' => bcrypt('admin123'),
                'is_admin' => '1',
                'yeuthich' => '0',
                'phantram' => '0',
            ],
        ];
        DB::table('users')->insert($data);
    }
}
