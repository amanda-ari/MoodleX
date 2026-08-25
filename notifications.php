<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Notifications</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body { 
            font-family: Arial, sans-serif; 
            background-color: #f0f2f5; 
            margin: 0; padding: 0; 
        }
        header { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            padding: 15px 40px; 
            background-color: #1f2937; 
            color: white; 
        }
        .container { 
            max-width: 700px; 
            margin: 40px auto; 
            background: white; 
            padding: 25px; 
            border-radius: 12px; 
            box-shadow: 0 8px 20px rgba(0,0,0,0.1); 
            display: flex; 
            flex-direction: column; 
            align-items: center; 
        }
        .notification { 
            padding: 12px; 
            border-bottom: 1px solid #ddd; 
            width: 100%; 
            max-width: 600px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            flex-wrap: wrap; 
            margin-bottom: 10px; 
        }
        .timestamp { 
            font-size: 12px; 
            color: #666; 
            margin-top: 4px; }
        h2 { text-align: center; 
            margin-bottom: 20px; 
        }
    </style>
</head>
<body>

    <!-- Header -->
    <header>
        <div class="logo">moodleX</div>
        <nav class="nav-left">
        <a href="calendar.php">Calendar</a>
        <a href="notifications.php">Notifications</a>
        </nav>
        <div class="nav-right">
        <a href="profile-student.php" id="prf-std-btn" class="acc-btn">My Profile</a>
        <a href="logout.php" class="acc-btn">Logout</a>
        </div>
    </header>

    <div class="container">
        <h2>Notifications</h2>
        <?php
        $result = $conn->query("SELECT * FROM notifications ORDER BY created_at DESC");

        if ($result->num_rows > 0) {
            echo "<div style='display:flex; flex-direction:column; align-items:center; width:100%;'>";
            while($row = $result->fetch_assoc()) {
                echo "<div class='notification'>";
                echo "<span style='flex:1; text-align:left;'>" . nl2br(htmlspecialchars($row['message'])) . "</span>";
                if(isset($row['created_at'])) {
                    echo "<span class='timestamp'>" . htmlspecialchars($row['created_at']) . "</span>";
                }
                echo "</div>";
            }
            echo "</div>";
        } else {
            echo "<p style='text-align:center;'>No notifications yet.</p>";
        }
        ?>
    </div>
  <!-- Footer -->
  <footer>
    <p>© 2026 WebTech. All rights reserved.</p>
  </footer>
</body>
</html>
