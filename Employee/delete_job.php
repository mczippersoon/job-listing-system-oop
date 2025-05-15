<?php
include_once '../Database/Dbconnection.php';
$conn = (new Dbconnection())->getConnection();

$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM jobs WHERE id = ?");
$stmt->execute([$id]);

header('Location: jobs.php');
