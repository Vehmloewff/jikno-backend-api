<?php
if ($email && $password) {
    if (validateUser($conn, $email, $password) == true) {
        responseBuilder(false, "Valid user.", "OK");
    } else {
        responseBuilder(true, "Invalid user!", "INVALID_USER");
    }
} else {
    responseBuilder(true, "Invalid params!", "INVALID_PARAMS");
}
