<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            SettingSeeder::class,
            MenuSeeder::class,
            MenusHasPagesSeeder::class,
            PageSeeder::class,
            AlbumSeeder::class,
            ArticleSeeder::class,
            RoleSeeder::class,
            OptionSeeder::class,
            BannerSeeder::class,

        ]);

        $this->users();
    }



    private function users()
    {
        $users = [
            [
                'name' => 'Admin Istrator',
                'firstname' => 'admin',
                'lastname' => 'istrator',
                'email' => 'wsiprod.demo@gmail.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
                'role_id' => 1,
                'is_active' => 1,
                'user_id' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
                'mobile' => '09456714321',
                'phone' => '022646545',
                'address_street' => 'Maharlika St',
                'address_city' => 'Pasay',
                'address_zip' => '1234'
            ]
        ];

        DB::table('users')->insert($users);

    }
}
