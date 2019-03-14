<?php
if ($email && $password) {
    $sql = "SELECT content FROM apps_details";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        while($row = $result->fetch_assoc()) {
            $content = $row["content"];
        }

        







    } else {
        responseBuilder(true, "No database!", "FAILED");
    }
}else{
    responseBuilder(true, "Invalid params!", "INVALID_PARAMS");
}