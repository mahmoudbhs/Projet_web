<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $emails = [
            'myrasaid@admin.com',
            'mahmoudbhs@admin.com',
            'abdeldjalil@admin.com',
            'wilem@admin.com',
        ];

        User::whereIn('email', $emails)->update([
            'role' => 'admin',
        ]);
    }
}
