<?php

    $db = mysqli_connect("localhost", "root", "", "php_pusher");
    if ($db->connect_error) {
        echo "FAILED";
        exit;
    }