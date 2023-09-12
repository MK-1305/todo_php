<?php
require('db_connect.php');
$stmt = $db->prepare('select * from todo where id=?');
if (!$stmt) {
    die($db->error);
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$stmt->bind_param('i', $id);
$stmt->execute();

$stmt->bind_result($id, $todo);
$result = $stmt->fetch();
if (!$result) {
    die('todoの指定が正しくありません');
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>編集</title>
</head>
<body>
    <header>
        <nav>
            <h2>TODO</h2>
        </nav>
    </header>
    <div class="text">
        <h3>変えていいのかい？</h3>
        <form action="update_do.php" method="post">
            <textarea name="todo" cols="100" rows="1" 
            placeholder="メモを入力してください"><?php h($todo); ?></textarea><br>
            <input type="submit" value="追加する" class="button"/>
        </form>
    </div>
</body>
</html>