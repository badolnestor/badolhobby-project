<?php
include '../PHP/dbconnect.php';

$dbConnect = new DBConnect();
$id = $_GET['id'];

try {
    // Delete the user from the database
    $stmt = $dbConnect->conn->prepare("DELETE FROM crud WHERE id=:id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    header("Location: ../PHP/user.php"); // Redirect to user list
    exit();
} catch (PDOException $e) {
    echo "Error deleting record: " . $e->getMessage();
}
?>