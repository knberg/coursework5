<?php 


class Router 
{        
    private static $staticRoutes = [
        'GET'    => [],
        'POST'   => [],
        'PUT'    => [],
        'DELETE' => [],
        'PATCH'  => []
    ];

    private static $regexRoutes = [
        'GET'    => [],
        'POST'   => [],
        'PUT'    => [],
        'DELETE' => [],
        'PATCH'  => []
    ];

    private static $shortcuts = [
        'i' => '(\d+)',
        's' => '(\w+)',
        'h' => '([a-fA-F0-9]+)',
        '*' => '([^\/]+)'
    ];

    private static $filters = [];

    private static $groupFilters = [];

    private static $groupPrefix = '';

    private static $groupController = null;


    public static function handle($httpMethod, $path)
    {
       // debug(self::$staticRoutes);

        $routeInfo = self::find($httpMethod, $path);

        if (!$routeInfo) self::pageNotFound();
        
        [$handler, $params, $filters] = $routeInfo;

        $filterResult = self::doFilters($filters);

        if ($filterResult == null) {
            if (is_array($handler)) {
                $controller = new $handler[0]();
                $action = $handler[1];
                call_user_func_array([$controller, $action], $params);
            } else {
                call_user_func_array($handler, $params);
            }
        }
    }

    public static function add($httpMethod, $path, $handler) 
    {
        self::applyGroupOptions($path, $handler);

        [$pattern, $params] = self::parse($path);
    
        $route = new Route($path, $pattern, $params, $handler);
        $route->filter(self::$groupFilters);

        if (empty($params)) {
            self::$staticRoutes[$httpMethod][$path] = $route;
        } else {
            self::$regexRoutes[$httpMethod][$pattern] = $route;
        }

        return $route;
    }

    public static function parse($path) 
    {
        $segments = explode('/', $path);
        $patternSegments = [];
        $params = [];

        foreach ($segments as $segment) {
            if (strpos($segment, '{') !== false && strpos($segment, '}') !== false) {
                $paramParts = explode(':', trim($segment, '{}'));
                $paramName = $paramParts[0];
                $paramType = isset($paramParts[1]) ? $paramParts[1] : '*';
                $patternSegments[] = self::$shortcuts[$paramType];
                $params[] = $paramName;
            } else {
                $patternSegments[] = $segment;
            }
        }

        $pattern = "/^" . implode('\/', $patternSegments) . "$/";

        return [$pattern, $params];
    }

    public static function group($options, $callback)
    {
        $previousGroupPrefix = self::$groupPrefix;
        $previousGroupFilters = self::$groupFilters;

        self::changeGroupOptions($options);
        $callback();

        self::$groupPrefix = $previousGroupPrefix;
        self::$groupFilters = $previousGroupFilters;
        self::$groupController = null;
    }

    private static function changeGroupOptions($options) 
    {
        if (isset($options['prefix'])) {
            self::$groupPrefix .= $options['prefix'];
        }

        if (isset($options['filter'])) {
            if (is_string($options['filter'])) {
                self::$groupFilters[] = $options['filter'];
            } else {
                self::$groupFilters = array_merge(self::$groupFilters, $options['filter']);
            }
        }

        if (isset($options['controller'])) {
            if (self::$groupController) {
                echo "error there is already a controller";
            } else {
                self::$groupController = $options['controller'];
            }
        }
    }

    private static function applyGroupOptions(&$path, &$handler) 
    {
        if (self::$groupPrefix) {
            if ($path == '/') {
                $path = self::$groupPrefix;
            } else {
                $path = self::$groupPrefix . $path;
            }
        }

        if (self::$groupController) {
            if (!is_string($handler)) {
                die("Action must be a string");
            }
            $action = $handler;
            $handler = [self::$groupController, $action];
        }
    }

    private static function find($httpMethod, $path)
    {
        if (isset(self::$staticRoutes[$httpMethod][$path])) {
            $route = self::$staticRoutes[$httpMethod][$path];
            return [$route->handler, [], $route->filters];
        }

        foreach (self::$regexRoutes[$httpMethod] as $routePattern => $route) {
            if (preg_match($routePattern, $path, $matches)) {
                $params = array_slice($matches, 1);
                return [$route->handler, $params, $route->filters];
            }
        }
    }

    public static function resource($path, $controller)
    {
        self::get($path, [$controller, 'getAll']);
        self::post($path, [$controller, 'create']);
        self::get($path . '/{id:i}', [$controller, 'get']);
        self::put($path . '/{id:i}', [$controller, 'update']);
        self::delete($path . '/{id:i}', [$controller, 'delete']);
        self::get($path . '/{id:i}/delete', [$controller, 'delete']);
        self::get($path . '/{id:i}/edit', [$controller, 'update']);
    }

    public static function filter($name, $handler)
    {
        self::$filters[$name] = $handler;
    }

    public static function shortcut($shortcut, $regex)
    {
        self::$shortcuts[$shortcut] = $regex;
    }

    private static function doFilters($filters)
    {
        foreach ($filters as $filterName) {
            $filter = self::$filters[$filterName];
            $response = $filter();

            if ($response != null) return $response;
        }
    }

    public static function pageNotFound()
    {
        require_once VIEW_PATH . "/error/404.php";
        die();
    }

    /**
    * Helpers for add function for specific http method
    */

    public static function get($path, $handler)
    {
        return self::add('GET', $path, $handler);
    }

    public static function post($path, $handler)
    {
        return self::add('POST', $path, $handler);
    }

    public static function put($path, $handler) 
    {
        return self::add('PUT', $path, $handler);
    }

    public static function delete($path, $handler) 
    {
        return self::add('DELETE', $path, $handler);
    }

    public static function patch($path, $handler) 
    {
        return self::add('PATCH', $path, $handler);
    }
}
