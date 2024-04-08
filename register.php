<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejestracja nowego użytkownika</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
        rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
        crossorigin="anonymous">
</head>
<body>
    
    <div class="container">
        <?php if(isset($_REQUEST['submit'])) : ?>
            <!-- Jeśli został wysłany formularz to... -->
            <?php
            //przepisz dane z formularza do lokalnych zmiennych
            $email = $_REQUEST['email'];
            //jeśli hasła się nie zgadzają KYS
            if($_REQUEST['password'] != $_REQUEST['passwordRepeat'])
                die("Hasła niezgodne");
            //przepisujemy hasło...
            $passwd = $_REQUEST['password'];
            //liczymy hash hasła
            $passwordHash = password_hash($passwd, PASSWORD_ARGON2I);
            //łączymy się z bazą
            $db = new mysqli("localhost", "root", '', "cms");
            //szykujemy kwerendę
            $sql = "INSERT INTO user (email, password) VALUES (?, ?)";
            $q = $db->prepare($sql);
            //podstaw dane
            $q->bind_param("ss", $email, $passwordHash);
            $success = $q->execute();
            if(!$success)
                die("Bład przy próbie założenia konta");
            ?>
        <div class="row mt-5">
            <div class="col-6 offset-3">
                <h1 class="text-center">Konto założone</h1>
                <div class="text-center">
                <a href="index.php">Powrót do strony</a>
                </div>
            </div>
        </div>
        <?php else : ?>
            <!-- Jeśli nie został jeszcze wysłany formularz to... -->
        <div class="row mt-5">
            <div class="col-6 offset-3">
                <h1 class="text-center">Rejestracja użytkownika</h1>
                <form action="register.php" method="post">
                    <label class="form-label mt-3" for="emailInput">Adres e-mail:</label>
                    <input class="form-control mb-1" type="email" id="emailInput" name="email" required>
                    <label class="form-label mt-3" for="passwordInput">Hasło:</label>
                    <input class="form-control mb-1" type="password" id="passwordInput" name="password" required>
                    <label class="form-label mt-3" for="passwordInputRepeat">Hasło (ponownie):</label>
                    <input class="form-control mb-1" type="password" id="passwordInputRepeat" name="passwordRepeat" required>
                    <button type="submit" class="btn btn-primary w-100 mt-3">Zarejestruj</button>
                </form>
            </div>
        </div>
        <?php endif; ?>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
        crossorigin="anonymous"></script>
</body>
</html>