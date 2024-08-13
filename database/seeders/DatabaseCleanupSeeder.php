<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseCleanupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('activity_logs')->truncate();
        DB::table('albums')->truncate();
        DB::table('article_categories')->truncate();
        DB::table('articles')->truncate();
        DB::table('banners')->truncate();
        DB::table('email_recipients')->truncate();
        DB::table('failed_jobs')->truncate();
        DB::table('menu_has_pages')->truncate();
        DB::table('menus')->truncate();
        DB::table('migrations')->truncate();
        DB::table('options')->truncate();
        DB::table('pages')->truncate();
        DB::table('password_resets')->truncate();
        DB::table('permissions')->truncate();
        DB::table('personal_access_tokens')->truncate();
        DB::table('role_permission')->truncate();
        DB::table('roles')->truncate();
        DB::table('settings')->truncate();
        DB::table('social_media')->truncate();
        DB::table('users')->truncate();
        
    }
}
