<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // إنشاء دور admin لو مش موجود
        if(!Role::where('name','admin')->exists()){
            Role::create(['name'=>'admin']);
        }

        // إنشاء admin
        if(!User::where('email','admin@gmail.com')->exists()){
            $user = User::create([
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('pass123456'),
            ]);

            $user->assignRole('admin');
        }
    }
}
