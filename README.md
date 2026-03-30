# To-Do API

API REST para gestión de tareas personales, construida con Laravel 12 y autenticación por tokens con Laravel Sanctum.

## Estructura del proyecto
```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AuthController.php
│   │   ├── CategoryController.php
│   │   └── TaskController.php
│   ├── Requests/
│   │   ├── StoreCategoryRequest.php
│   │   ├── UpdateCategoryRequest.php
│   │   ├── StoreTaskRequest.php
│   │   └── UpdateTaskRequest.php
│   └── Resources/
│       ├── CategoryResource.php
│       └── TaskResource.php
└── Models/
    ├── User.php
    ├── Category.php
    └── Task.php
```

## Tecnologías

- PHP 8.2+
- Laravel 12
- MySQL
- Laravel Sanctum

## Características

- Autenticación completa (register, login, logout)
- CRUD de tareas con estados y prioridades
- CRUD de categorías con colores personalizados
- Filtros por estado, prioridad y categoría
- Búsqueda por título
- Ordenamiento por múltiples campos
- Paginación configurable
- Cada usuario solo accede a sus propios datos

## Requisitos

- PHP >= 8.2
- Composer
- MySQL

## Instalación

1. Clona el repositorio:
```bash
git clone https://github.com/zahid210/To-Do-API.git
cd To-Do-API
```

2. Instala dependencias:
```bash
composer install
```

3. Copia el archivo de entorno y genera la clave:
```bash
cp .env.example .env
php artisan key:generate
```

4. Configura tu base de datos en `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=todo_api
DB_USERNAME=root
DB_PASSWORD=tu_password
```

5. Ejecuta las migraciones:
```bash
php artisan migrate
```

6. (Opcional) Carga datos de prueba:
```bash
php artisan db:seed --class=TaskSeeder
```

7. Inicia el servidor:
```bash
php artisan serve
```

La API estará disponible en `http://127.0.0.1:8000`

## Endpoints

Todos los endpoints protegidos requieren los headers:
```
Authorization: Bearer {token}
Accept: application/json
Content-Type: application/json
```

### Autenticación

| Método | Endpoint | Descripción | Auth |
|--------|----------|-------------|------|
| POST | `/api/register` | Registrar usuario | No |
| POST | `/api/login` | Iniciar sesión | No |
| POST | `/api/logout` | Cerrar sesión | Sí |
| GET | `/api/me` | Usuario autenticado | Sí |

### Categorías

| Método | Endpoint | Descripción |
|--------|----------|-------------|
| GET | `/api/categories` | Listar categorías |
| POST | `/api/categories` | Crear categoría |
| GET | `/api/categories/{id}` | Ver categoría |
| PUT | `/api/categories/{id}` | Actualizar categoría |
| DELETE | `/api/categories/{id}` | Eliminar categoría |

### Tareas

| Método | Endpoint | Descripción |
|--------|----------|-------------|
| GET | `/api/tasks` | Listar tareas (con filtros) |
| POST | `/api/tasks` | Crear tarea |
| GET | `/api/tasks/{id}` | Ver tarea |
| PUT | `/api/tasks/{id}` | Actualizar tarea |
| DELETE | `/api/tasks/{id}` | Eliminar tarea |

### Filtros disponibles en GET /api/tasks

| Parámetro | Tipo | Ejemplo | Descripción |
|-----------|------|---------|-------------|
| `status` | string | `pending` | Filtra por estado |
| `priority` | string | `high` | Filtra por prioridad |
| `category_id` | integer | `1` | Filtra por categoría |
| `search` | string | `reunion` | Busca en el título |
| `sort_by` | string | `due_date` | Campo para ordenar |
| `sort_dir` | string | `asc` | Dirección: asc o desc |
| `per_page` | integer | `5` | Resultados por página (máx. 50) |

## Ejemplos de uso

### Registrar usuario
```json
POST /api/register
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

### Crear categoría
```json
POST /api/categories
{
    "name": "Trabajo",
    "color": "#6366f1"
}
```

### Crear tarea
```json
POST /api/tasks
{
    "title": "Revisar pull requests",
    "description": "Revisar los PRs pendientes del equipo",
    "status": "pending",
    "priority": "high",
    "due_date": "2026-12-31",
    "category_id": 1
}
```

### Filtrar tareas
```
GET /api/tasks?status=pending&priority=high&sort_by=due_date&sort_dir=asc
```

## Autor

**Zahid Roy Matos Ceras**
Estudiante de Ingeniería de Sistemas

Proyecto personal – uso educativo
