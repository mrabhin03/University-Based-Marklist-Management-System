<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?=base_url('assets/css/Login.css')."?t=".time()?>">
</head>
<body>
  <div class="login-container">
    <h2>Login</h2>
    <?php if (!empty($error)): ?>
        <p style="color:red;"><?= $error ?></p>
    <?php endif; ?>
    <form method="post">
      <input type="text" placeholder="Username" name='Username' required>
      <input type="password" placeholder="Password" name='Password' required>
      <button type="submit">Login</button>
    </form>
  </div>
</body>
</html>
