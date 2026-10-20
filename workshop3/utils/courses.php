<?php

/**
 * Returns all courses along with their career name, ordered by id
 * @param PDO $conn The database connection
 * @return array An array of associative arrays, each representing a course
 */
function getCourses(PDO $conn)
{
    return $conn->query(
        'SELECT c.id, c.name, c.course_code, c.career_id, c.credits, c.description, ca.name AS career_name
         FROM courses c
         LEFT JOIN careers ca ON ca.id = c.career_id
         ORDER BY c.id'
    )->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Finds a course by its ID
 * @param PDO $conn The database connection
 * @param int $courseId The ID of the course to find
 * @return array|false An associative array representing the course if found, or false if not found
 */
function findCourse(PDO $conn, $courseId)
{
    $statement = $conn->prepare(
        'SELECT id, name, course_code, career_id, credits, description FROM courses WHERE id = :id LIMIT 1'
    );
    $statement->execute(['id' => $courseId]);
    return $statement->fetch(PDO::FETCH_ASSOC);
}

/**
 * Creates a new course
 * @param PDO $conn The database connection
 * @param array $data Associative array with keys: name, course_code, career_id, credits, description
 */
function createCourse(PDO $conn, array $data)
{
    $statement = $conn->prepare(
        'INSERT INTO courses (name, course_code, career_id, credits, description)
         VALUES (:name, :course_code, :career_id, :credits, :description)'
    );
    $statement->execute($data);
}

/**
 * Updates an existing course
 * @param PDO $conn The database connection
 * @param int $id The ID of the course to update
 * @param array $data Associative array with keys: name, course_code, career_id, credits, description
 */
function updateCourse(PDO $conn, int $id, array $data)
{
    $data['id'] = $id;
    $statement = $conn->prepare(
        'UPDATE courses
         SET name = :name, course_code = :course_code, career_id = :career_id, credits = :credits, description = :description
         WHERE id = :id'
    );
    $statement->execute($data);
}

/**
 * Deletes a course by its ID
 * @param PDO $conn The database connection
 * @param int $id The ID of the course to delete
 */
function deleteCourse(PDO $conn, int $id)
{
    $statement = $conn->prepare('DELETE FROM courses WHERE id = :id');
    $statement->execute(['id' => $id]);
}
