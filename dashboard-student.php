<?php
session_start();

if (!isset($_SESSION['user']) || !isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}
if ($_SESSION['role'] === "staff") {
    header("Location: dashboard-staff.php");
    exit();
}
if ($_SESSION['role'] !== "student") {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="stylesheet" href="styles.css">
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

  <main>
    <section class="content">
      <h1>
        <?php
          echo "Welcome, " . htmlspecialchars(
              !empty($_SESSION['name']) ? $_SESSION['name'] : $_SESSION['user']
          );
        ?>
      </h1>
    </section>
  </main>

  <!-- Footer -->
  <footer>
    <p>© 2026 WebTech. All rights reserved.</p>
  </footer>
</body>
</html>
