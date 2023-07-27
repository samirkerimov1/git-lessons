<?php

    $localhost = 'localhost';
    $username = 'root';
    $password = 'root';
    $dbname = 'lessonForm';

    $mysqli = mysqli_connect($localhost, $username, $password, $dbname);
    if (!$mysqli) {
        die("Connected failed " . mysqli_connect_error());
    }

    $mode = isset($_REQUEST['mode']) ? $_REQUEST['mode'] : false;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $first_name = isset($_REQUEST['first_name']) ? $_REQUEST['first_name'] : null;
    $last_name = isset($_REQUEST['last_name']) ? $_REQUEST['last_name'] : null;
    $gender = isset($_REQUEST['gender']) ? $_REQUEST['gender'] : null;
    $email = trim($_REQUEST['email']) !== null ? $_REQUEST['email'] : null;
    $password = password_hash(trim($_REQUEST['password']), PASSWORD_BCRYPT);
    $text = isset($_REQUEST['text']) ? $_REQUEST['text'] : null;
    $city = isset($_REQUEST['$city']) ? $_REQUEST['$city'] : null;
    $file = isset($_FILES['$file']) ? $_FILES['$file'] : null;


        $user_is_created = $mysqli->query("INSERT INTO customers (first_name, last_name, gender, email, password, text, city, file) VALUES ('$first_name', '$last_name', '$gender', '$email', '$password', '$text', '$city', '$file')");
    }

    if($mode === 'admin_panel') {
        $email = trim($_REQUEST['email']);

        $user = $mysqli->query("SELECT email, password FROM customers where email = '$email' limit 1");

        $user = mysqli_fetch_array($user, MYSQLI_ASSOC);

        if($user) {
            if(password_verify(trim($_REQUEST['password']), $user['password'])) {

                $user = $mysqli->query("SELECT * FROM customers");

                while ($result = mysqli_fetch_array($user, MYSQLI_ASSOC)) {
                    $users[] = $result;
                }
                require 'users.html';
            }else{
                $failed_verify = 'true';
                require 'auth.html';
            }
        }
        exit;
    }

    if($mode === 'auth') {
        require 'auth.html';
    }
    else{
        require('index.html');
    }

