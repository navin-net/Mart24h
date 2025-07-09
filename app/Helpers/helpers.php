<?php

if (!function_exists('pp')) {
    /**
     * Pretty print array or object and optionally stop execution.
     *
     * @param mixed $data
     * @param bool $exit
     * @return void
     */
    function pp(mixed $data, bool $exit = true): void
    {
      echo "<div style='background-color: #282c34; color: #abb2bf; padding: 15px; border-radius: 8px; font-family: \"Source Code Pro\", \"Fira Code\", \"Consolas\", monospace; font-size: 14px; line-height: 1.5; overflow-x: auto; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3); margin: 10px 0;'>";
        echo "<pre style='margin: 0; padding: 0;'>";
        print_r($data);
        echo "</pre>";
        echo "</div>";

        if ($exit) {
            die;
        }
    }
}

if (!function_exists('pd')) {
    /**
     * Pretty print using var_dump and optionally stop execution.
     *
     * @param mixed $data
     * @param bool $exit
     * @return void
     */
    function pd(mixed $data, bool $exit = true): void
    {
      echo "<div style='background-color: #282c34; color: #abb2bf; padding: 15px; border-radius: 8px; font-family: \"Source Code Pro\", \"Fira Code\", \"Consolas\", monospace; font-size: 14px; line-height: 1.5; overflow-x: auto; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3); margin: 10px 0;'>";
        echo "<pre style='margin: 0; padding: 0;'>";
        print_r($data);
        echo "</pre>";
        echo "</div>";

        if ($exit) {
            die;
        }
    }
}

