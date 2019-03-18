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

        $returnArr = array();
        foreach ($apps as $branch => $branch_data) {
            $used_app = false;
            foreach($branch_data->users as $user) {
                if ($user == $email) {
                    $used_app = true;
                }
            }

            $obj->name = $branch_data->name;
            $obj->icon = $path.$branch.$default_extension;
            $obj->active_by_user = $used_app;
            $obj->description = $branch_data->description;
            $obj->popularity = count($branch_data->users) / $number_of_users;
            $obj->branch = $branch;

            array_push($returnArr, $obj);
        }

        responseBuilder(false, $returnArr, "OK");



    } else {
        responseBuilder(true, "No database!", "FAILED");
    }
}else{
    responseBuilder(true, "Invalid params!", "INVALID_PARAMS");
}