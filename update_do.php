<?php
require('db_connect.php');

$db = db_connect();

$stmt = $db->prepare('update todo set text=? where id=?');
if (!$stmt) {
    die($db->error);
}
$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
$todo = filter_input(INPUT_POST, 'todo', FILTER_SANITIZE_STRING);
$stmt->bind_param('si', $todo, $id);
$success = $stmt->execute();
if (!$success) {
    die($db->error);
}

header('Location: index.php');
?>