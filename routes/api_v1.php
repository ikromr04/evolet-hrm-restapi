<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\{
    AuthController,
    DepartmentController,
    EducationController,
    EquipmentController,
    EventController,
    ExperienceController,
    LanguageController,
    PositionController,
    RoleController,
    UserController,
    ProfileController,
};

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/me', 'me')->name('me');
        Route::delete('/logout', 'logout')->name('logout');
        Route::delete('/tokens', 'logoutAll')->name('logoutAll');
    });

    Route::get('users/fired', [UserController::class, 'fired'])->name('users.fired');
    Route::get('users/transferred', [UserController::class, 'transferred'])->name('users.transferred');
    Route::apiResource('users', UserController::class);
    Route::post('users/{user}/fire', [UserController::class, 'fire'])->name('users.fire');
    Route::post('users/{user}/transfer', [UserController::class, 'transfer'])->name('users.transfer');

    Route::apiResource('profiles', ProfileController::class);

    Route::apiResource('roles', RoleController::class);

    Route::apiResource('positions', PositionController::class);

    Route::apiResource('departments', DepartmentController::class);

    Route::apiResource('languages', LanguageController::class);

    Route::apiResource('equipments', EquipmentController::class);

    Route::apiResource('experiences', ExperienceController::class);

    Route::apiResource('educations', EducationController::class);
});
