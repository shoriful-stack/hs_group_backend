<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Model::unguard();
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $modules = Module::firstOrCreate(
            ['name' => 'Dashboard']
        );
        Permission::firstOrCreate(['name' => 'Dashboard', 'module_id' => $modules->id, 'guard_name' => 'web']);

        $modules = Module::firstOrCreate(
            ['name' => 'General Settings']
        );

        Permission::firstOrCreate(['name' => 'All General Settings', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Edit General Settings', 'module_id' => $modules->id, 'guard_name' => 'web']);

        $modules = Module::firstOrCreate(
            ['name' => 'Home Settings']
        );

        Permission::firstOrCreate(['name' => 'All Home Settings', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Edit Home Settings', 'module_id' => $modules->id, 'guard_name' => 'web']);

        $modules = Module::firstOrCreate(
            ['name' => 'Social Links']
        );

        Permission::firstOrCreate(['name' => 'All Social Links', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Add Social Links', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Edit Social Links', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Delete Social Links', 'module_id' => $modules->id, 'guard_name' => 'web']);

        $modules = Module::firstOrCreate(
            ['name' => 'Slider Settings']
        );

        Permission::firstOrCreate(['name' => 'All Slider Settings', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Add Slider Settings', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Edit Slider Settings', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Delete Slider Settings', 'module_id' => $modules->id, 'guard_name' => 'web']);

        $modules = Module::firstOrCreate(
            ['name' => 'Language Settings']
        );

        Permission::firstOrCreate(['name' => 'All Language Settings', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Add Language Settings', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Edit Language Settings', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Delete Language Settings', 'module_id' => $modules->id, 'guard_name' => 'web']);

        $modules = Module::firstOrCreate(
            ['name' => 'Concern Company']
        );

        Permission::firstOrCreate(['name' => 'All Concern Company', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Add Concern Company', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Edit Concern Company', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Delete Concern Company', 'module_id' => $modules->id, 'guard_name' => 'web']);

        $modules = Module::firstOrCreate(
            ['name' => 'Choose Us']
        );

        Permission::firstOrCreate(['name' => 'All Choose Us', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Edit Choose Us', 'module_id' => $modules->id, 'guard_name' => 'web']);

        $modules = Module::firstOrCreate(
            ['name' => 'Privacy Policy']
        );

        Permission::firstOrCreate(['name' => 'All Privacy Policy', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Edit Privacy Policy', 'module_id' => $modules->id, 'guard_name' => 'web']);

        $modules = Module::firstOrCreate(
            ['name' => 'Awards']
        );

        Permission::firstOrCreate(['name' => 'All Awards', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Add Awards', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Edit Awards', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Delete Awards', 'module_id' => $modules->id, 'guard_name' => 'web']);

        $modules = Module::firstOrCreate(
            ['name' => 'Testimonials']
        );

        Permission::firstOrCreate(['name' => 'All Testimonials', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Add Testimonials', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Edit Testimonials', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Delete Testimonials', 'module_id' => $modules->id, 'guard_name' => 'web']);

        $modules = Module::firstOrCreate(
            ['name' => 'Our Core Values']
        );

        Permission::firstOrCreate(['name' => 'All Our Core Values', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Edit Our Core Values', 'module_id' => $modules->id, 'guard_name' => 'web']);

        $modules = Module::firstOrCreate(
            ['name' => 'Our Mission']
        );

        Permission::firstOrCreate(['name' => 'All Our Mission', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Edit Our Mission', 'module_id' => $modules->id, 'guard_name' => 'web']);

        $modules = Module::firstOrCreate(
            ['name' => 'Our Vision']
        );

        Permission::firstOrCreate(['name' => 'All Our Vision', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Edit Our Vision', 'module_id' => $modules->id, 'guard_name' => 'web']);

        $modules = Module::firstOrCreate(
            ['name' => 'Roles']
        );

        Permission::firstOrCreate(['name' => 'All Roles', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Add Roles', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Edit Roles', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Delete Roles', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Permissions Roles', 'module_id' => $modules->id, 'guard_name' => 'web']);

        $modules = Module::firstOrCreate(
            ['name' => 'Users']
        );

        Permission::firstOrCreate(['name' => 'All Users', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Add Users', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Edit Users', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Delete Users', 'module_id' => $modules->id, 'guard_name' => 'web']);

        $modules = Module::firstOrCreate(
            ['name' => 'Blog Categories']
        );

        Permission::firstOrCreate(['name' => 'All Blog Categories', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Add Blog Categories', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Edit Blog Categories', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Delete Blog Categories', 'module_id' => $modules->id, 'guard_name' => 'web']);

        $modules = Module::firstOrCreate(
            ['name' => 'Blogs']
        );

        Permission::firstOrCreate(['name' => 'All Blogs', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Add Blogs', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Edit Blogs', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Delete Blogs', 'module_id' => $modules->id, 'guard_name' => 'web']);

        $modules = Module::firstOrCreate(
            ['name' => 'Blog Tags']
        );

        Permission::firstOrCreate(['name' => 'All Blog Tags', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Add Blog Tags', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Edit Blog Tags', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Delete Blog Tags', 'module_id' => $modules->id, 'guard_name' => 'web']);

        $modules = Module::firstOrCreate(
            ['name' => 'Contact Settings']
        );

        Permission::firstOrCreate(['name' => 'All Contact Settings', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Edit Contact Settings', 'module_id' => $modules->id, 'guard_name' => 'web']);

        $modules = Module::firstOrCreate(
            ['name' => 'Contact Messages']
        );

        Permission::firstOrCreate(['name' => 'All Contact Messages', 'module_id' => $modules->id, 'guard_name' => 'web']);

        $modules = Module::firstOrCreate(
            ['name' => 'Pages']
        );

        Permission::firstOrCreate(['name' => 'All Pages', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Add Pages', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Edit Pages', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Delete Pages', 'module_id' => $modules->id, 'guard_name' => 'web']);

        $modules = Module::firstOrCreate(
            ['name' => 'Gallery Settings']
        );

        Permission::firstOrCreate(['name' => 'All Gallery Settings', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Edit Gallery Settings', 'module_id' => $modules->id, 'guard_name' => 'web']);

        $modules = Module::firstOrCreate(
            ['name' => 'Gallery Categories']
        );

        Permission::firstOrCreate(['name' => 'All Gallery Categories', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Add Gallery Categories', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Edit Gallery Categories', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Delete Gallery Categories', 'module_id' => $modules->id, 'guard_name' => 'web']);

        $modules = Module::firstOrCreate(
            ['name' => 'Galleries']
        );

        Permission::firstOrCreate(['name' => 'All Galleries', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Add Galleries', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Edit Galleries', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Delete Galleries', 'module_id' => $modules->id, 'guard_name' => 'web']);

        $modules = Module::firstOrCreate(
            ['name' => 'Product Categories']
        );

        Permission::firstOrCreate(['name' => 'All Product Categories', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Add Product Categories', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Edit Product Categories', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Delete Product Categories', 'module_id' => $modules->id, 'guard_name' => 'web']);

        $modules = Module::firstOrCreate(
            ['name' => 'Product Origins']
        );

        Permission::firstOrCreate(['name' => 'All Product Origins', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Add Product Origins', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Edit Product Origins', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Delete Product Origins', 'module_id' => $modules->id, 'guard_name' => 'web']);

        $modules = Module::firstOrCreate(
            ['name' => 'Product Brands']
        );

        Permission::firstOrCreate(['name' => 'All Product Brands', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Add Product Brands', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Edit Product Brands', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Delete Product Brands', 'module_id' => $modules->id, 'guard_name' => 'web']);

        $modules = Module::firstOrCreate(
            ['name' => 'Products']
        );

        Permission::firstOrCreate(['name' => 'All Products', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Add Products', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Edit Products', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Delete Products', 'module_id' => $modules->id, 'guard_name' => 'web']);

        $modules = Module::firstOrCreate(
            ['name' => 'Solution Categories']
        );

        Permission::firstOrCreate(['name' => 'All Solution Categories', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Add Solution Categories', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Edit Solution Categories', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Delete Solution Categories', 'module_id' => $modules->id, 'guard_name' => 'web']);

        $modules = Module::firstOrCreate(
            ['name' => 'Solutions']
        );

        Permission::firstOrCreate(['name' => 'All Solutions', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Add Solutions', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Edit Solutions', 'module_id' => $modules->id, 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'Delete Solutions', 'module_id' => $modules->id, 'guard_name' => 'web']);

        $adminRole = \App\Models\Role::query()->find(1);
        if ($adminRole) {
            $adminRole->givePermissionTo([
                'All Testimonials',
                'Add Testimonials',
                'Edit Testimonials',
                'Delete Testimonials',
            ]);
        }
    }
}
