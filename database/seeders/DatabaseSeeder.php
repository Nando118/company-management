<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Employee;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         \App\Models\User::factory(100)->create();
         \App\Models\Company::factory(2)->create();

         \App\Models\User::factory()->create([
             'name' => 'Admin',
             'email' => 'admin@admin.com',
             'password' => 'password',
         ]);

         $employee = new Employee();
         $employee->first_name = "Fernando";
         $employee->last_name = "Verdy";
         $employee->company_id = 1;
         $employee->email = "fernando.verdy@gmail.com";
         $employee->phone = "089111888222";
         $employee->save();
    }
}
