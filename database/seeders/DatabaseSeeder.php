<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
{
    $roles = ['admin', 'secretaire', 'chef_de_service', 'directeur'];
    
    foreach($roles as $role) {
        User::factory()->create([
            'name' => ucfirst($role),
            'email' => "$role@cnss.cd",
            'password' => bcrypt('password'),
            'role' => $role,
        ]);
    }
}
}
