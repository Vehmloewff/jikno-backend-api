<?php
$sql = "SELECT content FROM views";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
	while ($row = $result->fetch_assoc()) {
		responseBuilder(false, json_decode($row['content']), "OK");
	}
} else {
	responseBuilder(true, "Unknown error!", "FAILED");
}