<?php

require_once 'models/exercise.php';

$test = Exercise::select()->where('state', 'answering')->execute();
print_r($test);
?>

<header class="header">
    <a href="/">
        <img src="/static/logo.png" class="logo" alt="logo">
    </a>
</header>
<div class="content">
    <div class="exercise-list">
        <div class="exercise-card">
            <div class="exercise-title">Title of the exercise</div>
            <button class="button button-purple">Take it</button>
        </div>
    </div>
</div>