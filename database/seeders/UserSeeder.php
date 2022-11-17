<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Generator as Faker;

class UserSeeder extends Seeder
{
    public $fake;

    public function __construct(Faker $faker)
    {
            $this->fake = $faker;
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rolePermissionConfig = config('role-permission', []);
        foreach($rolePermissionConfig as $role => $permissions) {
            $roleInfo = Role::findByName($role);

            $user = User::create([
                'role_id' => $roleInfo->id,
                'name' => Str::headline($role),
                'email' => $role.'@project.com',
                'username' => $role.rand(1111,9999),
                'phone' => rand(1111111111, 9999999999),
                // 'user_type' => $role,
                'image_url' => $this->fake->image(),
                // 'email_verified_at' => \Carbon\Carbon::now(),
                'password' => bcrypt('password'),
                'is_org_admin' => 1
            ]);

            $user->assignRole($role);
        }

        $this->command->info('User have been seeded');
    }
}
