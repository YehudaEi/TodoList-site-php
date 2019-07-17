<?php 
    include 'session.php';

    session_unset();
    session_destroy();

    header('Location: index.php');
?>