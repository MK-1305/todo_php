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
            <!-- requiredは空白の時の簡易アラートになる -->
            <textarea required name="todo" cols="100" rows="1" 
            placeholder="メモを入力してください"></textarea><br>
            <input type="submit" value="追加する" class="button"/>
        </form>
        <?php
            // 更新が新しい順に並べる（古いのは下に）
            $stmt = $db->prepare('select id, text from todo order by updated_at desc');

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
                        <td class="todo-complete">
                            <!-- 完了を押したら良くやった的なのをJSで書きたい -->
                            <a href="">完了</a>
                        </td>
                        <td class="todo-update">
                            <a href="update.php?id=<?php echo $id; ?>">編集</a>
                        </td>
                        <td class="todo-delete">                            
                            <!-- JSでアラートウィンドウを呼び出したい -->
                            <a id="delete" href="delete.php?id=<?php echo $id; ?>">削除</a>
                            <script>
                                const delete_alert = document.querySelector('#delete');
                                delete_alert.addEventListener('click', () => {
                                    if(window.confirm('本当にいいのかい？')){
                                        return true;
                                    }else {
                                        return false;
                                    }
                                });
                            </script>
                        </td>
                    </tr>
                </table>
            <?php endif; ?>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>