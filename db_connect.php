<?php
// htmlspecialcharsを短くする
function h($value) {
    return htmlspecialchars($value, ENT_QUOTES);
}
// DBへの接続
function db_connect() {
    $db = new mysqli('localhost', 'root', 'root', 'todo_php');
    // もし上手く接続できなければ
	if (!$db) {
        // dieとexitは同じ機能だがexitは行頭にdieは~が失敗した時は処理終了という場合に使う
        die($db->error);
    }
    // 上手くいったら$dbを返す
    return $db;
}