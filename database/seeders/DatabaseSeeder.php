<?php

namespace Database\Seeders;

use App\Models\Categories;
use App\Models\Classes;
use App\Models\Materials;
use App\Models\Teachers;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //User::factory()->create();

        // User::factory()->create([
        //   'name' => 'Test User',
        // 'email' => 'test@example.com',
        //]);

        //=====membuat seeder======

        //pengajar
        $teachers = [
            [
                'teacher_id'    => 1,
                'name'  => 'Janggar Fals',
                'bio'   => 'bio janggar fals',
                'photo_url' => 'http://localhost:8000/storage/teacher/janggar.png'
            ],
            [
                'teacher_id'    => 2,
                'name'  => 'Budi',
                'bio'   => 'bio Budi',
                'photo_url' => 'http://localhost:8000/storage/teacher/budi.png'
            ]
        ];

        foreach ($teachers as $teacher) {
            Teachers::factory()->create($teacher);
        }

        //kategori
        $categories = [
            [
                'category_id'    => 1,
                'name'          => 'PHP',
            ],
            [
                'category_id'    => 2,
                'name'          => 'Node JS',
            ]
        ];

        foreach ($categories as $category) {
            Categories::factory()->create($category);
        }

        $classes = [
            [
                'class_id' => 1,
                'category_id' => 2,
                'teacher_id' => 1,
                'title' => 'Belajar Express.js: Membuat REST API dari Nol',
                'thumbnail_url' => 'http://localhost:8000/storage/class/express.png',
                'description' => 'Pelajari Express.js, framework backend ringan untuk Node.js yang banyak digunakan untuk membangun REST API. Mulai dari routing dasar, middleware, hingga membuat API yang terhubung ke database MongoDB. Cocok untuk kamu yang ingin jadi backend developer modern.',
            ],
            [
                'class_id' => 2,
                'category_id' => 1,
                'teacher_id' => 2,
                'title' => 'Mastering Laravel 11: Dari Routing ke Deployment',
                'thumbnail_url' => 'http://localhost:8000/storage/class/laravel.jpg',
                'description' => 'Kuasai Laravel 11, framework PHP paling populer. Dalam kelas ini, kamu akan belajar fitur terbaru Laravel, seperti route binding, migration, model Eloquent, authentication, hingga teknik deployment ke server. Sangat cocok untuk kamu yang ingin membangun aplikasi web modern dengan PHP.',
            ]

        ];

        foreach ($classes as $class) {
            Classes::factory()->create($class);
        }


        $materials = [
            [
                'material_id'   => 1,
                'class_id'      => 2,
                'title'         => 'Pengenalan Laravel 11',
                'description'   => 'Video ini membahas pengenalan framework Laravel 11, fitur baru, serta perbedaannya dengan versi sebelumnya.',
                'video_url'     => 'https://www.youtube.com/watch?v=your_video_1',
                'external_url'  => 'https://laravel.com/docs/11.x'
            ],
            [
                'material_id'   => 2,
                'class_id'      => 2,
                'title'         => 'Instalasi Laravel 11 & Setup Project',
                'description'   => 'Panduan lengkap menginstall Laravel 11 menggunakan Composer, serta setup awal seperti .env, key, dan server lokal.',
                'video_url'     => 'https://www.youtube.com/watch?v=your_video_2',
                'external_url'  => 'https://laravel.com/docs/11.x'
            ],
            [
                'material_id'   => 3,
                'class_id'      => 1,
                'title'         => 'Pengenalan Express.js',
                'description'   => 'Belajar apa itu Express.js, keunggulannya, dan bagaimana framework ini bekerja dengan Node.js.',
                'video_url'     => 'https://www.youtube.com/watch?v=your_video_1',
                'external_url'  => 'https://expressjs.com'
            ],


        ];
        foreach ($materials as $material) {
            Materials::factory()->create($material);
        }
    }
}
