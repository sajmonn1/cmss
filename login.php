<?php
$db = new mysqli("localhost", "root", "", "breaddit");

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

if (isset($_REQUEST['action']) && $_REQUEST['action'] == "register") {
    $username = $_REQUEST['username'];
    $email = $_REQUEST['email'];
    $password = $_REQUEST['password'];

    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $q = $db->prepare("INSERT INTO user (username, email, password) VALUES (?, ?, ?)");
    $q->bind_param("sss", $username, $email, $passwordHash);
    $result = $q->execute();

    if ($result) {
        echo "Account created successfully"; 
    } else {
        echo "Something went wrong!";
    }
}

$q = $db->prepare("SELECT post.id, post.title, post.content, user.username FROM post INNER JOIN user ON post.author_id = user.id");
$q->execute();
$result = $q->get_result();

while ($row = $result->fetch_assoc()) {
    echo "ID: " . $row['id'] . ", Title: " . $row['title'] . ", Content: " . $row['content'] . ", Author: " . $row['username'] . "<br>";
}

$q->close();
$db->close();
?>

<h1>Register</h1>
<form action="index.php" method="post">
    <label for="usernameInput">Username:</label>
    <input type="text" name="username" id="usernameInput">
    <label for="emailInput">Email:</label>
    <input type="email" name="email" id="emailInput">
    <label for="passwordInput">Password:</label>
    <input type="password" name="password" id="passwordInput">
    <input type="hidden" name="action" value="register">
    <input type="submit" value="Register">
</form>
