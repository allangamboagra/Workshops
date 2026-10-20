<?php

/**
 * Returns an array of all careers, each with 'id' and 'name' keys
 * @param PDO $conn The database connection
 * @return array An array of associative arrays, each representing a career
 */
function getCareers(PDO $conn)
{
    return $conn->query('SELECT id, name FROM careers ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Finds a career by its ID
 * @param PDO $conn The database connection
 * @param int $careerId The ID of the career to find
 * @return array|false An associative array with 'id' and 'name' keys if found, or false if not found
 */
function findCareer(PDO $conn, $careerId)
{
    $statement = $conn->prepare('SELECT id, name FROM careers WHERE id = :id LIMIT 1');
    $statement->execute(['id' => $careerId]);
    return $statement->fetch(PDO::FETCH_ASSOC);
}
