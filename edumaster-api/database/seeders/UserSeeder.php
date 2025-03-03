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
        User::create([
            'user_id' => new UserId(),
            'name' => 'Teacher',
            'email' => 'teacher@edumaster.dev',
            'password' => Hash::make('password'),
            'role' => 'teacher',
        ]);

        User::create([
            'user_id' => new UserId(),
            'name' => 'Student',
            'email' => 'student@edumaster.dev',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);
    }
}
