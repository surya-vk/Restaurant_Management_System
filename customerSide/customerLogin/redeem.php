<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once('../components/header.php');
require_once '../config.php'; // Your DB connection file

// This section handles the AJAX POST request for redeeming points
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $memberId = $_SESSION['member_id']; // Get member ID from session
    $data = json_decode(file_get_contents('php://input'), true); // Get JSON input
    $pointsToDeduct = $data['points']; // Get points from the request

    // Fetch current points
    $stmt = $conn->prepare("SELECT points FROM Memberships WHERE member_id = ?");
    $stmt->bind_param("i", $memberId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row && $row['points'] >= $pointsToDeduct) {
        // Deduct points
        $newPoints = $row['points'] - $pointsToDeduct;
        $updateStmt = $conn->prepare("UPDATE Memberships SET points = ? WHERE member_id = ?");
        $updateStmt->bind_param("ii", $newPoints, $memberId);
        if ($updateStmt->execute()) {
            echo json_encode(['success' => true, 'newPoints' => $newPoints]);
        } else {
            error_log("Update Points Error: " . $updateStmt->error);
            echo json_encode(['success' => false, 'message' => 'Failed to redeem points, please try again later.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Not enough points']);
    }
    exit; // Exit after handling the AJAX request
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redeem Rewards - Flavorscape</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .card {
            margin: 20px;
        }
        .offer-title {
            font-weight: bold;
        }
        .points-required {
            color: #28a745; /* Green color for points */
        }
    </style>
</head>
<body>

<div class="container">
    <h1 class="my-4">Redeem Rewards</h1>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="offer-title">Extra Mango Lassi</h5>
                    <p class="points-required">Cost: 100 Points</p>
                    <button class="btn btn-primary" onclick="redeemOffer(100)">Redeem Offer</button>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="offer-title">10% Discount!</h5>
                    <p class="points-required">Cost: 200 Points</p>
                    <button class="btn btn-primary" onclick="redeemOffer(200)">Redeem Offer</button>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="offer-title">Free Dessert</h5>
                    <p class="points-required">Cost: 150 Points</p>
                    <button class="btn btn-primary" onclick="redeemOffer(150)">Redeem Offer</button>
                </div>
            </div>
        </div>
    </div>
</div>
    
<script>
let memberPoints = <?php echo json_encode($_SESSION['points']); ?>;

function redeemOffer(cost) {
    if (memberPoints < cost) {
        alert("Not enough points to redeem this offer.");
        return;
    }

    fetch('redeem.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ points: cost })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            memberPoints = data.newPoints; // Update local points count
            alert("Offer redeemed! New points balance: " + memberPoints);
            // Optionally, update the displayed points somewhere on the page
        } else {
            alert(data.message); // Show error message
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
</script>

</body>
</html>
