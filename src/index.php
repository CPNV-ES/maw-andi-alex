<?php

require 'core/router.php';
require 'core/renderer.php';

$router = new Router();
$renderer = Renderer::get_instance();

// Set the layout used on every page
$renderer->layout('layout.php');

// Home page
$router->get('/', function () use ($renderer) {
    $renderer->view('views/index.php')->render();
});

// New Exercise Page
$router->get('/exercises/new', function() use ($renderer) {
    $renderer->view('views/exercises_new.php')->render();
});

$router->execute();
