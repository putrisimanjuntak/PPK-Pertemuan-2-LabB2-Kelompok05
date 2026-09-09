<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. User default untuk testing Programmer A & B
        $user = User::firstOrCreate(
            ['email' => 'dev@jara.com'],
            [
                'name'     => 'Programmer A',
                'password' => Hash::make('password123'),
                'role'     => 'user',
            ]
        );

        // 2. Tiga Proyek Bawaan (Memenuhi SRS-003: minimal 3 opsi)
        $defaultProjects = ['Kuliah', 'Pribadi', 'Pekerjaan'];
        foreach ($defaultProjects as $projName) {
            Project::firstOrCreate(
                ['name' => $projName],
                [
                    'user_id'     => $user->id,
                    'description' => 'Kategori bawaan sistem'
                ]
            );
        }
    }
}