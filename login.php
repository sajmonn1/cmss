<?php
if (isset($_REQUEST['action']) && $_REQUEST['action'] == "login") {
    $login = $_REQUEST['login'];
    $password = $_REQUEST['password'];

    $login = filter_var($login, FILTER_SANITIZE_EMAIL);

    $db = new mysqli("localhost", "root", "", "cms");
    if ($db->connect_errno) {
        echo "Błąd podczas łączenia z bazą danych: " . $db->connect_error;
        exit();
    }

    $q = $db->prepare("SELECT * FROM user WHERE Login = ? LIMIT 1");
    if (!$q) {
        echo "Błąd przygotowywania zapytania SQL: " . $db->error;
        exit();
    }

    $q->bind_param("s", $login);
    $q->execute();
    $result = $q->get_result();

    $userRow = $result->fetch_assoc();

    if ($userRow == null) {
        echo "Błędny login lub hasło <br>";
    } else {
        if (password_verify($password, $userRow["password"])) {
            echo "Zalogowano poprawnie <br>";
        } else {
            echo "Błędny login lub hasło <br>";
        }
    }
}

if (isset($_REQUEST['action']) && $_REQUEST['action'] == "register" && isset($_REQUEST['login']) && isset($_REQUEST['password']) && isset($_REQUEST['passwordRepeat'])) {
    $db = new mysqli("localhost", "root", "", "cms");
    if ($db->connect_errno) {
        echo "Błąd podczas łączenia z bazą danych: " . $db->connect_error;
        exit();
    }

    $login = $_REQUEST['login'];
    $login = filter_var($login, FILTER_SANITIZE_EMAIL);

    $password = $_REQUEST['password'];
    $passwordRepeat = $_REQUEST['passwordRepeat'];

    if ($password == $passwordRepeat) {
        $q = $db->prepare("INSERT INTO user (Login, Password) VALUES (?, ?)");
        if (!$q) {
            echo "Błąd przygotowywania zapytania SQL: " . $db->error;
            exit();
        }
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $q->bind_param("ss", $login, $passwordHash);
        $result = $q->execute();

        if ($result) {
            echo "Konto utworzone poprawnie";
        } else {
            echo "Coś poszło nie tak";
        }
    } else {
        echo "Hasła się nie zgadzają, spróbuj ponownie.";
    }
}
?>

<form action="login.php" method="post">
    <label for="login">Login: </label> <br>
    <input type="text" name="login" id="login"><br>
    <label for="password">Hasło: </label> <br>
    <input type="password" name="password" id="password"> <br>
    <input type="hidden" name="action" value="login">
    <input type="submit" value="Zaloguj">
</form>

<h1>Rejestracja</h1>
<form action="login.php" method="post">
    <label for="login">Login: </label> <br>
    <input type="text" name="login" id="login"><br>
    <label for="password">Hasło: </label> <br>
    <input type="password" name="password" id="password"> <br>
    <label for="passwordRepeat">Powtórz hasło: </label> <br>
    <input type="password" name="passwordRepeat" id="passwordRepeat"> <br>
    <input type="hidden" name="action" value="register">
    <input type="submit" value="Zarejestruj">
</form>
