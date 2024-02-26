<?php
if($_SERVER["REQUEST_METHOD"] === "POST") {
    if(isset($_POST['postTitle']) && isset($_POST['postDescription']) && isset($_FILES['file'])) {
        $targetDirectory = "img/";
        
        $fileName = uniqid() . '_' . basename($_FILES['file']['name']);
        
        $targetPath = $targetDirectory . $fileName;
        if(move_uploaded_file($_FILES['file']['tmp_name'], $targetPath)) {

            $postTitle = $_POST['postTitle'];
            $postDescription = $_POST['postDescription'];
            
            echo "Plik został pomyślnie przesłany!";
        } else {
            echo "Wystąpił błąd podczas przesyłania pliku.";
        }
    } else {
        echo "Nieprawidłowe dane przesłane.";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodaj nowy post</title>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <label for="postTitleInput">Tytuł posta:</label>
        <input type="text" name="postTitle" id="postTitleInput">
        <br>
        <label for="postDescriptionInput">Opis posta:</label>
        <input type="text" name="postDescription" id="postDescriptionInput">
        <br>
        <label for="fileInput">Obrazek:</label>
        <input type="file" name="file" id="fileInput">
        <br>
        <input type="submit" value="Wyślij!">
    </form>
</body>
</html>
