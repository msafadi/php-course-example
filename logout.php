<?php

include __DIR__ . '/includes/functions.php';

session_start();

unset($_SESSION['auth']);

session_destroy();

redirect('login.php');