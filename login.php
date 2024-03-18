<?php
if (isset($_REQUEST['action']) && $_REQUEST['action'] == "login") {
    $email = $_REQUEST['email'];
    $password = $_REQUEST['password'];

    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    $db = new mysqli("localhost", "root", "", "cmss");

    $q = $db->prepare("SELECT * FROM user WHERE email = ? LIMIT 1");
    $q->bind_param("s", $email);
    $q->execute();
    $result = $q->get_result();

    $userRow = $result->fetch_assoc();
    if ($userRow == null) {
        // Log login attempt
        $log = fopen("logs.txt", "a");
        fwrite($log, date("Y-m-d H:i:s") . " - Failed login attempt for email: $email\n");
        fclose($log);

        echo "Błędny login lub hasło <br>";
    } else {
        if (password_verify($password, $userRow['passwordHash'])) {
            // Log successful login
            $log = fopen("logs.txt", "a");
            fwrite($log, date("Y-m-d H:i:s") . " - Successful login for email: $email\n");
            fclose($log);

            echo "Zalogowano poprawnie <br>";
        } else {
            // Log failed login attempt
            $log = fopen("logs.txt", "a");
            fwrite($log, date("Y-m-d H:i:s") . " - Failed login attempt for email: $email\n");
            fclose($log);

            echo "Błędny login lub hasło <br>";
        }
    }
}

if (isset($_REQUEST['action']) && $_REQUEST['action'] == "register") {
    $db = new mysqli("localhost", "root", "", "cmss");
    $email = $_REQUEST['email'];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    $password = $_REQUEST['password'];
    $passwordRepeat = $_REQUEST['passwordRepeat'];

    if($password == $passwordRepeat) {
        $q = $db->prepare("INSERT INTO user (email, passwordHash) VALUES (?, ?)");
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $q->bind_param("ss", $email, $passwordHash);
        $result = $q->execute();
        if($result) {
            // Log successful registration
            $log = fopen("logs.txt", "a");
            fwrite($log, date("Y-m-d H:i:s") . " - New account registered for email: $email\n");
            fclose($log);

            echo "Konto utworzono poprawnie"; 
        } else {
            // Log failed registration attempt
            $log = fopen("logs.txt", "a");
            fwrite($log, date("Y-m-d H:i:s") . " - Failed registration attempt for email: $email\n");
            fclose($log);

            echo "Coś poszło nie tak!";
        }
    } else {
        echo "Hasła nie są zgodne - spróbuj ponownie!";
    }
}

?>

<h1>Zaloguj się</h1>
<form action="index.php" method="post">
    <label for="emailInput">Email:</label>
    <input type="email" name="email" id="emailInput">
    <label for="passwordInput">Hasło:</label>
    <input type="password" name="password" id="passwordInput">
    <input type="hidden" name="action" value="login">
    <input type="submit" value="Zaloguj">
</form>

<h1>Zarejestruj się</h1>
<form action="index.php" method="post">
    <label for="emailInput">Email:</label>
    <input type="email" name="email" id="emailInput">
    <label for="passwordInput">Hasło:</label>
    <input type="password" name="password" id="passwordInput">
    <label for="passwordRepeatInput">Hasło ponownie:</label>
    <input type="password" name="passwordRepeat" id="passwordRepeatInput">
    <input type="hidden" name="action" value="register">
    <input type="submit" value="Zarejestruj">
</form>