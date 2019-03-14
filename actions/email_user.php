<?php
if ($email && $content && $subject) {
    // To send HTML mail, the Content-type header must be set
    $headers = "From: jiknobot@jikno.com\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";

    // send email
    if (mail($email, $subject, $content, $headers)) {
        responseBuilder(true, "Emailed ".$email." with success.", "OK");
    }else{
        responseBuilder(true, "Failed to email ".$email, "FAILED");
    }
} else {
    responseBuilder(true, "Invalid params!", "INVALID_PARAMS");
}
