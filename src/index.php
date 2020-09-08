<?php

require 'core/router.php';
require 'core/renderer.php';
require 'core/model.php';

$config = parse_ini_file('config.ini');

Model::set_config($config);
$router = new Router();
$renderer = Renderer::get_instance();

// Set the layout used on every page
$renderer->layout('layout.php');

// Home page
$router->get('/', function () use ($renderer) {
    $renderer->view('views/index.php')->render();
});

// New Exercise Page
$router->get('/exercises/new', function () use ($renderer) {
    $renderer->view('views/exercises_new.php')->render();
});

// Create a new Exercise (redirect from /exercises/new)
$router->post('/exercises', function () {
    require_once 'models/exercise.php';

    $exercise = Exercise::insert([
        'title' => $_POST['title'],
    ]);

    header('Location: /exercises/' . $exercise[0]->id . '/fields');
    exit;
});

$router->execute();
