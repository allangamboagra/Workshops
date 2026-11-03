<?php

/**
 * Modelo de cursos: CRUD sobre la tabla courses
 */
class Course
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = Database::connection();
    }

    /**
     * Todos los cursos con el nombre de su carrera, ordenados por id
     */
    public function all(): array
    {
        return $this->conn->query(
            'SELECT c.id, c.name, c.course_code, c.career_id, c.credits, c.description, ca.name AS career_name
             FROM courses c
             LEFT JOIN careers ca ON ca.id = c.career_id
             ORDER BY c.id'
        )->fetchAll();
    }

    /**
     * Busca un curso por su id
     * @return array|false
     */
    public function find(int $id)
    {
        $statement = $this->conn->prepare(
            'SELECT id, name, course_code, career_id, credits, description FROM courses WHERE id = :id LIMIT 1'
        );
        $statement->execute(['id' => $id]);
        return $statement->fetch();
    }

    /**
     * Crea un curso. Lanza PDOException con código 23000 si el código de curso ya existe
     * @param array $data Claves: name, course_code, career_id, credits, description
     */
    public function create(array $data): void
    {
        $statement = $this->conn->prepare(
            'INSERT INTO courses (name, course_code, career_id, credits, description)
             VALUES (:name, :course_code, :career_id, :credits, :description)'
        );
        $statement->execute($data);
    }

    /**
     * Actualiza un curso. Lanza PDOException con código 23000 si el código de curso ya existe
     * @param array $data Claves: name, course_code, career_id, credits, description
     */
    public function update(int $id, array $data): void
    {
        $data['id'] = $id;
        $statement = $this->conn->prepare(
            'UPDATE courses
             SET name = :name, course_code = :course_code, career_id = :career_id, credits = :credits, description = :description
             WHERE id = :id'
        );
        $statement->execute($data);
    }

    public function delete(int $id): void
    {
        $statement = $this->conn->prepare('DELETE FROM courses WHERE id = :id');
        $statement->execute(['id' => $id]);
    }

    /**
     * Valida y normaliza los datos de un curso que vienen del formulario
     * @return array|null Los datos listos para create()/update(), o null si no son válidos
     */
    public static function sanitize(array $input): ?array
    {
        $name = $input['name'] ?? null;
        $courseCode = $input['course_code'] ?? null;
        $careerId = $input['career_id'] ?? null;
        $credits = $input['credits'] ?? null;
        $description = $input['description'] ?? '';

        if (
            !is_string($name)
            || !is_string($courseCode)
            || !is_string($description)
            || trim($name) === ''
            || strlen(trim($name)) > 100
            || trim($courseCode) === ''
            || strlen(trim($courseCode)) > 20
            || !ctype_digit((string) $careerId)
            || !ctype_digit((string) $credits)
        ) {
            return null;
        }

        return [
            'name' => trim($name),
            'course_code' => trim($courseCode),
            'career_id' => (int) $careerId,
            'credits' => (int) $credits,
            'description' => trim($description) !== '' ? trim($description) : null,
        ];
    }
}
