<?php

abstract class Component
{

    /**
     * Path to the components folder
     * 
     * @var string
     */
    private static string $path;

    /**
     * Set the path to the components folder
     * 
     * @param string $path
     * 
     */
    public static function set_path(string $path)
    {
        static::$path = $path;
    }

    /**
     * @param string $name  Component file name
     * @param array $values Variables to declare in the component scope
     * 
     * @return string
     */
    public static function new(string $name, array $values = []) : string
    {
        // Register the variables set in values to the current scope
        extract($values, EXTR_OVERWRITE);

        ob_start();

        // Inherit the variable scope to allow the component to access the 
        // given $values 
        include(static::$path . $name);

        return ob_get_clean();
    }
}
