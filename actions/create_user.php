<?php
if ($password && $email) {
    if (!$content) {
        $content["user_info"] = new StdClass;
    }
    $content = json_encode($content);

    $sql = "SELECT email FROM members WHERE email='" . mysqli_real_escape_string($conn, $email) . "'";
    $result = $conn->query($sql);

    if ($result->num_rows !== 0) {
        $obj->error = true;
        $obj->message = "This account already exists";
        $response = $obj;
    } else {
        $sql = "INSERT INTO members (email, userPassword, content)
    		VALUES ('" . mysqli_real_escape_string($conn, $email) . "', '" . mysqli_real_escape_string($conn, $password) . "', '" . mysqli_real_escape_string($conn, $content) . "')";

        if ($conn->query($sql) === true) {
            $obj = array(true);
            $response = $Obj;
        } else {
            $obj->error = true;
            $obj->message = "Error: " . $conn->error;
            $response = $obj;
        }
    }

} else {
    $obj->error = true;
    $obj->message = "Params are not valid";
    $response = $obj;
}
?>