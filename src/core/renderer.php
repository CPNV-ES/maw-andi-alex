<?php

/**
 * [Description Renderer]
 */
class Renderer
{
    private static $instance = null;

    /**
     * @var string The path of the view file to use
     */
    public $view_path;

    /**
     * @var string The path of the layout file to use
     */
    private $layout_path;

    /**
     * @var array The values that are transformed into variables inside the views
     */
    private $values = [];

    private function __construct()
    {
    }

    /**
     * Get the instance of the Renderer singleton
     * 
     * @return Renderer
     */
    public static function get_instance() : Renderer
    {
        if (self::$instance == null) {
            self::$instance = new Renderer();
        }

        return self::$instance;
    }

    /**
     * Register a view that will be rendered inside the layout
     * 
     * @param string $view_path
     * 
     * @return Renderer
     */
    public function view(string $view_path) : Renderer
    {
        if (!file_exists($view_path)) {
            throw new RuntimeException('Could not find the requested view');
        }

        $this->view_path = $view_path;

        return $this;
    }

    /**
     * Register a layout that will be rendered later
     * 
     * @return Renderer
     */
    public function layout(string $layout_path) : Renderer
    {
        if (!file_exists($layout_path)) {
            throw new RuntimeException('Could not find the requested view');
        }

        $this->layout_path = $layout_path;

        return $this;
    }

    /**
     * @param array $values The values that are transformed into variables 
     * inside the views
     * 
     * @return Renderer
     */
    public function values(array $values) : Renderer
    {
        $this->values = $values;

        return $this;
    }

    /**
     * Allows to require the given layout that will then render the view 
     * registered inside the Renderer object
     * 
     * @return Renderer
     */
    public function render() : Renderer
    {
        // Register the variables set in values to the current scope
        foreach($this->values as $key => $value) {
            $$key = $value;
        }

        // Inherit the variable scope to allow the layout and view to access
        // variables set with $this->values
        include($this->layout_path);

        return $this;
    }
}
