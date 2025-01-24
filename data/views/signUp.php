<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/data/css/styles.css">
    <script src="https://kit.fontawesome.com/8fd9367667.js" crossorigin="anonymous"></script>
    <title>SignUp</title>
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
                 <?php if (!empty($message)): ?>
                    <p class="mess"><?php echo htmlspecialchars($message); ?></p>
                <?php endif; ?>
                <form action="/register" method="POST">
                    <label>Email: 
                    </label>
                    <input type="text" name="email" placeholder="Email" required>

                    <label>Login:
                    </label>
                    <input type="text" name="username" placeholder="Login" required>

                    <label>Hasło:</label>
                    <input type="password" name="password" placeholder="Hasło" required>

                    <label>Powtórz Hasło:</label>
                    <input type="password" name="repeatedPassword" placeholder="Powtórz hasło" required>
                    
                    <button type="submit" class="form_button">Zarejestruj</button>
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