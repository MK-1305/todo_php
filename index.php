<?php
require('db_connect.php');

$db = db_connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $todo = filter_input(INPUT_POST, 'todo', FILTER_SANITIZE_STRING);
    $stmt = $db->prepare('insert into todo (text) value(?)');
    if (!$stmt) {
        die($db->error);
    }

    $stmt->bind_param('s', $todo);
    $success = $stmt->execute();

    if (!$success) {
        die($db->error);
    }

    header('Location: index.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
    <title>TODO(PHP)</title>
</head>
<body>
    <header>
        <nav>
            <h2>TODO</h2>
        </nav>
    </header>
    <div class="text">
        <h3>今日は何する？</h3>
        <form action="" method="post">
            <textarea name="todo" cols="100" rows="1" 
            placeholder="メモを入力してください"></textarea><br>
            <input type="submit" value="追加する" class="button"/>
        </form>
        <?php
            $stmt = $db->prepare('select id text from todo order by id desc');

            if (!$stmt) {
                die($db->error);
            }
            $success = $stmt->execute();
            if (!$success) {
                die($db->error);
            }

            $stmt->bind_result($id, $todo);
            while ($stmt->fetch()):
        ?>
        <div class="post-area">
            <?php if ($todo): ?>
                <div class="task">タスク</div>
                <table>
                    <tr>
                        <td class="todo-text">
                            <?php echo h($todo); ?>
                        </td>
                        <td class="todo-complete">完了</td>
                        <td class="todo-update">
                            <a href="update.php?id=<?php echo $id; ?>"></a>編集
                        </td>
                        <td class="todo-delete"><a href="delete.php?id<?php echo $id; ?>"></a>削除</td>
                    </tr>
                </table>
            <?php endif; ?>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>