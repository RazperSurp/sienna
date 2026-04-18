<?php 
    require(__DIR__. '/core/Application.php');
    $config = require(__DIR__. '/config/params.php');

    new \core\K420($config);

    echo '<pre>';
    print_r(\core\K420::$app);
    exit;
?>