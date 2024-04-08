<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie użytkownika</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
        rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
        crossorigin="anonymous">
</head>
<body>
    <div class="container">
    <?php if(isset($_REQUEST['submit'])) : ?>
        <!-- Jeśli został wysłany formularz to... -->
        
    <?php else : ?>
        <!-- Jeśli nie został jeszcze wysłany formularz to... -->
        <div class="row mt-5">
            <div class="col-6 offset-3">
                <h1 class="text-center">Logowanie użytkownika</h1>
                <form action="login.php" method="post">
                    <label class="form-label mt-3" for="emailInput">Adres e-mail:</label>
                    <input class="form-control mb-1" type="email" id="emailInput" name="email" required>
                    <label class="form-label mt-3" for="passwordInput">Hasło:</label>
                    <input class="form-control mb-1" type="password" id="passwordInput" name="password" required>
                    <button type="submit" class="btn btn-primary w-100 mt-3">Zaloguj</button>
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