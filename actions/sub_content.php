<?php
if ($email && $password && $content && $branch_name) {

    //First, get the content
    $sql = "SELECT content FROM members WHERE email='" . mysqli_real_escape_string($conn, $email) . "' AND userPassword='" . mysqli_real_escape_string($conn, $password) . "';";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        while ($row = $result->fetch_assoc()) {
            $info = json_decode($row["content"]);
            foreach ($info as $x => $val) {
                $obj[$x] = $val;
            }
            $obj[$branch_name] = json_decode($content);
            $contentWithMain = json_encode($obj);
        }

        // Then update the user_info branch
        $sql = "UPDATE members SET content='" . mysqli_real_escape_string($conn, $contentWithMain) . "' WHERE email='" . mysqli_real_escape_string($conn, $email) . "' AND userPassword='" . mysqli_real_escape_string($conn, $password) . "';";

        if ($conn->query($sql) === true) {
            responseBuilder(false, "The server has updated the ".$branch_name." branch with success.", "OK");
        } else {
            responseBuilder(true, "Error updating record: " . $conn->error, "FAILED");
        }
    } else {
        responseBuilder(true, "The password/email is not valid", "INVALID_USER");
    }
} else {
    responseBuilder(true, "Invalid params", "INVALID_PARAMS");
}
