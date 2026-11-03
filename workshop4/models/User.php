<?php

/**
 * Modelo de usuarios: todas las consultas a la tabla users
 */
class User
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = Database::connection();
    }

    /**
     * Lista de usuarios con el nombre de su provincia
     */
    public function all(): array
    {
        return $this->conn->query(
            'SELECT u.id, u.username, p.name AS province_name, u.created_at
             FROM users u
             LEFT JOIN provinces p ON p.id = u.province_id
             ORDER BY u.id'
        )->fetchAll();
    }

    /**
     * Busca un usuario por su nombre de usuario (incluye el hash de la contraseña y la provincia)
     * @return array|false
     */
    public function findByUsername(string $username)
    {
        $statement = $this->conn->prepare(
            'SELECT u.id, u.username, u.password_hash, u.province_id, u.profile_picture, p.name AS province_name
             FROM users u
             LEFT JOIN provinces p ON p.id = u.province_id
             WHERE u.username = :username
             LIMIT 1'
        );
        $statement->execute(['username' => $username]);
        return $statement->fetch();
    }

    /**
     * Busca un usuario por su id (incluye el hash de la contraseña y la provincia)
     * @return array|false
     */
    public function find(int $id)
    {
        $statement = $this->conn->prepare(
            'SELECT u.id, u.username, u.password_hash, u.province_id, u.profile_picture, p.name AS province_name
             FROM users u
             LEFT JOIN provinces p ON p.id = u.province_id
             WHERE u.id = :id
             LIMIT 1'
        );
        $statement->execute(['id' => $id]);
        return $statement->fetch();
    }

    /**
     * Devuelve el usuario si las credenciales son correctas, o false si no
     * @return array|false
     */
    public function authenticate(string $username, string $password)
    {
        $user = $this->findByUsername($username);

        if ($user === false || !password_verify($password, $user['password_hash'])) {
            return false;
        }

        return $user;
    }

    public function verifyPassword(int $id, string $password): bool
    {
        $user = $this->find($id);
        return $user !== false && password_verify($password, $user['password_hash']);
    }

    /**
     * Crea un usuario. Lanza PDOException con código 23000 si el username ya existe
     */
    public function create(string $username, string $password, int $provinceId): void
    {
        $statement = $this->conn->prepare(
            'INSERT INTO users (username, password_hash, province_id) VALUES (:username, :password_hash, :province_id)'
        );
        $statement->execute([
            'username' => $username,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
            'province_id' => $provinceId,
        ]);
    }

    /**
     * Actualiza el perfil. La contraseña y la foto solo se cambian si vienen (no son null).
     * Lanza PDOException con código 23000 si el username ya existe
     */
    public function updateProfile(int $id, string $username, int $provinceId, ?string $newPassword = null, ?string $profilePicture = null): void
    {
        $fields = ['id' => $id, 'username' => $username, 'province_id' => $provinceId];
        $sql = 'UPDATE users SET username = :username, province_id = :province_id';

        if ($newPassword !== null) {
            $sql .= ', password_hash = :password_hash';
            $fields['password_hash'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }

        if ($profilePicture !== null) {
            $sql .= ', profile_picture = :profile_picture';
            $fields['profile_picture'] = $profilePicture;
        }

        $statement = $this->conn->prepare($sql . ' WHERE id = :id');
        $statement->execute($fields);
    }
}
