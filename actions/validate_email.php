<?php
$sql = "SELECT userPassword FROM members WHERE email='" . mysqli_real_escape_string($conn, $email) . "';";
$result = $conn->query($sql);

if ($result->num_rows === 1) {
    responseBuilder(false, "This is a valid user.", "OK");
} else {
    responseBuilder(true, $email." could not be found.", "INVALID_USER");
}
