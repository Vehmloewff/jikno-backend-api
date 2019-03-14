<?php
if ($password && $email) {
    if (!$content) {
        $content["user_info"] = new StdClass;
        $content = json_encode($content);
    }

    $sql = "SELECT email FROM members WHERE email='" . mysqli_real_escape_string($conn, $email) . "'";
    $result = $conn->query($sql);

    if ($result->num_rows !== 0) {
        responseBuilder(true, "This account already exists!", "ACCOUNT_EXISTS");
    } else {
        $sql = "INSERT INTO members (email, userPassword, content)
			VALUES ('" . mysqli_real_escape_string($conn, $email) . "', '" . mysqli_real_escape_string($conn, $password) . "', '" . mysqli_real_escape_string($conn, $content) . "')";

        if ($conn->query($sql) === true) {
            responseBuilder(false, "Created account successfully", "OK");
        } else {
            responseBuilder(true, "Error: ".$conn->error, "FAILED");
        }
    }

} else {
    responseBuilder(true, "Invalid params", "INVALID_PARAMS");
}
