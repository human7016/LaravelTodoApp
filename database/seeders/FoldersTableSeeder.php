<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Folder;
use App\Models\User;

class FoldersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::first(); // ★外部キー設定
        $titles = ['プライベート', '仕事', '旅行'];

        foreach ($titles as $title) {
            Folder::insert([
                'title' => $title,
                'user_id' => $user->id, // ★
            ]);
        }
    }
}
