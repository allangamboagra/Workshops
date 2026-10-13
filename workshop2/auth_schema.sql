CREATE TABLE IF NOT EXISTS provincias (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

INSERT IGNORE INTO provincias (id, nombre) VALUES
    (1, 'San José'),
    (2, 'Alajuela'),
    (3, 'Cartago'),
    (4, 'Heredia'),
    (5, 'Guanacaste'),
    (6, 'Puntarenas'),
    (7, 'Limón');

CREATE TABLE IF NOT EXISTS users (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    cedula VARCHAR(20) NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    correo_electronico VARCHAR(150) NOT NULL,
    provincia_id INT UNSIGNED NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_users_username (username),
    UNIQUE KEY uq_users_cedula (cedula),
    UNIQUE KEY uq_users_correo (correo_electronico),
    KEY fk_users_provincia (provincia_id),
    CONSTRAINT fk_users_provincia FOREIGN KEY (provincia_id)
        REFERENCES provincias (id)
) ENGINE=InnoDB
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

INSERT IGNORE INTO users (username, cedula, nombre, apellido, correo_electronico, provincia_id, password_hash) VALUES
    ('admin', '000000000', 'Admin', 'Sistema', 'admin@example.com', 1, '$2y$10$PYp8cJm70gMuSzn9sDWvv.z6tCDxkjWy2eu44wXwPG5gemog9hJ5.'),
    ('bladimir', '111111111', 'Bladimir', 'Usuario', 'bladimir@example.com', 1, '$2y$10$7bAYvF3xfPxIe.0qokV/YOduW5BKAfkNTCrGrcots9mdLRdENYS/e');
