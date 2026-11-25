-- =====================================================================
--  Quiz3 · Matrícula de estudiantes y CRUD de cursos
--  Importar en phpMyAdmin (XAMPP) sobre la base de datos `Quiz3`.
--  Crea las tablas carreras, cursos y matriculas con su seed.
--  Incluye la tabla `migrations` para que `php artisan migrate`
--  no intente volver a crear las tablas.
-- =====================================================================

CREATE DATABASE IF NOT EXISTS `Quiz3`
  DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `Quiz3`;

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `matriculas`;
DROP TABLE IF EXISTS `cursos`;
DROP TABLE IF EXISTS `carreras`;
DROP TABLE IF EXISTS `migrations`;

SET FOREIGN_KEY_CHECKS = 1;

-- ---------------------------------------------------------------------
-- Tabla: carreras (catálogo, se llena con seed)
-- ---------------------------------------------------------------------
CREATE TABLE `carreras` (
  `id`         BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre`     VARCHAR(120)    NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `carreras_nombre_unique` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- Tabla: cursos (CRUD)
-- ---------------------------------------------------------------------
CREATE TABLE `cursos` (
  `id`         BIGINT UNSIGNED  NOT NULL AUTO_INCREMENT,
  `nombre`     VARCHAR(120)     NOT NULL,
  `codigo`     VARCHAR(20)      NOT NULL,
  `creditos`   TINYINT UNSIGNED NOT NULL,
  `carrera_id` BIGINT UNSIGNED  NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cursos_codigo_unique` (`codigo`),
  KEY `cursos_carrera_id_foreign` (`carrera_id`),
  CONSTRAINT `cursos_carrera_id_foreign`
    FOREIGN KEY (`carrera_id`) REFERENCES `carreras` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- Tabla: matriculas (registro de matrícula de estudiantes)
-- ---------------------------------------------------------------------
CREATE TABLE `matriculas` (
  `id`                BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `estudiante_nombre` VARCHAR(120)    NOT NULL,
  `estudiante_cedula` VARCHAR(20)     NOT NULL,
  `estudiante_correo` VARCHAR(120)    NOT NULL,
  `curso_id`          BIGINT UNSIGNED NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `matriculas_estudiante_cedula_curso_id_unique` (`estudiante_cedula`, `curso_id`),
  KEY `matriculas_curso_id_foreign` (`curso_id`),
  CONSTRAINT `matriculas_curso_id_foreign`
    FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- Seed: carreras
-- ---------------------------------------------------------------------
INSERT INTO `carreras` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'Ingeniería del Software',               NOW(), NOW()),
(2, 'Ingeniería en Sistemas de Información', NOW(), NOW()),
(3, 'Administración de Empresas',            NOW(), NOW()),
(4, 'Contaduría Pública',                    NOW(), NOW()),
(5, 'Diseño Gráfico',                        NOW(), NOW());

-- ---------------------------------------------------------------------
-- Seed: cursos (listado que aparece en el formulario de matrícula)
-- ---------------------------------------------------------------------
INSERT INTO `cursos` (`id`, `nombre`, `codigo`, `creditos`, `carrera_id`, `created_at`, `updated_at`) VALUES
(1,  'Introducción a la Programación',         'ISW-101', 4, 1, NOW(), NOW()),
(2,  'Programación Web I',                     'ISW-211', 4, 1, NOW(), NOW()),
(3,  'Programación Web II',                    'ISW-311', 4, 1, NOW(), NOW()),
(4,  'Bases de Datos I',                       'ISW-221', 3, 1, NOW(), NOW()),
(5,  'Fundamentos de Sistemas de Información', 'SIS-102', 3, 2, NOW(), NOW()),
(6,  'Redes de Computadoras',                  'SIS-230', 4, 2, NOW(), NOW()),
(7,  'Introducción a la Administración',       'ADM-101', 3, 3, NOW(), NOW()),
(8,  'Mercadeo I',                             'ADM-205', 3, 3, NOW(), NOW()),
(9,  'Contabilidad General I',                 'CON-110', 4, 4, NOW(), NOW()),
(10, 'Costos I',                               'CON-220', 3, 4, NOW(), NOW()),
(11, 'Dibujo Básico',                          'DIG-101', 2, 5, NOW(), NOW()),
(12, 'Teoría del Color',                       'DIG-210', 3, 5, NOW(), NOW());

-- ---------------------------------------------------------------------
-- Control de migraciones de Laravel
-- ---------------------------------------------------------------------
CREATE TABLE `migrations` (
  `id`        INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` VARCHAR(255) NOT NULL,
  `batch`     INT          NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2026_11_24_000001_create_carreras_table',   1),
('2026_11_24_000002_create_cursos_table',     1),
('2026_11_24_000003_create_matriculas_table', 1);
