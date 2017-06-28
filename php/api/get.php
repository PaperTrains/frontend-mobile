<?php
require "../db/config.php";

$query = "SELECT * FROM image_uploads ORDER BY id LIMIT 10";

$result = $conn->query($query);

$dataArray = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $item = [
            "id" => $row["id"],
            "path" => $row["path"],
            "message" => $row["message"]
        ];
        array_push($dataArray, $item);
    }
}

echo json_encode($dataArray);
?>