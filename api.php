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
    if ($password && $email) {
        if (!$content) {
            $content["user_info"] = new StdClass;
        }
        $content = json_encode($content);

        $sql = "SELECT email FROM members WHERE email='" . mysqli_real_escape_string($conn, $email) . "'";
        $result = $conn->query($sql);

        if ($result->num_rows !== 0) {
            $obj->error = true;
            $obj->message = "This account already exists";
            $response = $obj;
        } else {
            $sql = "INSERT INTO members (email, userPassword, content)
    		VALUES ('" . mysqli_real_escape_string($conn, $email) . "', '" . mysqli_real_escape_string($conn, $password) . "', '" . mysqli_real_escape_string($conn, $content) . "')";

            if ($conn->query($sql) === true) {
                $obj = array(true);
                $response = $Obj;
            } else {
                $obj->error = true;
                $obj->message = "Error: " . $conn->error;
                $response = $obj;
            }
        }

    } else {
        $obj->error = true;
        $obj->message = "Params are not valid";
        $response = $obj;
    }
}

// Validate User
else if ($action == "validate_user") {
    if ($email && $password) {
        if (validateUser($conn, $email, $password) == true) {
            $response = array(true);
        } else {
            $response = array(false);
        }
    } else {
        $obj->error = true;
        $obj->message = "Invalid params";
        $response = $obj;
    }
}

// Get user info
else if ($action == "get_user_info") {
    if ($password && $email) {
        $sql = "SELECT content FROM members WHERE email='" . mysqli_real_escape_string($conn, $email) . "' AND userPassword='" . mysqli_real_escape_string($conn, $password) . "';";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            while ($row = $result->fetch_assoc()) {
                $obj = $row["content"];
                $obj = json_decode($obj);
                $response = $obj->user_info;
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
}

//Set user info
else if ($action == "set_user_info") {
    if ($email && $password && $content) {

        //First, get the content
        $sql = "SELECT content FROM members WHERE email='" . mysqli_real_escape_string($conn, $email) . "' AND userPassword='" . mysqli_real_escape_string($conn, $password) . "';";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            while ($row = $result->fetch_assoc()) {
                $obj = $row["content"];
                $obj = json_decode($obj);
                $obj->user_info = json_decode($content);
                $contentWithMain = json_encode($obj);
            }

            // Then update the user_info branch
            $sql = "UPDATE members SET content='" . mysqli_real_escape_string($conn, $contentWithMain) . "' WHERE email='" . mysqli_real_escape_string($conn, $email) . "' AND userPassword='" . mysqli_real_escape_string($conn, $password) . "';";

            if ($conn->query($sql) === true) {
                $response = array(true);
            } else {
                $obj->error = true;
                $obj->message = "Error updating record: " . $conn->error;
                $response = $obj;
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
}

//Sub_content
else if ($action == "sub_content") {
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
                $response = array(true);
            } else {
                $obj->error = true;
                $obj->message = "Error updating record: " . $conn->error;
                $response = $obj;
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
}

// Get content
else if ($action == "get_content") {
    if ($password && $email && $branch_name) {
        $sql = "SELECT content FROM members WHERE email='" . mysqli_real_escape_string($conn, $email) . "' AND userPassword='" . mysqli_real_escape_string($conn, $password) . "';";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            while ($row = $result->fetch_assoc()) {
                $obj = $row["content"];
				$obj = json_decode($obj);
				foreach ($obj as $key => $val){
					if ($key == $branch_name) {
						$response = $val;
					}
				}
                if (!$response) {
					$response -> error = true;
                    $response -> code = "INVALID_BRANCH";
					$response -> message = "The branch you requested does not exist.";
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

// Throw a JSON error if for some reason we are not outputing JSON
if (!$response) {
    $obj->error = true;
    $obj->message = "Internal error!";
    $response = $obj;
}

echo json_encode($response);

$conn->close();
?>
