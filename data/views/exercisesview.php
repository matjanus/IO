<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/data/css/styles.css">
    <script src="https://kit.fontawesome.com/8fd9367667.js" crossorigin="anonymous"></script>
    <title>Document</title>
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
                <button class="top-bar-button" onclick="location.href='/newExercise'">
                    Nowe
                </button>
            </div>
            <hr>
            <div class="table-container">
                <table>
                    <tbody>
                        <?php if (!empty($exercises)): ?>
                            <?php foreach ($exercises as $exercise): ?>
                                <tr>
                                    <td>
                                        <a class="exercise-title">
                                            <?= htmlspecialchars($exercise->getName()) ?>
                                        </a>
                                    </td>
                                    <td  class="td-button">
                                        <form action="/deleteExercise" method="POST" onsubmit="return confirm('Czy na pewno chcesz usunąć to zadanie?');">
                                            <input type="hidden" name="id" value="<?= htmlspecialchars($exercise->getId()) ?>">
                                            <button class="button-in-td" type="submit">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                        
                                    </td>
                                    <td  class="td-button">
                                        <button class="button-in-td" type="submit" onclick="location.href='/editExercise?id_exercise=<?= htmlspecialchars($exercise->getId()) ?>'">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    <?php if (!empty($message)): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
    <script src="/data/js/messDisappear.js"></script>
    <script src="https://kit.fontawesome.com/c3529cc8c8.js" crossorigin="anonymous"></script>
</body>
</html>