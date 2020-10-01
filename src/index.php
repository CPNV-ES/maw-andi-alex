<?php

require '../vendor/autoload.php';

require 'core/router.php';
require 'core/renderer.php';

use Expreql\Expreql\Database;

$config = parse_ini_file('config.ini');

Database::set_config($config);
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

$router->get('/exercises', function () use ($renderer) {
    require_once 'models/exercise.php';
    require_once 'models/question.php';

    $building_exercises = Exercise::select([
        'id',
        'title',
        'state',
        ['count', 'exercises_id', 'nb_questions']
    ])->join(Question::class)->where('state', 'building')->group_by('exercises.id')->execute();

    $answering_exercises = Exercise::select([
        'id',
        'title',
        'state',
    ])->where('state', 'answering')->execute();

    $closed_exercises = Exercise::select([
        'id',
        'title',
        'state',
    ])->where('state', 'closed')->execute();

    $renderer->view('views/exercises_manage.php')->values([
        'building_exercises' => $building_exercises,
        'answering_exercises' => $answering_exercises,
        'closed_exercises' => $closed_exercises,
    ])->render();
});

// Take an Exercise Page
$router->get('/exercises/answering', function () use ($renderer) {
    require_once 'models/exercise.php';

    $exercises = Exercise::select()->where('state', 'answering')->execute();

    $renderer->view('views/exercises_answering.php')->values(['exercises' => $exercises])->render();
});

// Edit fields page
$router->get('/exercises/:id/fields', function ($params) use ($renderer) {
    require_once 'models/exercise.php';
    require_once 'models/question.php';

    if (!is_int($params['id'])) {
        // Redirect on index by default
        header('Location: /');
        exit;
    };

    $exercise = Exercise::select()->where('exercises.id', $params['id'])
        ->join(Question::class)->execute();

    $renderer->view('views/exercises_fields.php')->values([
        'exercise' => $exercise[0],
    ])->render();
});

$router->get('/exercises/:id/delete', function ($params) {
    require_once 'models/exercise.php';

    if (is_int($params['id'])) {
        Exercise::delete()->where('id', $params['id'])->where_or([
            ['state', 'building'],
            ['state', 'closed'],
        ])->execute();
    }

    header('Location: /exercises');
    exit;
});

$router->get('/exercises/:id/status/answering', function ($params) {
    require_once 'models/exercise.php';

    if (is_int($params['id'])) {
        Exercise::update([
            'state' => 'answering'
        ])->where([
            ['id', $params['id']],
            ['state', 'building']
        ])->execute();
    }

    header('Location: /exercises');
    exit;
});

$router->get('/exercises/:id/status/closed', function ($params) {
    require_once 'models/exercise.php';

    if (is_int($params['id'])) {
        Exercise::update([
            'state' => 'closed'
        ])->where([
            ['id', $params['id']],
            ['state', 'answering']
        ])->execute();
    }

    header('Location: /exercises');
    exit;
});

// Fulfill an Exercise page
$router->get('/exercises/:id/fulfillments/new', function ($params) use ($renderer) {
  require_once 'models/question.php';

  if (is_int($params['id'])) {
    $questions = Question::select()->where('exercises_id', $params['id'])->execute();
  }

  $renderer->view('views/fulfillments_new.php')->values(['questions' => $questions])->render();
});

$router->execute();
