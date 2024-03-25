<?php
if (isset($_REQUEST['action']) && $_REQUEST['action'] == "login") {
    $login = $_REQUEST['login'];
    $password = $_REQUEST['password'];

    $login = filter_var($login, FILTER_SANITIZE_EMAIL);

    $db = new mysqli("localhost", "root", "", "cms");
    //$q = "SELECT * FROM user WHERE email = '$login'";
    //echo $q;
    // $db->query($q);

    $q = $db->prepare("SELECT * FROM user WHERE Login = ? LIMIT 1");
    $q-> bind_param("s", $login);
    $q->execute();
    $result = $q->get_result();

    $userRow = $result->fetch_assoc();
    // var_dump($userRow);
    if($userRow == null) {
       echo "Błędny login lub hasło <br>";
    } else {
           if(password_verify($password, $userRow["password"])) {
           echo "Zalogowano poprawnie <br>";
       } else {
           echo "Błędny login lub hasło <br>";
    }
}
}
if(isset($_REQUEST['action']) && $_REQUEST['action'] == "register" && isset($_REQUEST['login']) && isset($_REQUEST['password']) &&isset($_REQUEST['passwordRepeat'])) {
    $db = new mysqli("localhost", "root", "", "cms");
    $login = $_REQUEST['login'];
    $login = filter_var($login, FILTER_SANITIZE_EMAIL); 

    $password = $_REQUEST['password'];
    $passwordRepeat = $_REQUEST['passwordRepeat'];
    if($password == $passwordRepeat) {
        $q = $db->prepare("INSERT INTO user VALUES (NULL, ?, ?)");
        $passwordHash = password_hash($password, PASSWORD_ARGON2I);
        $q->bind_param("ss", $login, $passwordHash);
        $result = $q->execute();
        if($result) {
            echo "Konto utworzone poprawnie";
        } else {
            echo "Coś poszło nie tak";
        }
    } else {
        echo "Hasła sie nie zgadzają, spróbuj ponownie.";
    }
}


//$d = mysqli_connect("localhost", "root", "", "cms");
//mysqli_query($d, "SELECT * FROM user");

?>
<form action="login.php" method="post">
    <label for="login">Login: </label> <br>
    <input type="email" name="login" id="login"><br>
    <label for="password">Hasło: </label> <br>
    <input type="password" name="password" id="password"> <br>
    <input type="hidden" name="action" value="login">
    <input type="submit" value="Zaloguj">
</form>
<h1>Register</h1>
<form action="login.php" method="post">
<label for="login">Login: </label> <br>
    <input type="email" name="login" id="login"><br>
    <label for="password">Hasło: </label> <br>
    <input type="password" name="password" id="password"> <br>
    <label for="passwordRepeat">Powtórz hasło: </label> <br>
    <input type="password" name="passwordRepeat" id="passwordRepeat"> <br>
    <input type="hidden" name="action" value="register">
    <input type="submit" value="Zarejestruj">
</form>