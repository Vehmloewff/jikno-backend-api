<?php
$sql = "SELECT content FROM members WHERE email='" . mysqli_real_escape_string($conn, $email) . "' 
AND userPassword='" . mysqli_real_escape_string($conn, $password) . "';";

$result = $conn->query($sql);
if ($result->num_rows != 1) {
    responseBuilder('die', "Username or password is invalid.", "INVALID_USER");
}
while($row = $result->fetch_assoc()) {
    $branches = json_decode($row["content"]);
}

$name_of_branch = null;
$branch_data = null;

foreach($branches as $name_of_branch => $branch_data) {
    $new_branches[$name_of_branch] = $branch_data;
}
$new_branches[$branch_name] = $app_skeleton;


$sql = "UPDATE members SET content='" . json_encode($new_branches) . "' WHERE email='" . mysqli_real_escape_string($conn, $email) . "' 
AND userPassword='" . mysqli_real_escape_string($conn, $password) . "';";

if ($conn->query($sql) != true) {
    responseBuilder('die', "Error adding the ".$branch_name." branch to the user ".$email." - ".$conn->error, "INVALID_USER");
};

$sql = "SELECT content FROM apps_details";
$result = $conn->query($sql);
if ($result->num_rows != 1) {
    responseBuilder("die", "No database", "FAILED");
}
while($row = $result->fetch_assoc()) {
    $apps = json_decode($row['content']);
}
foreach($apps as $app_name => $app_data) {
    if ($app_name == $branch_name) {
        array_push($app_data->users, $email);
    }
}

responseBuilder(false, $app_skeleton, "OK");