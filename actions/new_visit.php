<?php
if ($url) {
    $sql = "SELECT content FROM views";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        while ($row = $result->fetch_assoc()) {
            $views = json_decode($row['content']);
			array_push($views, $url);

			$sql = "UPDATE views SET content='" . mysqli_real_escape_string($conn, json_encode($views)) . "';";
			if ($conn->query($sql)) {
				responseBuilder(false, "Logged new view!", "OK");
			}else{
				responseBuilder(true, "Error updating record: " . $conn->error, "FAILED");
			}
        }
    } else {
        responseBuilder(true, "Unknown error!", "FAILED");
    }
} else {
    responseBuilder(true, "Invalid params", "INVALID_PARAMS");
}
