<?php
$renderer = Renderer::get_instance();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/static/style.css">
    <script src="/scripts/filter.js"></script>
    <script src="/scripts/events.js"></script>
</head>

<body>
    <div class="container">
        <?php include($renderer->view_path); ?>
    </div>
</body>

</html>