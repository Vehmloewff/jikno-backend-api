<?php
if ($email && $password) {
    $sql = "SELECT content FROM apps_details";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        while($row = $result->fetch_assoc()) {
            $apps = json_decode($row["content"]);
        }


        $obj = new StdClass;
        foreach ($apps as $branch => $branch_data) {
            $used_app = false;
            foreach($branch_data->users as $user) {
                if ($user == $email) {
                    $used_app = true;
                }
            }

            if ($used_app) {
                $obj[$branch] = $branch_data;
            }
        }

        responseBuilder(false, $obj, "OK");



    } else {
        responseBuilder(true, "No database!", "FAILED");
    }
}else{
    responseBuilder(true, "Invalid params!", "INVALID_PARAMS");
}