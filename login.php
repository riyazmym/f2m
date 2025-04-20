<?php
// Include the database connection file
include('db.php');

// Get POST data
$data = json_decode(file_get_contents("php://input"));

$username_or_email = $data->username_or_email;
$password = $data->password;

// Query to find the user by username or email
$sql = "SELECT * FROM users WHERE username = '$username_or_email' OR email = '$username_or_email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    
    // Verify the password
    if (password_verify($password, $user['password'])) {
        // Login successful
        echo json_encode(['message' => 'Login successful', 'user' => $user]);
    } else {
        // Invalid password
        echo json_encode(['error' => 'Invalid password']);
    }
} else {
    // User not found
    echo json_encode(['error' => 'User not found']);
}

// Close the database connection
$conn->close();
?>
