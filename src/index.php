<?php

require '../vendor/autoload.php';

require 'core/router.php';
require 'core/renderer.php';
require 'core/component.php';

use Expreql\Expreql\Database;

$config = parse_ini_file('config.ini');

Component::set_path('components/');
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
        Exercise::field('id'),
        'title',
        'state',
        Question::field('id'),
        'exercises_id',
    ])->join(Question::class)->where('state', 'building')->execute();

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

    $exercises = Exercise::select()->where('state', 'answering')
        ->join(Question::class)->execute();

    $renderer->view('views/exercises_answering.php')->values(['exercises' => $exercises])->render();
});

// Editing field
$router->get('/exercises/:exercise_id/fields/:field_id/edit', function ($params) use ($renderer) {
    require_once 'models/exercise.php';

    if (!is_int($params['exercise_id']) || !is_int($params['field_id'])) {
        Router::redirect('/exercises/' . $params['exercise_id'] . '/fields');
    }

    $exercise = Exercise::select()->where('id', $params['exercise_id'])->execute();
    $field = Question::select()->where('id', $params['field_id'])->execute();

    $renderer->view('views/edit_field.php')->values([
        'exercise' => $exercise[0],
        'field' => $field[0],
    ])->render();
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

$router->post('/exercises/:id/fields', function ($params) use ($router) {
    require_once 'models/question.php';

    if (!is_int($params['id']) || !isset($_POST['label']) || !isset($_POST['type'])) {
        // We have unset variables, redirect to fields page
        header('Location: /exercises/' . $params['id'] . '/fields');
        exit;
    }

    Question::insert([
        'label' => $_POST['label'],
        'type' => $_POST['type'],
        'exercises_id' => $params['id'],
    ]);

    Router::redirect('/exercises/' . $params['id'] . '/fields');
});

$router->get('/exercises/:exercise_id/fields/:field_id/delete', function ($params) {
    require_once 'models/question.php';

    if (!is_int($params['exercise_id']) || !is_int($params['field_id'])) {
        Router::redirect('/exercises/' . $params['exercise_id'] . '/fields');
    }

    Question::delete()->where([
        ['id', $params['field_id']],
        ['exercises_id', $params['exercise_id']],
    ])->execute();

    Router::redirect('/exercises/' . $params['exercise_id'] . '/fields');
});

$router->post('/exercises/:exercise_id/fields/:field_id', function ($params) {
    require_once 'models/question.php';

    if (!is_int($params['exercise_id']) || !is_int($params['field_id'])) {
        Router::redirect('/');
    }

    Question::update([
        'label' => $_POST['label'],
        'type' => $_POST['type'],
    ])->where('id', $params['field_id'])->execute();

    Router::redirect('/exercises/' . $params['exercise_id'] . '/fields');
});

// Fulfill an Exercise page
$router->get('/exercises/:id/fulfillments/new', function ($params) use ($renderer) {
    require_once 'models/question.php';

    if (!is_int($params['id'])) {
        Router::redirect('/');
    }

    $exercise = Exercise::select()->where('exercises.id', $params['id'])
        ->join(Question::class)->execute()[0];

    // Redirect to home if no questions in exercise
    if ($exercise->questions->count() == 0) {
        Router::redirect('/');
    }

    $renderer->view('views/fulfillments_new.php')
    ->values(['exercise' => $exercise])->render();
});

$router->get('/exercises/:id/results', function ($params) use ($renderer) {
    require_once 'models/exercise.php';
    require_once 'models/fulfillment.php';
    require_once 'models/response.php';

    $exercise = Exercise::select()->where(Exercise::field('id'), $params['id'])
        ->join([
            Question::class,
            Fulfillment::class => [
                Response::class
            ]
        ])->execute();

    $renderer->view('views/exercise_results.php')->values([
        'exercise' => $exercise[0],
    ])->render();
});

// Create a new fulfillment with answers
$router->post('/exercises/:id/fulfillments/new', function ($params) {
    require_once 'models/fulfillment.php';
    require_once 'models/response.php';

    if (!is_int($params['id'])) {
        Router::redirect('/');
    }

    $fulfillment = Fulfillment::insert([
        'timestamp' => date("Y-m-d H:i:s"),
        'exercises_id' => $params['id'],
    ]);

    foreach ($_POST['questions'] as $key => $value) {
        Response::insert([
            'text' => $value,
            'questions_id' => $key,
            'fulfillments_id' => $fulfillment[0]->id,
        ]);
    }

    Router::redirect('/exercises/' . $params['id'] . '/fulfillments/' . $fulfillment[0]->id . '/edit');
});

$router->get('/exercises/:exercise_id/fulfillments/:fulfillment_id', function ($params) use ($renderer) {
    require_once 'models/exercise.php';
    require_once 'models/fulfillment.php';
    require_once 'models/question.php';
    require_once 'models/response.php';

    if (!is_int($params['exercise_id']) || !is_int($params['fulfillment_id'])) {
        Router::redirect('/');
    }

    $exercise = Exercise::select()->join([
        Question::class,
        Fulfillment::class => [
            Response::class
        ],
    ])->where([
        [Exercise::field('id'), $params['exercise_id']],
        [Fulfillment::field('id'), $params['fulfillment_id']],
    ])->execute();

    // We need to map the questions and the responses together as they are not
    // linked after executing the request, maybe this need to be done inside the
    // ORM but it is not supported for now so we do this ourselves.
    $user_responses = [];

    foreach ($exercise[0]->questions as $question) {
        $user_responses[$question->id] = [
            'question' => $question
        ];
    }

    foreach ($exercise[0]->fulfillments[0]->responses as $response) {
        $user_responses[$response->questions_id]['response'] = $response;
    }

    $renderer->view('views/fulfillment_result.php')->values([
        'exercise' => $exercise[0],
        'fulfillment' => $exercise[0]->fulfillments[0],
        'user_responses' => $user_responses,
    ])->render();
});

$router->get('/exercises/:exercise_id/results/:question_id', function ($params) use ($renderer) {
    require_once 'models/exercise.php';
    require_once 'models/question.php';
    require_once 'models/fulfillment.php';
    require_once 'models/response.php';

    if (!is_int($params['exercise_id']) || !is_int($params['question_id'])) {
        Router::redirect('/');
    }

    $exercise = Exercise::select()->join([
        Question::class,
        Fulfillment::class => [
            Response::class,
        ],
    ])->where([
        [Exercise::field('id'), $params['exercise_id']],
        [Question::field('id'), $params['question_id']],
        [Response::field('questions_id'), $params['question_id']]
    ])->execute();

    $renderer->view('views/question_result.php')->values([
        'exercise' => $exercise[0],
        'question' => $exercise[0]->questions[0],
    ])->render();
});

// Fulfill an Exercise page
$router->get('/exercises/:exercise_id/fulfillments/:fulfillment_id/edit', function ($params) use ($renderer) {
    require_once 'models/exercise.php';
    require_once 'models/fulfillment.php';
    require_once 'models/question.php';
    require_once 'models/response.php';

    if (!is_int($params['exercise_id']) || !is_int($params['fulfillment_id'])) {
        Router::redirect('/');
    }

    $exercise = Exercise::select()->join([
        Question::class,
        Fulfillment::class => [
            Response::class
        ],
    ])->where([
        [Exercise::field('id'), $params['exercise_id']],
        [Fulfillment::field('id'), $params['fulfillment_id']],
    ])->execute();

    $user_responses = [];

    foreach ($exercise[0]->questions as $question) {
        $user_responses[$question->id] = [
            'question' => $question
        ];
    }

    foreach ($exercise[0]->fulfillments[0]->responses as $response) {
        $user_responses[$response->questions_id]['response'] = $response;
    }

    $renderer->view('views/fulfillments_edit.php')
        ->values([
            'exercise' => $exercise[0],
            'user_responses' => $user_responses,
            ])->render();
});

// Edit a fulfillment with answers
$router->post('/exercises/:exercise_id/fulfillments/:fulfillment_id/edit', function ($params) {
    require_once 'models/response.php';

    if (!is_int($params['exercise_id']) || !is_int($params['fulfillment_id'])) {
        Router::redirect('/');
    }

    foreach ($_POST['questions'] as $key => $value) {
        Response::update([
            'text' => $value,
        ])->where('id', $key)->execute();
    }

    Router::redirect('/exercises/' . $params['exercise_id'] . '/fulfillments/' . $params['fulfillment_id'] . '/edit');
});

$router->get('/:', function() use ($renderer) {
    http_response_code(404);

    $renderer->view('views/not_found.php')->render();

});

$router->execute();
