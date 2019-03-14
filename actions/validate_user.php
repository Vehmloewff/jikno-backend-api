<?php
if ($email && $password) {
    if (validateUser($conn, $email, $password) == true) {
        responseBuilder(false, true, "OK");
    } else {
        responseBuilder(true, false, "INVALID_USER");
    }
} else {
    responseBuilder(true, "Invalid params!", "INVALID_PARAMS");
}
