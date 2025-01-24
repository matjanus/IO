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
            <button class="nav_button" onclick="location.href='/'">
                Kursy
            </button>
            <button class="nav_button" onclick="location.href='/exercises'">
                Zadania
            </button>
            <button class="nav_button" onclick="location.href='/accountSettings'">
                Ustawienia konta
            </button>
            <button class="nav_button" onclick="location.href='/logOut'">
                Wyloguj
            </button>
        </nav>
        <main>
            <div class="top_bar">

            </div>
            <hr>
            <div class="set_form">
                <form action="/changePassword" method="POST">

                    <label>Stare hasło:</label>
                    <input type="password" name="oldPassword" placeholder="Stare hasło" required>

                    <label>Nowe hasło:</label>
                    <input type="password" name="newPassword" placeholder="Nowe hasło" required>

                    <label>Powtórz hasło:</label>
                    <input type="password" name="repeatedPassword" placeholder="Powtórz hasło" required>
                    
                    <button type="submit" class="set-button">Potwierdź</button>
                </form>
            </div>
        </main>
    </div>
    <?php if (!empty($message)): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
    <script src="/data/js/messDisappear.js"></script>
</body>
</html>