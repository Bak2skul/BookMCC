<?php
require_once './conn/conn.php';
session_start();

if (isset($_GET['book_id'])) {
    // Use mysqli_real_escape_string to prevent SQL injection
    $book_id = mysqli_real_escape_string($dbc, $_GET['book_id']);

    // Fetch book details and the username of the user who posted the book
    $query = "SELECT Books.*, Users.Username 
              FROM Books 
              JOIN Users ON Books.UserID = Users.UserID 
              WHERE Books.BookID = '$book_id'";
    $result = mysqli_query($dbc, $query);
    $book = mysqli_fetch_assoc($result);

    // Processing form data when a new comment is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["UserID"])) {
        $commentText = mysqli_real_escape_string($dbc, $_POST['commentText']);
        $userID = $_SESSION['UserID'];

        // Insert comment into database
        $insertQuery = "INSERT INTO Comments (BookID, UserID, CommentText) VALUES ('$book_id', '$userID', '$commentText')";
        mysqli_query($dbc, $insertQuery);
    }

    // Fetch comments for this book along with the usernames of the commenters
    $commentsQuery = "SELECT Users.Username, Comments.CommentText, Comments.CommentTime
    FROM Comments
    JOIN Users ON Comments.UserID = Users.UserID
    WHERE Comments.BookID = '$book_id'
    ORDER BY Comments.CommentTime ASC";
    $commentsResult = mysqli_query($dbc, $commentsQuery);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Detail | BookMCC</title>
    <link rel="stylesheet" href="./assets/bootstrap-5.3.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/common.css">
    <script src="./assets/bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <?php
            if ($book) {
                // Use htmlspecialchars to prevent XSS attacks
                echo "<h1>" . htmlspecialchars($book['Title']) . "</h1>";
                echo "<p>Author: "
                    . htmlspecialchars($book['Author'])
                    . "</p>";
                // If has ISBN-13, display it
                if ($book['ISBN_13']) {
                    echo "<p>ISBN-13: "
                        . htmlspecialchars($book['ISBN_13'])
                        . "</p>";
                }
                // If has ISBN-10, display it
                if ($book['ISBN_10']) {
                    echo "<p>ISBN-10: "
                        . htmlspecialchars($book['ISBN_10'])
                        . "</p>";
                }
                // If has course name, display it
                if ($book['CourseName']) {
                    echo "<p>Course Name: "
                        . htmlspecialchars($book['CourseName'])
                        . "</p>";
                }
                // If has note, display it
                if ($book['Note']) {
                    echo "<p>Additonal note: "
                        . htmlspecialchars($book['Note'])
                        . "</p>";
                }
                // If has image, display it
                if ($book['Image']) {
                    echo "<img
                        src='data:image/jpeg;base64,".base64_encode($book['Image'])."'
                        class='img-thumbnail'
                    />";
                }
                // Display username and post time
                echo "<p class='mt-2'>Posted by "
                    . htmlspecialchars($book['Username'])
                    . " on "
                    // . htmlspecialchars($book['PostTime'])
                    // . substr($book['PostTime'], 0, 16) // don't display seconds
                    // class='post-local-time' is used by the JavaScript code to find the elements to convert
                    // data-utc-time is a custom attribute to store the UTC time
                    . "<span class='post-local-time' data-utc-time='" . htmlspecialchars($book['PostTime']) . "'>"
                    . htmlspecialchars($book['PostTime']) . " UTC</span>"
                    . "</p>";

                // Display comments
                echo "<h3 class='mt-5 mb-2'>Comments</h3>";
                // If there are no comments, display a message
                if (mysqli_num_rows($commentsResult) == 0) {
                    echo "<p>No comments yet.</p>";
                } else {
                    while ($comment = mysqli_fetch_assoc($commentsResult)) {
                        echo
                            "<div><strong>"
                            . htmlspecialchars($comment['Username'])
                            . ":</strong> "
                            . htmlspecialchars($comment['CommentText'])
                            // . htmlspecialchars($comment['CommentTime'])
                            // . substr($comment['CommentTime'], 0, 16) // don't display seconds
                            // class='comment-local-time' is used by the JavaScript code to find the elements to convert
                            // data-utc-time is a custom attribute to store the UTC time
                            . "<span style='color: gray' class='comment-local-time' data-utc-time=
                                '" . htmlspecialchars($comment['CommentTime']) . "'>"
                            . " (" . htmlspecialchars($comment['CommentTime']) . " UTC)</span>"
                            . "</div>";
                    }
                }

                // Add a comment form
                if (isset($_SESSION["UserID"])) {
                    echo
                        "<form action='' method='post'>
                            <div class='mt-3 mb-3'>
                                <textarea name='commentText' class='form-control' required></textarea>
                            </div>
                            <button type='submit' class='btn btn-primary'>Add a Comment</button>
                        </form>";
                } else {
                    echo
                        "<form action='' method='post'>
                            <div class='mt-3 mb-3'>
                                <textarea name='commentText' class='form-control' required></textarea>
                            </div>
                            <button type='submit' class='btn btn-primary' disabled>Add a Comment</button>
                            <p class='mt-2'>Please <a href='index.php'>login</a> to post a comment.</p>
                        </form>";
                }
            } else {
                echo "<p>Book not found.</p>";
            }

        ?>
    </div>

    <!-- The JavaScript code waits for the DOM to be fully loaded, then finds
    each element with the local-time class. It reads the UTC time from the
    data-utc-time attribute, converts it to a JavaScript Date object (which
    automatically converts it to the user's local time zone), formats it to
    a local string, and updates the content of the element. -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.post-local-time').forEach(function(el) {
                var utcTime = el.getAttribute('data-utc-time');
                // var localTime = new Date(utcTime + 'Z').toLocaleString();
                // el.textContent = localTime;
                // Don't display seconds
                var localTime = new Date(utcTime + 'Z');
                var options = { year: 'numeric', month: 'numeric', day: 'numeric', hour: '2-digit', minute: '2-digit' };
                // undefined is passed as the first argument to use the default locale
                el.textContent = localTime.toLocaleString(undefined, options);
            });

            document.querySelectorAll('.comment-local-time').forEach(function(el) {
                var utcTime = el.getAttribute('data-utc-time');
                // var localTime = new Date(utcTime + 'Z').toLocaleString();
                // el.textContent = ' (' + localTime + ')';
                // Don't display seconds
                var localTime = new Date(utcTime + 'Z');
                var options = { year: 'numeric', month: 'numeric', day: 'numeric', hour: '2-digit', minute: '2-digit' };
                // undefined is passed as the first argument to use the default locale
                el.textContent = ' (' + localTime.toLocaleString(undefined, options) + ')';
            });
        });
    </script>
    
</body>
</html>
