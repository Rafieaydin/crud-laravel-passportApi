<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('post')->insert([
            'title'=>'Post 1',
            'content'=>'Content Post 1',
            'image'=>'image1.jpg',
            'user_id'=>1,
            'role'=>1
        ]);
    }
}
