<?php

// This file has been deprecated, because this project does not
// use the front-end and back-end separation development approach

require_once '../conn/conn.php';

// SQL query to fetch books from the database
$query = "SELECT * FROM Books";
$result = mysqli_query($dbc, $query);

// Create an array to hold the books
$books = array();

// Loop through the result and add the books to the books array
while ($row = mysqli_fetch_assoc($result)) {
    $books[] = array(
        'book_id' => $row['BookID'],
        'user_id' => $row['UserID'],
        'title' => $row['Title'],
        'author' => $row['Author'],
        'isbn-13' => $row['ISBN_13'],
        'isbn-10' => $row['ISBN_10'],
        // 'image' => $row['Image'],
        'image' => "MySQL MEDIUMBLOB type, cannot be converted to JSON",
        'course_name' => $row['CourseName'],
        'note' => $row['Note'],
        'post_time' => $row['PostTime'],
    );
}

// Return the books as JSON
header('Content-Type: application/json');
echo json_encode($books);
?>
