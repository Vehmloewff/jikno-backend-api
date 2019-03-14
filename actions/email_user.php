<?php
if ($email && $content && $subject) {
    // To send HTML mail, the Content-type header must be set
    $headers = "From: jiknobot@jikno.com\r\n";
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";

    // send email
    if (mail($email, $subject, $content, $headers)) {
        $obj->error = false;
        $obj->message = "Emailed ".$email." with success.";
        $response = $obj;
    }else{
        $obj->error = true;
        $obj->message = "Failed to email ".$email;
        $response = $obj;
    }
} else {
    $obj->error = true;
    $obj->message = "Invalid Params!";
    $response = $obj;
}
