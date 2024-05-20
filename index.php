<?php
require_once("class/User.class.php");
require_once("class/Post.class.php");
session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
        rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
        crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Nagłowek strony</h1>
    </header>
    <div id="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-between px-3">
            <a class="navbar-brand">Nawigacja</a>
            <?php if(User::isLogged()) :?>
                <!-- zalogowany -->
                <a href="profile.php">
                    <button class="btn btn-primary">
                        <i class="fa-solid fa-user"></i> Profil
                    </button>
                </a>
            <?php else:?>
                <!-- nie zalogowany -->
                <a href="login.php">
                    <button class="btn btn-primary">
                        <i class="fa-solid fa-user"></i> Zaloguj się
                    </button>
                </a>
            <?php endif;?> 
        </nav>
        <?php
        $postList = Post::GetPosts();
        foreach ($postList as $post) {
            //iterujemy przez tablicę postów
            echo '<div class="post-block">';
            echo '<h2 class="post-title">'.$post->GetTitle().'</h3>';
            echo '<h3 class="post-author">'.$post->GetAuthor().'</6>';
            echo '<h3 class="post-author">'.$post->GetAuthorEmail().'</h2>';
            echo '<img src="'.$post->GetImageURL().'" alt="obrazek posta" class="post-image">';
            echo '<div class="post-footer">
                <span class="post-meta">'.$post->GetTimestamp().'</span>';
            echo '<span class="post-score">TODO: punkty</span>';
            echo '</div>';
            echo '</div>'; //post-block
        }
   ?>
    </div>
    <script src="https://kit.fontawesome.com/4f765d06bb.js" crossorigin="anonymous"></script>
</body>
</html>