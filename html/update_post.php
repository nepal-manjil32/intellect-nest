<?php
// Get the posted JSON data
$postData = file_get_contents('php://input');

// Decode the JSON data
$data = json_decode($postData);

// Write the updated data back to post.json
file_put_contents('post.json', json_encode($data));

// Return a success message
echo json_encode(['message' => 'Post updated successfully']);
?>
