<?php
session_start();

// Admin credentials
$admin_user = "admin";
$admin_pass = "admin123"; // Change this password for security

// Check login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['username'] == $admin_user && $_POST['password'] == $admin_pass) {
        $_SESSION['admin_logged_in'] = true;
    } else {
        echo "<p style='color: red;'>Invalid credentials!</p>";
    }
}

// Redirect if not logged in
if (!isset($_SESSION['admin_logged_in'])) {
?>
    <form method="POST">
        <label>Username:</label>
        <input type="text" name="username" required>
        <label>Password:</label>
        <input type="password" name="password" required>
        <input type="submit" value="Login">
    </form>
<?php
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Panel</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: left; }
        th { background: #2c3e50; color: white; }
    </style>
</head>
<body>

<h2>Contact Form Submissions</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Message</th>
        <th>Date</th>
    </tr>
    <?php
    // Database connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch messages
    $sql = "SELECT * FROM messages ORDER BY created_at DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['name']}</td>
                <td>{$row['email']}</td>
                <td>{$row['message']}</td>
                <td>{$row['created_at']}</td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No messages found</td></tr>";
    }

    $conn->close();
    ?>
</table>

<a href="logout.php">Logout</a>

</body>
</html>
