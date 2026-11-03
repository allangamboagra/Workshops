-- Run after auth_schema.sql
CREATE TABLE IF NOT EXISTS careers (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uq_careers_name (name)
) ENGINE=InnoDB
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

INSERT IGNORE INTO careers (name) VALUES
    ('Ingeniería en Sistemas'),
    ('Ingeniería Industrial'),
    ('Administración de Empresas'),
    ('Contaduría Pública'),
    ('Arquitectura');

CREATE TABLE IF NOT EXISTS courses (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    course_code VARCHAR(20) NOT NULL,
    career_id INT UNSIGNED NOT NULL,
    credits TINYINT UNSIGNED NOT NULL,
    description TEXT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_courses_course_code (course_code),
    CONSTRAINT fk_courses_career
        FOREIGN KEY (career_id) REFERENCES careers (id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

INSERT IGNORE INTO courses (name, course_code, career_id, credits, description) VALUES
    ('Programación I', 'CS-101', 1, 4, 'Fundamentos de programación estructurada.'),
    ('Bases de Datos', 'CS-204', 1, 4, 'Diseño y administración de bases de datos relacionales.'),
    ('Contabilidad General', 'CP-101', 4, 3, 'Principios básicos de contabilidad.');
