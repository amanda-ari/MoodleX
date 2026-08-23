<?php
session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['email']) || !isset($_SESSION['role']) || $_SESSION['role'] !== "staff") {
    header("Location: login.php");
    exit();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

include "db.php";
include "sendNotification.php";

$message = '';
$notificationMsg = '';

$staffEmail = $_SESSION['email'];
$staffName = "";
$nameStmt = $conn->prepare("SELECT name FROM staff WHERE email = ?");
$nameStmt->bind_param("s", $staffEmail);
$nameStmt->execute();
$nameResult = $nameStmt->get_result();
if ($nameResult->num_rows === 1) {
    $staffName = $nameResult->fetch_assoc()['name'];
} else {
    $staffName = $_SESSION['name'] ?? "";
}
$nameStmt->close();

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $module = $_POST['module'];
    $lecturer = $staffName;

    $date = $_POST['date'];
    $start = $_POST['startTime'];
    $end = $_POST['endTime'];
    $location = $_POST['location'];
    $desc = $_POST['description'];

    if ($end <= $start) {
        $message = "End time must be after start time!";
    } else {
        $stmt = $conn->prepare("INSERT INTO lectures (module, lecturer, date, start_time, end_time, location, description) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $module, $lecturer, $date, $start, $end, $location, $desc);

        if($stmt->execute()){
            $message = "Lecture added successfully!";
            ob_start();
            sendNotification($module, $lecturer, $date, date("l", strtotime($date)), $start, $end, $location, $desc);
            $notificationMsg = ob_get_clean();
        } else {
            $message = "Error adding lecture: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Lecture</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    main {
      overflow: visible;
      height: auto;
      min-height: 0;
      flex: none;
    }

    main h1 {
      text-align: center;
    }

    .toast {
      position: fixed;
      bottom: 30px;
      left: 50%;
      transform: translateX(-50%) translateY(20px);
      color: white;
      padding: 14px 28px;
      border-radius: 8px;
      font-size: 15px;
      font-weight: 600;
      box-shadow: 0 4px 12px rgba(0,0,0,0.2);
      opacity: 0;
      transition: opacity 0.4s ease, transform 0.4s ease;
      z-index: 9999;
      pointer-events: none;
      white-space: nowrap;
    }
    .toast.success { background: #2d3e40; }
    .toast.error   { background: #e53935; }
    .toast.show {
      opacity: 1;
      transform: translateX(-50%) translateY(0);
    }

    .form-wrapper {
      width: 100%;
      max-width: 600px;
      margin: 0 auto;
      display: flex;
      flex-direction: column;
    }

    input[readonly] {
      background-color: #f3f4f6 !important;
      color: #9ca3af !important;
      border-color: #d1d5db !important;
      cursor: not-allowed;
    }
  </style>
</head>
<body>

<!-- Header -->  
<header>
    <div class="logo">moodleX</div>
    <nav class="nav-left">
      <a href="addLecture.php" class="acc-btn">Add Lecture</a>
    </nav>
    <div class="nav-right">
      <a href="profile-staff.php" id="prf-staff-btn" class="acc-btn">My Profile</a>
      <a href="logout.php" class="acc-btn">Logout</a>
    </div>
  </header>

  <?php if (!empty($message)): ?>
    <div class="toast <?php echo strpos($message, 'successfully') !== false ? 'success' : 'error'; ?>" id="toast">
      <?php echo htmlspecialchars($message); ?>
    </div>
  <?php endif; ?>

  <main>
    <h1>Add New Lecture</h1>

    <div class="form-wrapper">
      <form method="POST" action="addLecture.php">

        <div class="input-group">
          <select id="module" name="module" required>
            <option value="" disabled selected hidden></option>
            <option value="CM1131">CM1131 - Elements of Probability and Statistics</option>
            <option value="IN1111">IN1111 - Data Structures and Algorithms I</option>
            <option value="IN1401">IN1401 - Fundamentals of Databases</option>
            <option value="IN1501">IN1501 - Data Communication</option>
            <option value="IN1621">IN1621 - Web Technologies</option>
            <option value="IS1101">IS1101 - Principles of Management</option>
          </select>
          <label for="module">Module</label>
        </div>

        <div class="input-group">
          <input type="text" id="lecturer" name="lecturer" placeholder=" "
            value="<?php echo htmlspecialchars($staffName); ?>" readonly>
          <label for="lecturer">Lecturer Name</label>
        </div>

        <div class="input-group">
          <input type="date" id="date" name="date" placeholder=" " required>
          <label for="date">Date</label>
        </div>

        <div class="input-group">
          <input type="time" id="startTime" name="startTime" placeholder=" " required>
          <label for="startTime">Start Time</label>
        </div>

        <div class="input-group">
          <input type="time" id="endTime" name="endTime" placeholder=" " required>
          <label for="endTime">End Time</label>
        </div>

        <div class="input-group">
          <input type="text" id="location" name="location" placeholder=" ">
          <label for="location">Location</label>
        </div>

        <div class="input-group">
          <input type="text" id="description" name="description" placeholder=" ">
          <label for="description">Description</label>
        </div>

        <button type="submit">Add Lecture</button>

      </form>

      <?php if (!empty($notificationMsg)): ?>
        <p style="color:#2d3e40; margin-top:20px; text-align:center;">
          <?php echo htmlspecialchars($notificationMsg); ?>
        </p>
      <?php endif; ?>

    </div>
  </main>

  <!-- Footer -->
  <footer>
    <p>© 2026 WebTech. All rights reserved.</p>
  </footer>  

  <script>
    const toast = document.getElementById('toast');
    if (toast) {
      setTimeout(() => toast.classList.add('show'), 100);
      setTimeout(() => toast.classList.remove('show'), 3200);
    }
  </script>


</body>
</html>
