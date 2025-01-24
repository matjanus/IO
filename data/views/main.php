<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/data/css/styles.css">
    <script src="https://kit.fontawesome.com/8fd9367667.js" crossorigin="anonymous"></script>
    <title>Main</title>
</head>
<body>
    <div class="container">
        <nav>
            <button type="button" class="logo-btn" onclick="location.href='/'">
                <img src="/img/logo.png" >
            </button>
            
        </nav>
        <main>
            <div class="sec_form">
                <form action="/login" method="POST">
                    <label>Login:</label>
                    <input type="text" name="username" placeholder="Login" required>
                    <label>Hasło:</label>
                    <input type="password" name="password" placeholder="Hasło" required>
                    <button type="submit" class="form_button">Zaloguj</button>
                    <button type="button" class="form_button" onclick="location.href='/signUp'">Zarejestruj</button>
                </form>
            </div>
        </main>
    </div>
    <?php if (!empty($message)): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
    <script src="data/js/messDisappear.js"></script>
</body>
</html>