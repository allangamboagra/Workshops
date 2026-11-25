# Quiz3 · Matrícula de estudiantes (Laravel 12)

Basado en el workshop5 (CRUD de productos), adaptado a:

- **CRUD de cursos** (`/cursos`): Nombre, Código, Créditos y Carrera (las carreras vienen de un seed).
- **Formulario de matrícula** (`/`, página principal): datos del estudiante + listado de cursos con buscador.
  Al presionar **Matricular** se guarda el registro y se muestra el comprobante con los datos.
- Listado de matrículas registradas (`/matriculas`).

## Puesta en marcha (XAMPP)

1. Encender **Apache** y **MySQL** en XAMPP.
2. En phpMyAdmin, seleccionar la base `Quiz3` → **Importar** → `database/sql/Quiz3.sql`.
   *(Alternativa: `php artisan migrate --seed`, que crea las mismas tablas y datos.)*
3. La conexión ya está en `.env`:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=Quiz3
   DB_USERNAME=root
   DB_PASSWORD=
   ```
4. Levantar el proyecto:
   ```
   php artisan config:clear
   php artisan serve
   ```
5. Abrir http://127.0.0.1:8000

## Tablas

| Tabla       | Campos principales |
|-------------|--------------------|
| carreras    | id, nombre (seed) |
| cursos      | id, nombre, codigo (único), creditos, carrera_id → carreras |
| matriculas  | id, estudiante_nombre, estudiante_cedula, estudiante_correo, curso_id → cursos |

Reglas: un estudiante (cédula) no puede matricular el mismo curso dos veces, y un curso con
matrículas no se puede eliminar.
