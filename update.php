<?php
require('db_connect.php');

$db = db_connect();

$stmt = $db->prepare('select * from todo where id=?');
if (!$stmt) {
    die($db->error);
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$stmt->bind_param('i', $id);
$stmt->execute();

$stmt->bind_result($id, $todo, $created, $update);
$result = $stmt->fetch();
if (!$result) {
    die('todoの指定が正しくありません');
}

var_dump($update);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
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
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <textarea name="todo" cols="100" rows="1" 
            placeholder="メモを入力してください"><?php echo h($todo); ?></textarea><br>
            <input type="submit" value="変更する" class="button"/>
        </form>
    </div>
</body>
</html>