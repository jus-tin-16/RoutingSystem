<?php
    require_once 'connect_db.php';
    session_destroy();
    header('Location: Form.php');
?>