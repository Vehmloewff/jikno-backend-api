<?php
$target_dir = "cloud/avatars/";
$file_name = $_FILES['file']['name'];
$file_tmp = $_FILES['file']['tmp_name'];

if (move_uploaded_file($file_tmp, $target_dir . $file_name)) {
    responseBuilder(false, "File uploaded", "OK");
} else {
    responseBuilder(true, "Error in file upload!", "FAILED");
}
