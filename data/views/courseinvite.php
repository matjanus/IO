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
                <form id="codeForm">
                    <label >Ile kodów wygenerować?</label><br>
                    <input type="number" id="numCodes" min="1" required>
                    <button type="button" class="set-button" onclick="generateCodes(<?php echo json_encode($id_course) ?>)">Generuj kody</button>
                    <button type="button" class="set-button" onclick="deleteCodes(<?php echo json_encode($id_course) ?>)">Usun wszystkie kody</button>
                
                    <textarea id="output" readonly></textarea>
                </form>
            </div>
        </main>
    </div>
    <?php if (!empty($message)): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
    <script src="/data/js/messDisappear.js"></script>
    <script src="/data/js/deleteCodes.js"></script>
    <script src="/data/js/generateCodes.js"></script>
</body>
</html>