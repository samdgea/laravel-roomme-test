<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->truncateUser();

        $superAdmin = User::create([
            'first_name' => 'Abdilah',
            'last_name' => 'Sammi',
            'email' => 'hello@abdilah.id',
            'password' => Hash::make('password'),
            'is_active' => true
        ]);

        $disabledAccount = User::create([
            'first_name' => 'Disabled',
            'last_name' => 'Account',
            'email' => 'disabled-account@abdilah.id',
            'password' => Hash::make('password'),
            'is_active' => false
        ]);

        $noAccessAccount = User::create([
            'first_name' => 'No Access',
            'last_name' => 'Account',
            'email' => 'no-access-account@abdilah.id',
            'password' => Hash::make('password'),
            'is_active' => true
        ]);

        $superAdmin->assignRole('Administrator');
    }

    private function truncateUser()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        DB::table('model_has_roles')->truncate();
        User::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
