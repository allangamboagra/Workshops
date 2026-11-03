<?php

/**
 * Crea una única conexión PDO y la reutiliza (solo se conecta cuando un modelo la necesita)
 */
class Database
{
    private static ?PDO $connection = null;

    public static function connection(): PDO
    {
        if (self::$connection === null) {
            $config = require BASE_PATH . '/config/database.php';

            try {
                self::$connection = new PDO($config['dsn'], $config['user'], $config['password'], [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]);
            } catch (PDOException $exception) {
                // Se registra el detalle en vez de mostrarlo: el stack trace imprimiría las credenciales
                error_log('Database connection error: ' . $exception->getMessage());
                http_response_code(500);
                exit('The service is temporarily unavailable. Please try again later.');
            }
        }

        return self::$connection;
    }
}
