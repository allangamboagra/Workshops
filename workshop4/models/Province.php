<?php

/**
 * Modelo de provincias
 */
class Province
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = Database::connection();
    }

    /**
     * Todas las provincias, cada una con 'id' y 'name'
     */
    public function all(): array
    {
        return $this->conn->query('SELECT id, name FROM provinces ORDER BY id')->fetchAll();
    }

    /**
     * Busca una provincia por su id
     * @return array|false
     */
    public function find(int $id)
    {
        $statement = $this->conn->prepare('SELECT id, name FROM provinces WHERE id = :id LIMIT 1');
        $statement->execute(['id' => $id]);
        return $statement->fetch();
    }
}
