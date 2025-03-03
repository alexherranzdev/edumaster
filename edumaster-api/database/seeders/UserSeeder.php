<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;
use Edumaster\Learning\User\Domain\ValueObject\UserId;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // Crear un usuario profesor
        User::create([
            'user_id' => (new UserId())->value(),
            'name' => 'Teacher',
            'email' => 'teacher@edumaster.dev',
            'password' => Hash::make('password'),
            'role' => 'teacher',
        ]);

        // Crear un usuario estudiante
        User::create([
            'user_id' => (new UserId())->value(),
            'name' => 'Student',
            'email' => 'student@edumaster.dev',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);
    }
}
