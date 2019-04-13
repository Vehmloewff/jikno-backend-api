<?php
if ($email && $password) {

    // First check to see if the branch is valid, is it registered app?
    $sql = "UPDATE members SET email='" . mysqli_real_escape_string($conn, $email) . "', userPassword='" . mysqli_real_escape_string($conn, $password) . "' WHERE email='" . mysqli_real_escape_string($conn, $email) . "';";
    if ($conn->query($sql) === true) {
		responseBuilder(false, "Changed the values.", "OK");
	} else {
		responseBuilder(true, "Error updating record: " . $conn->error, "FAILED");
	}
} else {
    responseBuilder(true, "Invalid params", "INVALID_PARAMS");
}
