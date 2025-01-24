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
            <div class="newGal-forms">
                <form action="/createNewCourse" method="POST">

                    <label>Utwórz nowy kurs:</label>
                    <input type="text" name="courseName" placeholder="Nazwa" required>
                    
                    <button type="submit" class="set-button">Załóż</button>
                </form>
                <form action="/joinCourse" method="POST">

                    <label>Dołącz do kursu:</label>
                    <input type="text" name="code" placeholder="Kod" required>
                    
                    <button type="submit" class="set-button">Dołącz</button>
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