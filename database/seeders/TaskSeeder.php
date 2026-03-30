<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        if (!$user) {
            return;
        }

        // Crear categorías de prueba
        $trabajo   = Category::create(['user_id' => $user->id, 'name' => 'Trabajo',   'color' => '#6366f1']);
        $personal  = Category::create(['user_id' => $user->id, 'name' => 'Personal',  'color' => '#f43f5e']);
        $estudio   = Category::create(['user_id' => $user->id, 'name' => 'Estudio',   'color' => '#10b981']);

        // Crear tareas de prueba
        $tasks = [
            ['title' => 'Revisar emails',          'status' => 'pending',     'priority' => 'high',   'category_id' => $trabajo->id],
            ['title' => 'Reunión con el equipo',   'status' => 'in_progress', 'priority' => 'high',   'category_id' => $trabajo->id],
            ['title' => 'Entregar informe',        'status' => 'pending',     'priority' => 'medium', 'category_id' => $trabajo->id],
            ['title' => 'Hacer ejercicio',         'status' => 'pending',     'priority' => 'medium', 'category_id' => $personal->id],
            ['title' => 'Llamar al médico',        'status' => 'completed',   'priority' => 'high',   'category_id' => $personal->id],
            ['title' => 'Estudiar Laravel',        'status' => 'in_progress', 'priority' => 'high',   'category_id' => $estudio->id],
            ['title' => 'Leer documentación',      'status' => 'pending',     'priority' => 'low',    'category_id' => $estudio->id],
            ['title' => 'Practicar algoritmos',    'status' => 'pending',     'priority' => 'medium', 'category_id' => $estudio->id],
            ['title' => 'Comprar víveres',         'status' => 'completed',   'priority' => 'low',    'category_id' => $personal->id],
            ['title' => 'Pagar facturas',          'status' => 'pending',     'priority' => 'high',   'category_id' => null,          'due_date' => '2026-04-15'],
        ];

        foreach ($tasks as $task) {
            Task::create(array_merge($task, ['user_id' => $user->id]));
        }
    }
}
