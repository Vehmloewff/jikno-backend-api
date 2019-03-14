<?php
if ($password && $email) {
	$sql = "SELECT content FROM members WHERE email='" . mysqli_real_escape_string($conn, $email) . "' AND userPassword='" . mysqli_real_escape_string($conn, $password) . "';";
	$result = $conn->query($sql);

	if ($result->num_rows == 1) {
		while ($row = $result->fetch_assoc()) {
			$obj = $row["content"];
			$obj = json_decode($obj);
            responseBuilder(false, $obj->user_info, "OK");
		}
	} else {
		responseBuilder(true, "The password/email is not valid", "INVALID_USER");
	}
} else {
	responseBuilder(true, "Invalid params", "INVALID_PARAMS");
}