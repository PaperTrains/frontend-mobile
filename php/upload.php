<?php
session_start();

require "db/config.php";

if (!isset($_SESSION['upload_sessions_id'])) {
    $_SESSION["upload_sessions_id"] = rand();
}

$session_id = $_SESSION["upload_sessions_id"]; // User session id

$baseurl = "http://project.cmi.hr.nl/2016_2017/medialab_ns_t1/paper_trains/images/";

// make dir if it doenst exist
$path = "uploads/";
$url_path = $baseurl . $path;
$message = "";

if (!file_exists($path)) {
    mkdir($path, 0755, true);
}

$valid_formats = array("image/jpg", "image/png", "image/gif", "image/jpeg");

$result = [
    "error" => false,
    "error_description" => null,
    "file_location" => null,
    "photo_nr" => null
];

if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {

    $name = $_FILES['photo']['name'];
    $size = $_FILES['photo']['size'];
    $message = $_POST['message'];
    $photoCount = null;
    if (isset($_POST['count']) && !empty($_POST['count'])) {
        $photoCount = $_POST['count'];
    }
    // check if image is sent
    if(strlen($name)) {
        $ext = explode("/", $_FILES['photo']['type'])[1];
        // check if file is valid image
        if(in_array($_FILES['photo']['type'],$valid_formats)) {
            // check if file size is not to large
            if($size < 10240000) // Image size max 10MB
            {
                $actual_image_name = $session_id."nr".time().".".$ext;
                $tmp = $_FILES['photo']['tmp_name'];

                $exif = array();
                if(function_exists('exif_read_data')) {
                    $exif = @exif_read_data($tmp);
                }

                $filetype = getimagesize($tmp);

                //save image
                if(isset($exif['Orientation']) && !empty($exif['Orientation']) && $filetype['mime'] == "image/jpeg") {
                    //image contains rotation data
                    $imageResource = imagecreatefromjpeg($tmp); // provided that the image is jpeg.

                    switch ($exif['Orientation']) {
                        case 3:
                            $image = imagerotate($imageResource, 180, 0);
                            break;
                        case 6:
                            $image = imagerotate($imageResource, -90, 0);
                            break;
                        case 8:
                            $image = imagerotate($imageResource, 90, 0);
                            break;
                        default:
                            $image = $imageResource;
                    }

                    $saveImageSuccess = imagejpeg($image, $path.$actual_image_name, 50);

                    if(is_resource($imageResource)) {
                        imagedestroy($imageResource);
                    }
                    if(is_resource($imageResource)) {
                        imagedestroy($image);
                    }
                } else {
                    $saveImageSuccess = move_uploaded_file($tmp, $path.$actual_image_name);
                }


                //save image
                if($saveImageSuccess) {
                    $result["file_location"] = $url_path.$actual_image_name;
                    $result["photo_nr"] = $_POST['count'];
                }
                else {
                    $result["error"] = true;
                    $result["error_description"] = "Opslaan mislukt.";
                }
            }
            else {
                $result["error"] = true;
                $result["error_description"] = "Maximale bestandsgrootte van 10MB overschreden.";
            }
        }
        else {
            $result["error"] = true;
            $result["error_description"] = "Geen geldig bestandsformaat. Alleen jpg, png en gif zijn toegestaan.";
        }
    }
    else {
        $result["error"] = true;
        $result["error_description"] = "Geen afbeelding meegestuurd.";
    }
}

$imagePath = $url_path . $actual_image_name;

$query = "INSERT INTO image_uploads (path, message) VALUES ('$imagePath', '$message')";

if($conn->query($query) === TRUE)
{
    echo json_encode($result);
}
else
{
    echo "Something went wrong";
}
