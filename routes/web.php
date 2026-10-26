<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

//rutas para el admin
Route::get('/dashboard', function (){ return redirect()->route('admin.index'); })->name('dashboard')->middleware('auth');

Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index')->middleware('auth');

// ==========================================
// RUTAS PARA ROLES Y PERMISOS (Protegidas)
// ==========================================
Route::get('/admin/roles', [App\Http\Controllers\RoleController::class, 'index'])
    ->name('admin.roles.index')
    ->middleware(['auth', 'permission:Ver Roles']);

Route::get('/admin/roles/create', [App\Http\Controllers\RoleController::class, 'create'])
    ->name('admin.roles.create')
    ->middleware(['auth', 'permission:Crear Roles']);

Route::post('/admin/roles/create', [App\Http\Controllers\RoleController::class, 'store'])
    ->name('admin.roles.store')
    ->middleware(['auth', 'permission:Crear Roles']);

Route::get('/admin/rol/{id}', [App\Http\Controllers\RoleController::class, 'show'])
    ->name('admin.roles.show')
    ->middleware(['auth', 'permission:Ver Roles']);

Route::get('/admin/rol/{id}/edit', [App\Http\Controllers\RoleController::class, 'edit'])
    ->name('admin.roles.edit')
    ->middleware(['auth', 'permission:Editar Roles']);

Route::get('/admin/rol/{id}/permisos', [App\Http\Controllers\RoleController::class, 'permisos'])
    ->name('admin.roles.permisos')
    ->middleware(['auth', 'permission:Asignar Permisos']);

Route::put('/admin/rol/{id}/update_permisos', [App\Http\Controllers\RoleController::class, 'updatePermisos'])
    ->name('admin.roles.updatePermisos')
    ->middleware(['auth', 'permission:Asignar Permisos']);

Route::put('/admin/rol/{id}', [App\Http\Controllers\RoleController::class, 'update'])
    ->name('admin.roles.update')
    ->middleware(['auth', 'permission:Editar Roles']);

Route::delete('/admin/rol/{id}', [App\Http\Controllers\RoleController::class, 'destroy'])
    ->name('admin.roles.destroy')
    ->middleware(['auth', 'permission:Eliminar Roles']);


// ==========================================
// RUTAS PARA USUARIOS (Protegidas)
// ==========================================
Route::get('/admin/usuarios', [App\Http\Controllers\UsuarioController::class, 'index'])
    ->name('admin.usuarios.index')
    ->middleware(['auth', 'permission:Ver Usuarios']);

Route::get('/admin/usuarios/create', [App\Http\Controllers\UsuarioController::class, 'create'])
    ->name('admin.usuarios.create')
    ->middleware(['auth', 'permission:Crear Usuarios']);

Route::post('/admin/usuarios', [App\Http\Controllers\UsuarioController::class, 'store'])
    ->name('admin.usuarios.store')
    ->middleware(['auth', 'permission:Crear Usuarios']);

Route::post('/admin/usuario/{id}/restaurar', [App\Http\Controllers\UsuarioController::class, 'restaurar'])
    ->name('admin.usuarios.restaurar')
    ->middleware(['auth', 'permission:Editar Usuarios']);

Route::get('/admin/usuario/{id}', [App\Http\Controllers\UsuarioController::class, 'show'])
    ->name('admin.usuarios.show')
    ->middleware(['auth', 'permission:Ver Usuarios']);

Route::get('/admin/usuario/{id}/edit', [App\Http\Controllers\UsuarioController::class, 'edit'])
    ->name('admin.usuarios.edit')
    ->middleware(['auth', 'permission:Editar Usuarios']);

Route::put('/admin/usuario/{id}', [App\Http\Controllers\UsuarioController::class, 'update'])
    ->name('admin.usuarios.update')
    ->middleware(['auth', 'permission:Editar Usuarios']);

Route::delete('/admin/usuario/{id}', [App\Http\Controllers\UsuarioController::class, 'destroy'])
    ->name('admin.usuarios.destroy')
    ->middleware(['auth', 'permission:Eliminar Usuarios']);


// ==========================================
// RUTAS PARA ESCALETA Y NOTAS (Protegidas)
// ==========================================
Route::get('/admin/escaleta/nota/crear/{escaleta_id}', [App\Http\Controllers\EscaletaController::class, 'createNota'])
    ->name('admin.escaleta.nota.create')
    ->middleware(['auth', 'permission:Crear Notas']);

Route::post('/admin/escaleta/nota/store', [App\Http\Controllers\EscaletaController::class, 'storeNota'])
    ->name('admin.escaleta.nota.store')
    ->middleware(['auth', 'permission:Crear Notas']);

// Ver una nota específica (requiere permiso general de calendario/escaleta)
Route::get('/admin/escaleta/nota/ver/{id}', [App\Http\Controllers\EscaletaController::class, 'showNota'])
    ->name('admin.escaleta.nota.show')
    ->middleware(['auth', 'permission:Ver Calendario y Escaleta']);

Route::get('/admin/escaleta/nota/editar/{id}', [App\Http\Controllers\EscaletaController::class, 'editNota'])
    ->name('admin.escaleta.nota.edit')
    ->middleware(['auth', 'permission:Editar Notas']);

Route::put('/admin/escaleta/nota/actualizar/{id}', [App\Http\Controllers\EscaletaController::class, 'updateNota'])
    ->name('admin.escaleta.nota.update')
    ->middleware(['auth', 'permission:Editar Notas']);

Route::delete('/admin/escaleta/nota/eliminar/{id}', [App\Http\Controllers\EscaletaController::class, 'destroyNota'])
    ->name('admin.escaleta.nota.destroy')
    ->middleware(['auth', 'permission:Eliminar Notas']);

Route::post('/admin/escaleta/nota/clonar/{id}', [App\Http\Controllers\EscaletaController::class, 'clonarNota'])
    ->name('admin.escaleta.nota.clonar')
    ->middleware(['auth', 'permission:Clonar Notas']);

// Calendario y selección de programas (Requiere solo ver el calendario)
Route::get('/admin/escaleta/{fecha}', [App\Http\Controllers\EscaletaController::class, 'seleccionarPrograma'])
    ->name('admin.escaleta.programa')
    ->middleware(['auth', 'permission:Ver Calendario y Escaleta']);

Route::get('/admin/escaleta/{fecha}/{programa}', [App\Http\Controllers\EscaletaController::class, 'show'])
    ->name('admin.escaleta.show')
    ->middleware(['auth', 'permission:Ver Calendario y Escaleta']);

require __DIR__.'/settings.php';
