<?php
if ($email && $password) {
    require 'constants/app-icons-path.php';

    $sql = "SELECT email FROM members";
    $result = $conn->query($sql);
    $number_of_users = $result->num_rows;

    $sql = "SELECT content FROM apps_details";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        while($row = $result->fetch_assoc()) {
            $apps = json_decode($row["content"]);
        }


        foreach ($apps as $branch => $branch_data) {
            $used_app = false;
            foreach($branch_data->users as $user) {
                if ($user == $email) {
                    $used_app = true;
                }
            }

            $obj[$branch]->name = $branch_data->name;
            $obj[$branch]->icon = $path.$branch.$default_extension;
            if ($used_app) {
                $obj[$branch]->active_by_user = true;
            }else{
                $obj[$branch]->active_by_user = false;
            }
            $obj[$branch]->description = $branch_data->description;
            $obj[$branch]->popularity = count($branch_data->users) / $number_of_users;
        }

        responseBuilder(false, $obj, "OK");



    } else {
        responseBuilder(true, "No database!", "FAILED");
    }
}else{
    responseBuilder(true, "Invalid params!", "INVALID_PARAMS");
}