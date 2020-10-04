<?php
$renderer = Renderer::get_instance();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/static/style.css">
</head>

<body>
    <div class="container">
        <?php include($renderer->view_path); ?>
    </div>
</body>

</html>