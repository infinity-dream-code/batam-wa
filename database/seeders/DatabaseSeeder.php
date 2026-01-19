<?php

namespace Database\Seeders;

use App\Models\master_data\mst_kelas;
use App\Models\master_data\mst_post;
use App\Models\master_data\mst_siswa;
use Illuminate\Support\Facades\DB;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Faker\Generator as Faker;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        // reset cahced roles and permission
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        //make permission

        //untuk membuka dashboard
        Permission::create(['name' => 'admin-read']);
        Permission::create(['name' => 'admin-write']);
        //untuk membuka dashboard admin cms
        //make role
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo('admin-read');
        $adminRole->givePermissionTo('admin-write');

        $siswaRole = Role::create(['name' => 'siswa']);
        // gets all permissions via Gate::before rule

        // create demo users

        $user = User::factory()->create([
            'username' => 'admin',
            'name' => 'Example admin user',
            'email' => 'admin@amarta.com',
            'password' => bcrypt('qwerty')
        ]);
        $user->assignRole($adminRole);


        // $agama = ['islam', 'budha', 'kristen', 'hindu', 'katolik'];
        // $minDate = '2015-01-01';
        // $maxDate = '2016-12-31';

        // for ($i = 1; $i <= 300; $i++) {
        //     $randomKey = array_rand($agama);
        //     $randomDate = fake()->dateTimeBetween($minDate, $maxDate);
        //     $randomName = fake()->name;
        //     $prefix = str_pad($i, 4, '0', STR_PAD_LEFT);
        //     $nis = 123 . $prefix;
        //     $user = User::create(
        //         [
        //             'username' => $nis,
        //             'password' => bcrypt($nis),
        //             'login_token' => Str::random(50),
        //             'name' => $randomName,
        //         ]
        //     );

        //     $user->assignRole('siswa');
        // }
    }
    /**
     * Seed the application's database.
     */
    //    public function run(): void
    //    {
    //        $this->user();
    //        $this->role();
    //        $this->category();
    ////        $this->product();
    //    }
    //
    //    private function user()
    //    {
    //        User::updateOrCreate(
    //            [
    //                'username' => 'admin',
    //                'email' => 'admin@admin.com',
    //            ],
    //            [
    //                'name' => 'Admin',
    //                'username' => 'admin',
    //                'email' => 'admin@admin.com',
    //                'role_id' => 1,
    //                'password' => bcrypt('qwerty')
    //            ]
    //        );
    //
    //        User::updateOrCreate(
    //            [
    //                'username' => 'admin-trial',
    //                'email' => 'admin-trial@admin.com',
    //            ],
    //            [
    //                'name' => 'Admin Trial',
    //                'username' => 'admin-trial',
    //                'email' => 'admin-trial@admin.com',
    //                'role_id' => 2,
    //                'password' => bcrypt('qwerty')
    //            ]
    //        );
    //    }
    //
    //    private function role()
    //    {
    //        Role::updateOrCreate([
    //            'name' => 'admin',
    //        ], [
    //            'name' => 'admin',
    //            'permissions' => json_encode([
    //                [
    //                    'key' => 'roles',
    //                    'access' => ['create', 'read', 'update', 'delete']
    //                ]
    //            ])
    //        ]);
    //
    //
    //        Role::updateOrCreate([
    //            'name' => 'admin-trial',
    //        ], [
    //            'name' => 'admin-trial',
    //            'permissions' => json_encode([
    //                [
    //                    'key' => 'roles',
    //                    'access' => ['create', 'read', 'update', 'delete']
    //                ]
    //            ])
    //        ]);
    //    }
    //
    //
    //
    //    private function category()
    //    {
    //        for ($i = 1; $i <= 10; $i++) {
    //            Kategori_berita::updateOrCreate(
    //                [
    //                    'name' => 'Category ' . $i,
    //                ],
    //                [
    //                    'name' => 'Category ' . $i,
    //                ]
    //            );
    //        }
    //    }

    //    private function product()
    //    {
    //        $arrSku = ['pcs', 'kg', 'm'];
    //
    //        for ($i = 1; $i <= 30; $i++) {
    //            Product::updateOrCreate(
    //                [
    //                    'code' => 'PRD-' . $i,
    //                ],
    //                [
    //                    'code' => 'PRD-' . $i,
    //                    'name' => 'Product ' . $i,
    //                    'sku' => $arrSku[rand(0, 2)],
    //                    'description' => 'Deskripsi produk ' . $i,
    //                    'price' => rand(10000, 200000),
    //                    'category_id' => rand(1, 10)
    //                ]
    //            );
    //        }
    //    }
}
