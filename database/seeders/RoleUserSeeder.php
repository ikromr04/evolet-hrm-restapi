<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'administrator')->first();

        User::whereIn('email', [
            'hr.tjk@evolet.co.uk',
            'loliholmatova@gmail.com',
            'akbarjon.s@evolet.co.uk',
            'mirzoeva.a@evolet.co.uk'
        ])
            ->get()
            ->each(function ($user) use ($adminRole) {
                $user->roles()->sync([$adminRole->id]);
                $user->update(['password' => '3MFuSBji']);
            });
    }
}
