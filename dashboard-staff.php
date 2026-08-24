<?php
session_start();
include "db.php";

if (!isset($_SESSION['user']) || !isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}
if (!isset($_SESSION['role']) || $_SESSION['role'] !== "staff") {
    header("Location: dashboard-student.php");
    exit();
}

$staffName = "";
$stmt = $conn->prepare("SELECT name FROM staff WHERE email = ?");
$stmt->bind_param("s", $_SESSION['email']);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 1) {
    $staffName = $result->fetch_assoc()['name'];
} else {
    $staffName = $_SESSION['name'] ?? $_SESSION['user'];
}
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dashboard</title>
  <link rel="stylesheet" href="styles.css" />
</head>
<body>

  <!-- Header --> 
  <header>
    <div class="logo">moodleX</div>
    <a href="addLecture.php" class="acc-btn">Add Lecture</a>
    <div class="nav-right">
      <a href="profile-staff.php" id="prf-staff-btn" class="acc-btn">My Profile</a>
      <a href="logout.php" class="acc-btn">Logout</a>
    </div>
  </header>

  <main>
    <h1>Staff Dashboard</h1>
    <p>Welcome,  <?php echo htmlspecialchars($staffName); ?>!</p>
  </main>

  <!-- Footer -->
  <footer>
    <p>© 2026 WebTech. All rights reserved.</p>
  </footer>
</body>
</html>
