<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Login-Papertrain</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="./app/css/uploadWindows.css">
</head>
<body>
    <div class="main-container">
        <div class="polaroidContainer">
            <div id="upload" class="upload">
                <img id="camera" class="camera" src="./app/images/Camera_ICOON.png">
                <img id="checkmark" class="checkmark hidden" src="./app/images/Done_ICOON.png">
                <span id= "upload-text" class="upload-text">Voeg uw foto toe</span>
                <input type="file" id="file-input"/>
            </div>
            <div id="thumb-output" class="hidden"></div>
            <input type="text" id="picture-input" class="picture-input hidden" name="picture-text" placeholder="Typ uw bericht">
        </div>
        <div id="information-container" class="information-container">
            <div class="text-container">
                <span class="picture-text">Voeg uw foto toe in het polaroid frame</span><br>
                <span class="message-text">Maak een persoonlijk tekstje voor eronder</span><br>
                <span class="shake-text">Shake it like a polaroid picture</span><br>
            </div>
        </div>
        <input id="reveal-button" class="hidden" type="submit" value="Laat zien">
        <input id="send-button" class="hidden" type="submit" value="Vesturen">
    </div>
    <script src="./app/js/lib/jquery-3.2.1.min.js"></script>
  <script src="./app/js/imagePreview.js"></script>
</body>
</html>