<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = array(
            'Администратор',
            'Руководитель Департамента',
            'Руководитель Отдела',
            'МРБ',
            'КПГ',
            'Ведущий специалист',
            'Технический аналитик',
            'Переводчик',
            'Графический дизайнер',
            'Научный Редактор',
            'Дизайнер - Научный редактор',
            'Аналитик',
            'Поддерживающий Персонал',
            'Специалист по составлению регистрационного досье',
            'Регистратор Досье',
            'Копирайтер',
            'СММ специалист',
            'Видеомейкер',
            'Стажер',
            'Научный аналитик',
            'Веб-мастер',
            'Проектный менеджер',
            'Специалист',
            'Младший специалист',
        );

        foreach ($roles as $role) {
            Role::create([
                'name' => SlugService::createSlug(Role::class, 'name', $role),
                'display_name' => $role,
            ]);
        }
    }
}
