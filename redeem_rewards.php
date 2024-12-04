<?php
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = intval($_POST['user_id']);
    $reward_name = $_POST['reward_name'];
    $points_used = intval($_POST['points_used']);

    $stmt = $conn->prepare("INSERT INTO rewards_redeemed (user_id, reward_name, points_used) VALUES (?, ?, ?)");
    $stmt->bind_param("isi", $user_id, $reward_name, $points_used);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>
