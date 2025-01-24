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
            <div class="newExe-forms">
                <form action="/makeNewExercise" method="POST">

                    <label for="name">Nazwa zadania:</label>
                    <input type="text" id="name" name="name" required>

                    <label for="instruction">Instrukcja:</label>
                    <textarea id="instruction" name="instruction" rows="8" required></textarea>

                    <label for="hint">Podpowiedź:</label>
                    <textarea id="hint" name="hint" rows="2"></textarea>

                    <label for="result">Oczekiwany wynik:</label>
                    <textarea id="result" name="result" rows="2"></textarea>

                    <label for="solution">Rozwiązanie:</label>
                    <textarea id="solution" name="solution" rows="8"></textarea>

                    <button type="submit" class="set-button">Dodaj zadanie</button>
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