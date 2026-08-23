<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
    <style>
      body{
    text-align: center;
    font-family: Arial, Helvetica, sans-serif;
}
table{
    margin: auto;
    width: 80%;
    border-collapse: collapse;
}
th,td{
    border: 2px solid black;
    text-align: center;
    width: 10%;
    font-size: 15px;
    font-weight: bold;
}
th{
    font-weight: bold;
    padding: 5px;

}
td{
    padding: 10px;
}
.break{
    padding: 5px;
    background-color:lightgoldenrodyellow;
}
.one{
    background-color:aqua;
}
.two{
    background-color: rgb(39, 173, 236);
}
.three{
    background-color:rgb(172, 7, 218);
}
.four{
    background-color: rgb(254, 56, 162);
}
.five{
    background-color: black;
    color: white;
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
    <h1>Time Table</h1>

    <table>
      <tr>
        <th>Time</th>
        <th>Monday</th>
        <th>Tuesday</th>
        <th>Wednesday</th>
        <th>Thursday</th>
        <th>Friday</th>
        <th>Saturday</th>
        <th>Sunday</th>
      </tr>
      <tr>
        <td>8.15 - 9.15</td>
        <td rowspan="2" id="mon1" class="one"> IN 1621 L</td>
        <td rowspan="2" id="tue1" class="two"> IN 1901</td>
        <td rowspan="2" id="wed1" class="three"> IN 1401</td>
        <td rowspan="2" id="thu1"></td>
        <td rowspan="2" id="fri1"></td>
        <td rowspan="2" id="sat1"></td>
        <td rowspan="2" id="sun1"></td>
      </tr>
      <tr>
        <td>9.15 - 10.15</td>
      </tr>
      <tr>
        <td>10.30 - 11.30</td>
        <td rowspan="2" class="four">CM 1131</td>
        <td rowspan="2" class="four"> IN 1501</td>
        <td rowspan="2" class="three">IS 1101</td>
        <td rowspan="2" class="five">Union Hour</td>
        <td rowspan="2" class="one">IN 1111 L / &nbsp;&nbsp;&nbsp; IN 1501 L</td>
        <td rowspan="2"></td>
        <td rowspan="2"></td>
      </tr>
      <tr>
        <td>11.30 - 12.30</td>
      </tr>
      <tr class="break">
        <td>12.30 - 13.15</td>
        <td colspan="7"></td>
      </tr>
      <tr>
        <td>13.15 - 14.15</td>
        <td class="four">CM 1131 T</td>
        <td rowspan="2" class="four">IN 1111</td>
        <td rowspan="2" class="four">IN 1621</td>
        <td rowspan="2"></td>
        <td rowspan="2"></td>
        <td rowspan="2"></td>
        <td rowspan="2"></td>
      </tr>
      <tr>
        <td>14.15 - 15.15</td>
      </tr>
      <tr>
        <td>15.30 - 16.30</td>
        <td class="four">IS 1101 T</td>
        <td rowspan="2"></td>
        <td class="one">IN 1401 L</td>
        <td rowspan="2"></td>
        <td rowspan="2"></td>
        <td rowspan="2"></td>
        <td rowspan="2"></td>
      </tr>
      <tr>
        <td>16.30 - 17.30</td>
        <td></td>
        <td></td>
      </tr>
      
      
    </table>

  <!-- Footer -->
  <footer>
    <p>© 2026 WebTech. All rights reserved.</p>
  </footer>    
   
</body>
</html>
