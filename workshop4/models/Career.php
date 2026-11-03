<?php

/**
 * Modelo de carreras
 */
class Career
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = Database::connection();
    }

    /**
     * Todas las carreras, cada una con 'id' y 'name'
     */
    public function all(): array
    {
        return $this->conn->query('SELECT id, name FROM careers ORDER BY name')->fetchAll();
    }

    /**
     * Busca una carrera por su id
     * @return array|false
     */
    public function find(int $id)
    {
        $statement = $this->conn->prepare('SELECT id, name FROM careers WHERE id = :id LIMIT 1');
        $statement->execute(['id' => $id]);
        return $statement->fetch();
    }
}
