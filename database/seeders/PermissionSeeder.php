<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Limpiar caché de permisos de Spatie
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permisos = [
            // Módulo de Usuarios
            'Ver Usuarios',
            'Crear Usuarios',
            'Editar Usuarios',
            'Eliminar Usuarios',

            // Módulo de Roles y Permisos
            'Ver Roles',
            'Crear Roles',
            'Editar Roles',
            'Eliminar Roles',
            'Asignar Permisos',

            // Módulo de Escaleta y Noticiero
            'Ver Calendario y Escaleta',
            'Crear Notas',
            'Editar Notas',
            'Eliminar Notas',
            'Clonar Notas',
        ];

        // 1. Crear los permisos si no existen
        foreach ($permisos as $permiso) {
            Permission::firstOrCreate(['name' => $permiso, 'guard_name' => 'web']);
        }

        // 2. Buscar el rol SUPER ADMIN y asignarle TODOS los permisos automáticamente
        $rolSuperAdmin = Role::where('name', 'SUPER ADMIN')->first();
        if ($rolSuperAdmin) {
            $rolSuperAdmin->givePermissionTo(Permission::all());
        }
    }
}
