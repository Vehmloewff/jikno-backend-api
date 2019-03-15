<?php
if ($password && $email && $branch_name) {

    $app_skeleton = new StdClass;

    $sql = "SELECT content from apps_details";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        while ($row = $result->fetch_assoc()) {
            $apps_detail = json_decode($row['content']);
            $valid_branch = false;
            foreach($apps_detail as $app_branch => $app_detail) {
                if ($app_branch == $branch_name) {
                    $valid_branch = true;
                    $app_skeleton = $app_detail->skeleton;
                }
            }
        }
        if (!$valid_branch) {
            responseBuilder('die', "Invalid branch ".$branch_name, "INVALID_BRANCH");
        }
    } else {
        responseBuilder('die', "No database", "FAILED");
    }

    $sql = "SELECT content FROM members WHERE email='" . mysqli_real_escape_string($conn, $email) . "' AND userPassword='" . mysqli_real_escape_string($conn, $password) . "';";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        while ($row = $result->fetch_assoc()) {
            $obj = $row["content"];
            $obj = json_decode($obj);
            foreach ($obj as $key => $val) {
                if ($key == $branch_name) {
                    responseBuilder(false, $val, "OK");
                }
            }
            if (!$response) {
                // Complete the neccecary actions
            }
        }
    } else {
        responseBuilder(true, "The password/email is not valid", "INVALID_USER");
    }
} else {
    responseBuilder(true, "Invalid params", "INVALID_PARAMS");
}
