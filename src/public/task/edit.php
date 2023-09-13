<?php
$pdo = new PDO('mysql:host=mysql; dbname=todo; charset=utf8', 'root', 'password');

$id = $_GET['id'] ?? null;

if ($id === null) {
    header('Location: /index.php?error=' . urlencode('IDが指定されていません'));
    exit;
}

// 既存のタスクデータを取得
$stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = :id");
$stmt->execute([':id' => $id]);
$task = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$task) {
    header('Location: /index.php?error=' . urlencode('指定されたタスクが存在しません'));
    exit;
}

$error = $_GET['error'] ?? '';
$errors = !empty($error) ? explode(',', $error) : [];
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>タスク編集</title>
</head>
<body>
    <h1>タスク編集</h1>
    <?php if (!empty($errors)): ?>
        <div class="error">
            <?php foreach ($errors as $err): ?>
                <div><?= htmlspecialchars(urldecode($err)) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <form action="update.php" method="post">
        <input type="hidden" name="id" value="<?= $task['id'] ?>">
        <label>
            カテゴリ:
            <select name="category_id">
                <?php
                $stmt = $pdo->query("SELECT * FROM categories");
                $categories = $stmt->fetchAll();
                foreach ($categories as $category):
                ?>
                <option value="<?= $category['id'] ?>" <?= ($task['category_id'] == $category['id'] ? 'selected' : '') ?>>
                    <?= htmlspecialchars($category['name']) ?>
                </option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>
            タスク名:
            <input type="text" name="contents" value="<?= $task['contents'] ?>">
        </label>
        <label>
            締切:
            <input type="date" name="deadline" value="<?= $task['deadline'] ?>">
        </label>
        <button type="submit">更新</button>
    </form>
    <a href="/index.php">戻る</a>
</body>
</html>
