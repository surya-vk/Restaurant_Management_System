<?php
session_start(); // Start session at the top of the file

require_once '../config.php'; // Database connection

// Check if the user is logged in
$isCustomerLoggedIn = isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && isset($_SESSION["account_id"]);
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    echo '<div class="user-profile">';
    // Check if 'member_name' is set before displaying it
    if (isset($_SESSION["member_name"])) {
        
    } else {
        
    }
    
    echo '</div>';
}
?>
<!-- header.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Flavorscape</title>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .navbar-brand { font-family: 'Georgia', serif; font-size: 2rem; }
    .nav-link { font-size: 1.2rem; margin: 0 15px; }
    .hero { background-image: url('../image/pexels-karolina-grabowska-4199098.jpg'); background-size: cover; color: white; height: 100vh; }
    .hero h1 { font-size: 3.5rem; text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5); }
    .hero p { font-size: 1.2rem; text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.5); }
    .about, .menu, .contact { padding: 3rem 0; }
    .menu-item img { height: 200px; object-fit: cover; border-radius: 10px; }
    .footer { background: #222; color: #eee; padding: 2rem 0; }
    /* Style for tooltip icon */
.tooltip-icon {
    position: relative;
    cursor: pointer;
    color: #007bff;
    font-weight: bold;
    margin-left: 5px;
}

/* Hide the tooltip text by default */
.tooltip-icon .custom-tooltip {
    visibility: hidden;
    width: 140px;
    background-color: #333;
    color: #fff;
    text-align: center;
    border-radius: 5px;
    padding: 5px;
    position: absolute;
    z-index: 1;
    bottom: 125%; /* Position the tooltip above the icon */
    left: 50%;
    margin-left: -70px; /* Center the tooltip */
    opacity: 0;
    transition: opacity 0.3s;
    font-size: 0.85em;
}

/* Arrow below the tooltip box */
.tooltip-icon .custom-tooltip::after {
    content: "";
    position: absolute;
    top: 100%; /* Arrow points down */
    left: 50%;
    margin-left: -5px;
    border-width: 5px;
    border-style: solid;
    border-color: #333 transparent transparent transparent;
}

/* Show the tooltip text on hover */
.tooltip-icon:hover .custom-tooltip {
    visibility: visible;
    opacity: 1;
}

  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="#">
      <img src="../image/logo.png" alt="Flavorscape Logo" style="width: 50px; height: auto; margin-right: 10px;">
      Flavorscape
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="#about">ABOUT US</a></li>
        <li class="nav-item"><a class="nav-link" href="#projects">MENU</a></li>
        <li class="nav-item">
    <a class="nav-link <?php echo !isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true ? 'disabled' : ''; ?>" 
       href="<?php echo isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true ? '../CustomerReservation/reservePage.php' : '#'; ?>" 
       aria-disabled="<?php echo !isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true ? 'true' : 'false'; ?>">
       RESERVATION
    </a>
</li>
        <li class="nav-item">
          <a class="nav-link <?php echo $isCustomerLoggedIn ? 'disabled' : ''; ?>" href="../../adminSide/StaffLogin/login.php">STAFF LOGIN</a>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              ACCOUNT
            </a>
            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="accountDropdown">
              <?php
                // Get the account ID from the session
                $account_id = $_SESSION['account_id'] ?? null;

                // Check if user is logged in
                if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $account_id != null) {
                    $query = "SELECT member_name, points FROM memberships WHERE account_id = $account_id";
                    $result = mysqli_query($link, $query);

                    if ($result) {
                        $row = mysqli_fetch_assoc($result);
                        if ($row) {
    $member_name = htmlspecialchars($row['member_name']);
    $points = (int)$row['points'];
    $vip_status = ($points >= 5000) ? 'VIP' : 'Regular';
    $vip_tooltip = ($points < 5000) ? (5000 - $points) . ' points to VIP' : 'You are eligible for VIP';

    echo "<li class='dropdown-item'>$member_name</li>";
    echo "<li class='dropdown-item'>$points Points</li>";
    echo "<li class='dropdown-item'>$vip_status";
    
    // Add styled tooltip for Regular status
    if ($vip_status === 'Regular') {
        echo "<span class='tooltip-icon'>[?]
                <span class='custom-tooltip'>$vip_tooltip</span>
              </span>";
    }
    echo "</li>";
}
                    } else {
                        echo "<li class='dropdown-item'>Error: " . mysqli_error($link) . "</li>";
                    }
                    //echo '<li><a class="dropdown-item" href="../customerLogin/redeem.php">Redeem Points</a></li>';
                    // Show logout link
                    echo '<li><a class="dropdown-item" href="../customerLogin/logout.php">Logout</a></li>';
                } else {
                    // Show login and signup links if not logged in
                    echo '<li><a class="dropdown-item" href="../customerLogin/register.php">Sign Up</a></li>';
                    echo '<li><a class="dropdown-item" href="../customerLogin/login.php">Log In</a></li>';
                }

                // Close the database connection
               // mysqli_close($link);
              ?>
            </ul>
          </li>
        <li class="nav-item"><a class="nav-link" href="#contact">CONTACT</a></li>
      </ul>
    </div>
  </div>
</nav>
