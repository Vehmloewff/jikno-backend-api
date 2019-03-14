<?php
if ($password && $email && $branch_name) {
    $sql = "SELECT content FROM members WHERE email='" . mysqli_real_escape_string($conn, $email) . "' AND userPassword='" . mysqli_real_escape_string($conn, $password) . "';";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        while ($row = $result->fetch_assoc()) {
            $obj = $row["content"];
            $obj = json_decode($obj);
            foreach ($obj as $key => $val) {
                if ($key == $branch_name) {
                    $response = $val;
                }
            }
            if (!$response) {
                $response->error = true;
                $response->code = "INVALID_BRANCH";
                $response->message = "The branch you requested does not exist.";
            }
        }
    } else {
        $obj->error = true;
        $obj->message = "The password/email is not valid";
        $response = $obj;
    }
} else {
    $obj->error = true;
    $obj->message = "Invalid params";
    $response = $obj;
}
