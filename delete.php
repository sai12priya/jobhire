<?php
require 'database.php';

// Check if the form is submitted and if it's a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Check if the simulated HTTP method is 'delete'
    if ($_POST['_method'] === 'delete') {
        // Retrieve the listing_id and user_id from the POST data
        $listing_id = isset($_POST['listing_id']) ? $_POST['listing_id'] : '';
        $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';

        // Prepare and execute the SQL query to delete the listing
        $sql = 'DELETE FROM listings WHERE listing_id = :listing_id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['listing_id' => $listing_id]);

        // Redirect back to the listings page after deletion
        header('Location: listings.php?u_id=' . $user_id);
        exit;
    }
}
