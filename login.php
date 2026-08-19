<?php
session_start();
include "db.php";

$error = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

  $email    = $_POST['username'];
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT * FROM students WHERE email=?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if($result->num_rows == 1){
    $row = $result->fetch_assoc();

    if(password_verify($password, $row['password'])){
      $_SESSION['user']   = $row['username'];
      $_SESSION['name']   = $row['name'];
      $_SESSION['email']  = $row['email'];
      $_SESSION['degree'] = $row['degree'];
      $_SESSION['index']  = $row['student_index'];
      $_SESSION['role']   = "student";
      header("Location: dashboard-student.php");
      exit();
    } else {
      $error = "Wrong password!";
    }

  } else {
    $stmt->close();

    $stmt = $conn->prepare("SELECT * FROM staff WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows == 1){
      $row = $result->fetch_assoc();

      if(password_verify($password, $row['password'])){
        $_SESSION['user']  = $row['email'];
        $_SESSION['name']  = $row['name'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['role']  = "staff";
        header("Location: dashboard-staff.php");
        exit();
      } else {
        $error = "Wrong password!";
      }

    } else {
      $error = "User not found!";
    }

    $stmt->close();
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    .toast {
      position: fixed;
      bottom: 30px;
      left: 50%;
      transform: translateX(-50%) translateY(20px);
      background: #e53935;
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
    .toast.show {
      opacity: 1;
      transform: translateX(-50%) translateY(0);
    }
  </style>
</head>
<body>

  <!-- Header -->
  <header>
    <div class="logo">moodleX</div>
    <div class="nav-right">
      <a href="login.php" class="acc-btn">Login</a>
      <a href="register-student.php" class="acc-btn">Register</a>
    </div>
  </header>

  <?php if(!empty($error)): ?>
    <div class="toast" id="toast">
      <?php echo htmlspecialchars($error); ?>
    </div>
  <?php endif; ?>

  <main class="login-container">
    <form action="login.php" method="POST" class="login_form" novalidate>
      <h1 class="login_title">Welcome Back!</h1><br>

      <div class="login_inputs">
        <div class="input-group">
          <input type="text" id="username" name="username" required class="login_input" placeholder=" " />
          <label for="username">University Email</label>
        </div>

        <div class="input-group">
          <input type="password" id="password" name="password" required class="login_input" placeholder=" " />
          <label for="password">Password</label>
        </div>
      </div>
      <br />

      <button type="submit" class="login_button">Log In</button>

      <p class="register-text">
        Don't have an account? <a href="register-student.php">Register</a>
      </p>
    </form>
  </main>

  <!-- Footer -->
  <footer>
    <p>© 2026 WebTech. All rights reserved.</p>
  </footer>

  <script>
    const toast = document.getElementById('toast');
    if (toast) {
      setTimeout(() => toast.classList.add('show'), 100);
      setTimeout(() => toast.classList.remove('show'), 3500);
    }
  </script>

</body>
</html>
