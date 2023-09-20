<?php
session_start();
$error_message = $_SESSION['error_message'] ?? '';
unset($_SESSION['error_message']);
?>

<!DOCTYPE html>
<html>
<head>
  <title>ログイン</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 h-screen flex flex-col items-center pt-20">
  <div class="bg-white rounded-lg shadow-lg w-1/3 p-8">
    <h1 class="text-3xl mb-4 text-center">ログイン</h1>

    <?php if ($error_message): ?>
      <div class="bg-red-500 text-white p-3 rounded">
        <?php echo htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8'); ?>
      </div>
    <?php endif; ?>

    <form action="signin_complete.php" method="post" class="mb-4">
      <input type="email" name="email" placeholder="Email" class="px-4 py-2 border rounded mb-2 w-full">
      <input type="password" name="password" placeholder="Password" class="px-4 py-2 border rounded mb-2 w-full">
      <input type="submit" value="ログイン" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
    </form>

    <a href="signup.php" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
      アカウントを作る
    </a>
  </div>
</body>
</html>
