<?php
 
namespace Database\Seeders;
 
use Illuminate\Database\Seeder;
use App\Models\User;
 
class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'email-admin-anda@gmail.com'],
            [
                'name' => 'Nama Anda',
                'password' => 'password-admin-anda',
                'role' => 'admin',
            ]
        );
    }
}
