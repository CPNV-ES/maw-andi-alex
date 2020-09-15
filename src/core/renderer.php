<?php

class Renderer
{

    private static $instance = null;

    public $view_path;

    private $layout_path;

    private $values;

    private function __construct()
    {
    }

    /**
     * Get the instance of the Renderer singleton
     * 
     * @return Renderer
     */
    public static function get_instance()
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
    public function view(string $view_path)
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
    public function layout(string $layout_path)
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
        global $values;
        $values = $this->values;

        // Note: This will overwrite any existing global variables
        foreach($values as $key => $value) {
            global $$key;
            $$key = $value;
        }

        require($this->layout_path);

        return $this;
    }
}
