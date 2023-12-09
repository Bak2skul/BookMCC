<?php
// Include the connection script
require_once 'conn.php';

// Check if the connection is successful
if ($dbc) {
    echo 'Database connection successful!';
} else {
    echo 'Database connection failed: ' . mysqli_connect_error();
    exit;
}

// Close the database connection
mysqli_close($dbc);
?>
