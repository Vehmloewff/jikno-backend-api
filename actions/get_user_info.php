<?php
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