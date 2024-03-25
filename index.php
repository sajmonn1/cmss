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
        <h1>cms</h1>
    </header>
    <div id="mid">
        <?php
        // Establishing a database connection
        $db = new mysqli('localhost', 'root', '', 'cms');
        
        // Check if the connection was successful
        if ($db->connect_errno) {
            echo "Failed to connect to MySQL: " . $db->connect_error;
            exit();
        }

        // Prepare and execute the SQL query
        $q = $db->prepare("SELECT post.id, post.title, post.content, post.timestamp, user.email
        FROM post
        INNER JOIN user ON post.author_id = user.id");

        // Check if the query preparation was successful
        if (!$q) {
            echo "Error preparing query: " . $db->error;
            exit();
        }

        // Execute the query
        $result = $q->execute();

        // Check if the query execution was successful
        if (!$result) {
            echo "Error executing query: " . $db->error;
            exit();
        }

        // Get the result set
        $result = $q->get_result();

        // Loop through the result set and display posts
        while ($row = $result->fetch_assoc()) {
            echo '<div class="post">';
            echo '<h2 class="posttitle">' . $row['title'] . '</h2>';
            echo '<h3 class="postauthor">' . $row['email'] . '</h3>';
            echo '<p class="postcontent">' . $row['content'] . '</p>';
            echo '<div class="postfooter">';
            echo '<span class="postmeta">' . $row['timestamp'] . '</span>';
            echo '<span class="postscore">POINTS</span>';
            echo '</div>';
            echo '</div>';
        }

        // Close the prepared statement and database connection
        $q->close();
        $db->close();
        ?>
    </div>
</body>
</html>
