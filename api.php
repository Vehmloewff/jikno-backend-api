<?php
//Check for valid access
require 'keys.php';
$key = $_GET['key'];
$validRequest = false;
$arrlength = count($validApiKeys);
for ($i = 0; $i < $arrlength; $i++) {
    if ($key == $validApiKeys[$i]) {
        $validRequest = true;
    }
}
if (!$validRequest) {
    $obj[0] = false;
    die(json_encode($obj));
}

$action = $_GET["action"];

$username = $_POST["username"];
$password = $_POST["password"];
$email = $_POST["email"];

$content = $_POST['content'];
$branch_name = $_POST['branch_name'];

$response;

// Create connection
require 'connection-details.php';
$conn = new mysqli($sv, $us, $ps, $db);

// Check connection
if ($conn->connect_error) {
    $obj->error = true;
    $obj->message = "Connection failed: " . $conn->connect_error;
    die(json_encode($obj));
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

// Catch the error
else {
    $obj->error = true;
    $obj->message = "No valid action param specified";
    $response = $obj;
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
	$response = new StdClass;
	$response->error = $error;
	$response->data = $data;
    $response->code = $code;
}

// Throw a JSON error if for some reason we are not outputing JSON
if (!$response) {
    responseBuilder(true, "Internal error!", "FAILED");
}

echo json_encode($response);

$conn->close();
?>
