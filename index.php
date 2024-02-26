<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>breaddit</h1>
    </header>
    <div id="mid">
        <?php
        $db = new mysqli('localhost', 'root', '', 'breaddit');
        $q = $db->prepare("Select post.id, post.image, post.title, post.timestamp, user.email
        FROM post
        INNER JOIN user ON post.author = user.ID");
        $q->execute();
        $result = $q->get_result();
        while($row = $result->fetch_assoc()) {
            echo '<div class="post">';
            echo '<h2 class="posttitle">'.$row['title'].'</h2>';
            echo '<h3 class="postauthor">'.$row['email'].'</h3>';
            echo '<img src="'.$row['image'].'" alt="obrazekposta" class=postimage>';
            echo '<p class=postdesc>Post Description </p>';
            echo '<div class="postfooter">
            <span class="postmeta">'.$row['timestamp'].'</span>
            <span class="postscore">POINTS</span>
                </div>';


            echo '</div>';
        }
        ?>


        <!--<div class="post">
            <h3 class="posttitle">Title</h3>
            <h6 class="postauthor">Author</h6>
            <img src="https://picsum.photos/800/600" alt="" class="postimage">
            <p class="postdesc">Post Description</p>
            <div class="postfooter">
                <span class="postmeta">Date and time</span>
                <span class="postscore">+ / -</span>
            </div>
        </div>
        </div>
    -->
    </div>
</body>
</html>