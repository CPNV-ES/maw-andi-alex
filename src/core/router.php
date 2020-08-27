<?php

/**
 * Route the user request by the routes that were registered.
 * 
 * Regexes can be used for the matching of the request path.
 */
class Router
{

    /**
     * Contains all the routes that where registered on this router.
     * @access private
     * @var array
     */
    private $routes;

    public function __construct()
    {
        $this->routes = [];
    }

    /**
     * @param string $method        The HTTP method (GET, POST, ...)
     * @param string $path          The path that will trigger the callback. 
     *                              Can contain a regex
     * @param callable $callback    The callback that will be called if the 
     *                              path is matched
     */
    private function register(string $method, string $path, callable $callback)
    {
        $this->routes[] = new Route($method, $path, $callback);
    }

    /**
     * @param string $path
     * @param callable $callback
     * 
     */
    public function get(string $path, callable $callback)
    {
        $this->register('GET', $path, $callback);
    }

    /**
     * Try to match the registered routes against the requested uri and call the
     * callback accordingly.
     * 
     * NOTE: No more that 1 route will be matched (in the order in which they 
     * where registered).
     */
    public function execute()
    {
        $request_uri = '';
        $get_params_offset = stripos($_SERVER['REQUEST_URI'], '?');

        // Remove GET parameters from request uri
        if ($get_params_offset) {
            $request_uri = substr($_SERVER['REQUEST_URI'], 0, $get_params_offset);
        } else {
            $request_uri = $_SERVER['REQUEST_URI'];
        }

        foreach ($this->routes as $route) {
            preg_match_all('#^' . $route->path . '$#', $request_uri, $matches, PREG_OFFSET_CAPTURE);

            foreach ($matches as $match) {
                if ($match) {
                    ($route->callback)();
                    // We don't want to match more than once    
                    break;
                }
            }

            // If we have a match on the route, we don't want to execute other
            // route callbacks.
            if ($matches[0]) {
                break;
            }
        }
    }
}

/**
 * Store a registered route attributes.
 */
class Route
{

    /**
     * The HTTP method (GET, POST, etc...)
     * @access private
     * @var string
     */
    public $method;

    /**
     * The path that will trigger the callback. Can contain a regex
     * @access private
     * @var string
     */
    public $path;

    /**
     * The callback called when the path is matched
     * @access private
     * @var [type]
     */
    public $callback;

    public function __construct(string $method, string $path, callable $callback)
    {
        $this->$method = $method;
        $this->path = $path;
        $this->callback = $callback;
    }
}
