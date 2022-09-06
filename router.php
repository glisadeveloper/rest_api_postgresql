<?php

/**
 * Holds the registered routes
 *
 * @var array $routes
 */
$routes = [];

/**
 * Register a new route
 *
 * @param $url string
 * @param \Closure $callback Called when current URL matches provided action url
 */
function route($url, Closure $callback)
{
    global $routes;
    $url = trim($url, '/');
    $routes[$url] = $callback;      
}

/**
 * Dispatch the router
 *
 * @param $url string
 */
function dispatch($url)
{	
    global $routes;    
    $url = trim($url, '/');   
    (!empty($routes[$url])) ? $callback = $routes[$url] : notFound();  
    return call_user_func($callback);
}


/**
 * Return 404 if $url not exist
 *
 * @param file
 */
function notFound(){
	include '404.php';
	exit();
}