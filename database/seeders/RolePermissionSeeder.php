<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Create Permissions
        $permissions = [
            'view_dashboard' => 'Ver dashboard',
            'view_clientes' => 'Ver clientes',
            'create_cliente' => 'Crear cliente',
            'edit_cliente' => 'Editar cliente',
            'delete_cliente' => 'Eliminar cliente',
            'view_cobros' => 'Ver cobros',
            'create_cobro' => 'Crear cobro',
            'edit_cobro' => 'Editar cobro',
            'delete_cobro' => 'Eliminar cobro',
            'register_pago' => 'Registrar pago',
            'view_roles' => 'Ver roles',
            'manage_roles' => 'Gestionar roles',
            'manage_users' => 'Gestionar usuarios',
            'view_portal' => 'Ver portal cliente',
        ];

        foreach ($permissions as $name => $description) {
            Permission::firstOrCreate(['name' => $name], ['description' => $description]);
        }

        // Create Roles
        $adminRole = Role::firstOrCreate(['name' => 'admin'], ['description' => 'Administrador del sistema']);
        $supervisorRole = Role::firstOrCreate(['name' => 'supervisor'], ['description' => 'Supervisor de clientes']);
        $cajeroRole = Role::firstOrCreate(['name' => 'cajero'], ['description' => 'Cajero']);
        $clienteRole = Role::firstOrCreate(['name' => 'cliente'], ['description' => 'Cliente']);

        // Assign permissions to Admin (all permissions)
        $adminRole->permissions()->sync(Permission::pluck('id'));

        // Assign permissions to Supervisor (manage clients and view cobros)
        $supervisorPermissions = Permission::whereIn('name', [
            'view_dashboard',
            'view_clientes',
            'create_cliente',
            'edit_cliente',
            'view_cobros',
        ])->pluck('id');
        $supervisorRole->permissions()->sync($supervisorPermissions);

        // Assign permissions to Cajero
        $cajeroPermissions = Permission::whereIn('name', [
            'view_dashboard',
            'view_clientes',
            'create_cliente',
            'edit_cliente',
            'view_cobros',
            'create_cobro',
            'edit_cobro',
            'register_pago',
        ])->pluck('id');
        $cajeroRole->permissions()->sync($cajeroPermissions);

        // Assign permissions to Cliente
        $clientePermissions = Permission::whereIn('name', [
            'view_portal',
        ])->pluck('id');
        $clienteRole->permissions()->sync($clientePermissions);

        // Assign roles to existing users
        $adminUser = User::where('email', 'eliopinedacog@gmail.com')->first();
        if ($adminUser) {
            $adminUser->roles()->sync([$adminRole->id]);
        }

        $clienteUser = User::where('email', 'matias@example.com')->first();
        if ($clienteUser) {
            $clienteUser->roles()->sync([$clienteRole->id]);
        }
    }
}
