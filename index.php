<?php
//Check for valid access
require 'constants/keys.php';
$key = $_GET['key'];
$validRequest = false;
$arrlength = count($validApiKeys);
for ($i = 0; $i < $arrlength; $i++) {
    if ($key == $validApiKeys[$i]) {
        $validRequest = true;
    }
}
if (!$validRequest) {
    responseBuilder('die', "Invalid key!  You do not have permission to access these users.", "FAILED");
}

$action = $_GET["action"];

$username = $_POST["username"];
$password = $_POST["password"];
$email = $_POST["email"];
$oldEmail = $_POST["oldEmail"];

$content = $_POST['content'];
$branch_name = $_POST['branch_name'];
$url = $_POST["url"];

$subject = $_POST["subject"];
$notification = $_POST["notification"];

$response = false;

// Create connection
require 'constants/connection-details.php';
$conn = new mysqli($sv, $us, $ps, $db);

// Check connection
if ($conn->connect_error) {
    responseBuilder('die', "Connection failed: " . $conn->connect_error, "FAILED");
}

//Create user
if ($action == "create_user") {
    include 'actions/create_user.php';
}

// Validate User
else if ($action == "validate_user") {
    include 'actions/validate_user.php';
}

// Get user info
else if ($action == "get_user_info") {
    include 'actions/get_user_info.php';
}

//Set user info
else if ($action == "set_user_info") {
    include 'actions/set_user_info.php';
}

//Sub_content
else if ($action == "sub_content") {
    include 'actions/sub_content.php';
}

// Get content
else if ($action == "get_content") {
    include 'actions/get_content.php';
}

// email_user
else if ($action == "email_user") {
    include 'actions/email_user.php';
}

// get_apps
else if ($action == "get_apps") {
    include 'actions/get_apps.php';
}

// validate_email
else if ($action == "validate_email") {
	include 'actions/validate_email.php';
}

// change-values
else if ($action == "change_values") {
	include 'actions/change_values.php';
}

// new_vist
else if ($action == "new_visit") {
	include 'actions/new_visit.php';
}

// get_visits
else if ($action == "get_visits") {
	include 'actions/get_visits.php';
}

// get_visits
else if ($action == "upload_file") {
	include 'actions/upload_file.php';
}

// Catch the error
else {
    responseBuilder(true, "A valid action was not specified", "FAILED");
}

// Validate User Function
function validateUser($conn, $email, $password)
{
    $sql = "SELECT userPassword FROM members WHERE email='$email';";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        while ($row = $result->fetch_assoc()) {
            if ($row["userPassword"] == $password) {
                return true;
            } else {
                return false;
            }

        }
    } else {
        return false;
    }
}

function responseBuilder($error, $data, $code) {
    global $response;
    if ($error === "die") {
        $response = new StdClass;
	    $response->error = true;
	    $response->data = $data;
        $response->code = $code;
        die(json_encode($response));
    }else{
        $response = new StdClass;
	    $response->error = $error;
	    $response->data = $data;
        $response->code = $code;
    }
}

// Throw a JSON error if for some reason we are not outputing JSON
if (!$response) {
    responseBuilder(true, "Internal error!", "FAILED");
}

echo json_encode($response);

$conn->close();
?>
