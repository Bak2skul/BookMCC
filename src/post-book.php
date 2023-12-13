<?php
session_start();

// Start output buffering
// to prevent sending HTTP headers before redirecting to login page (in 5 seconds)
ob_start();

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION["UserID"]) || empty($_SESSION["UserID"])) {
    echo "Please login first. Redirecting to login page in 5 seconds...";
    header("refresh:5;url=index.php");
    echo "<br><br><a href='index.php'>Click here to login</a>";
    exit;
}

// Include the database connection file
require_once 'conn/conn.php';

// Define variables and initialize with empty values
$title = $author = $isbn13 = $isbn10 = $courseName = $note = "";
$imageContent = null;

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($dbc, $_POST['title']);
    $author = mysqli_real_escape_string($dbc, $_POST['author']);
    $isbn13 = mysqli_real_escape_string($dbc, $_POST['isbn13']);
    $isbn10 = mysqli_real_escape_string($dbc, $_POST['isbn10']);
    $courseName = mysqli_real_escape_string($dbc, $_POST['courseName']);
    $note = mysqli_real_escape_string($dbc, $_POST['note']);
    $userID = $_SESSION['UserID']; // Get UserID from session

    if (!empty($_FILES["image"]["tmp_name"])) {
        // Check if the image is larger than 1000KB (1MB)
        if ($_FILES["image"]["size"] > 1000 * 1024) {
            echo "The image size should be less than 1MB.";
        } else {
            $image = $_FILES['image']['tmp_name'];
            $imageContent = addslashes(file_get_contents($image));

            // Prepare an insert statement
            $query = "INSERT INTO
                Books (UserID, Title, Author, ISBN_13, ISBN_10, CourseName, Note, Image)
                VALUES ('$userID', '$title', '$author', '$isbn13', '$isbn10', '$courseName', '$note', '$imageContent')";

            if (mysqli_query($dbc, $query)) {
                echo "<div class='alert alert-success' role='alert'>"
                    . "Book posted successfully."
                    . "<a href='home.php'>Go to home page</a>"
                    . "</div>";
            } else {
                echo "Error: " . mysqli_error($dbc);
            }
        }
    }

}

// End output buffering and flush output
ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post a Book | BookMCC</title>
    <link rel="stylesheet" href="./assets/bootstrap-5.3.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/common.css">
    <script src="./assets/bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <div class="container">
        <h2>Post a Book</h2>
        <form
            action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
            method="post"
            enctype="multipart/form-data"
        >
            <div class="mb-3">
            <div class="mb-3">
                <label>Title (name of the book) *</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Author *</label>
                <input type="text" name="author" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>ISBN13 (13 numbers, no dashes)</label>
                <input type="text" name="isbn13" class="form-control">
            </div>
            <div class="mb-3">
                <label>ISBN10</label>
                <input type="text" name="isbn10" class="form-control">
            </div>
            <div class="mb-3">
                <label>Course Name (the course that uses this book)</label>
                <input type="text" name="courseName" class="form-control">
            </div>
            <div class="mb-3">
                <label>Note</label>
                <textarea
                    name="note"
                    class="form-control"
                    placeholder="Any additional information about the book"
                ></textarea>
            </div>
            <div class="mb-3">
                <label>Book image (size < 1MB)</label>
                <input type="file" name="image" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Post</button>
        </form>
    </div>

</body>
</html>
