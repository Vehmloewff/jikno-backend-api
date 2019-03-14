<?php
if ($email && $password && $content) {

    //First, get the content
    $sql = "SELECT content FROM members WHERE email='" . mysqli_real_escape_string($conn, $email) . "' AND userPassword='" . mysqli_real_escape_string($conn, $password) . "';";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        while ($row = $result->fetch_assoc()) {
            $obj = $row["content"];
            $obj = json_decode($obj);
            $obj->user_info = json_decode($content);
            $contentWithMain = json_encode($obj);
        }

        // Then update the user_info branch
        $sql = "UPDATE members SET content='" . mysqli_real_escape_string($conn, $contentWithMain) . "' WHERE email='" . mysqli_real_escape_string($conn, $email) . "' AND userPassword='" . mysqli_real_escape_string($conn, $password) . "';";

        if ($conn->query($sql) === true) {
            responseBuilder(false, "Set the user info successfully.", "OK");
        } else {
            responseBuilder(true, "Error updating record: " . $conn->error, "FAILED");
        }
    } else {
        responseBuilder(true, "The password/email is not valid.", "INVALID_USER");
    }
} else {
    responseBuilder(true, "Invalid params!", "INVALID_PARAMS");
}
