<?php

/**
 * Clase base de los controladores: sabe mostrar una vista dentro del layout
 */
abstract class Controller
{
    /**
     * Renderiza views/{$view}.php dentro de views/layouts/main.php
     * @param string $view Ruta de la vista relativa a views/, ej: 'courses/index'
     * @param array $data Variables que la vista podrá usar
     */
    protected function render(string $view, array $data = []): void
    {
        $data += ['title' => 'Home', 'showNav' => true, 'alerts' => $this->alerts()];

        // Cada clave de $data pasa a ser una variable dentro de la vista ($courses, $title, ...)
        extract($data);

        ob_start();
        require BASE_PATH . '/views/' . $view . '.php';
        $content = ob_get_clean();

        require BASE_PATH . '/views/layouts/main.php';
    }

    /**
     * Convierte los códigos ?error= / ?success= de la URL en mensajes para la vista
     * @return array Lista de ['style' => 'danger'|'success', 'text' => string]
     */
    private function alerts(): array
    {
        $messages = require BASE_PATH . '/config/messages.php';
        $alerts = [];

        foreach (['error' => 'danger', 'success' => 'success'] as $type => $style) {
            $code = $_GET[$type] ?? null;
            if (is_string($code) && isset($messages[$type][$code])) {
                $alerts[] = ['style' => $style, 'text' => $messages[$type][$code]];
            }
        }

        return $alerts;
    }

    /**
     * Lee un valor enviado por POST
     */
    protected function input(string $key, $default = null)
    {
        return $_POST[$key] ?? $default;
    }
}
