<?php
require_once './conn/conn.php';
session_start();

// Fetch all books from the database
// $query = "SELECT * FROM Books ORDER BY PostTime DESC";
// Fetch all books from the database along with the username of the user who posted the book
$query = "SELECT Books.*, Users.Username 
          FROM Books 
          JOIN Users ON Books.UserID = Users.UserID 
          ORDER BY PostTime DESC";
$result = mysqli_query($dbc, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookMCC - BMCC Book Exchange</title>
    <link rel="stylesheet" href="./assets/bootstrap-5.3.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/common.css">
    <script src="./assets/bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container">
        <?php
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='card mb-3'>";
                echo "<div class='card-body'>";
                echo "<h5 class='card-title'>" . htmlspecialchars($row['Title']) . "</h5>";
                echo "<h6 class='card-subtitle mb-2 text-muted'>Author: "
                    . htmlspecialchars($row['Author'])
                    . "</h6>";
                if ($row['Image']) {
                    echo "<img
                        src='data:image/jpeg;base64,".base64_encode($row['Image'])."'
                        class='img-thumbnail'
                    />";
                }
                echo "<p class='card-text mt-2'>Posted by "
                    . htmlspecialchars($row['Username'])
                    . " on "
                    // . htmlspecialchars($row['PostTime'])
                    // don't display seconds
                    . substr($row['PostTime'], 0, 16)
                    . "</p>";
                echo "<a href='book-detail.php?book_id=" . $row['BookID'] . "' class='btn btn-primary'>View Details</a>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p>No books found.</p>";
        }
        ?>
    </div>
    
  </body>
</body>
</html>
