<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('posts')
            ->insert([
                'id' => 'sample-post-id',
                'title' => 'サンプルタイトル',
                'content' => '<h1>サンプルコンテンツ</h1>',
                'posted_at' => '2022-09-02 16:12:30.000000',
                'updated_at' => '2022-09-02 16:12:30.000000',
            ]);
    }
}
