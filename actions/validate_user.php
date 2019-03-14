<?php
if ($email && $password) {
    if (validateUser($conn, $email, $password) == true) {
        $response = array(true);
    } else {
        $response = array(false);
    }
} else {
    $obj->error = true;
    $obj->message = "Invalid params";
    $response = $obj;
}
