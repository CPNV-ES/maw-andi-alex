<?php

require 'core/router.php';
require 'core/renderer.php';

$router = new Router();
$renderer = Renderer::get_instance();

// Set the layout used on every page
$renderer->layout('layout.php');

$router->get('/', function () use ($renderer) {
    $renderer->view('views/index.php')->render();
});

$router->execute();
