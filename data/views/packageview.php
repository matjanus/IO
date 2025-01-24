<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/data/css/styles.css">
    <script src="https://kit.fontawesome.com/8fd9367667.js" crossorigin="anonymous"></script>
    <title>Pakiet</title>
</head>
<body>
    <div class="container">
        <nav>
            <button type="button" class="logo-btn" onclick="location.href='/'">
                <img src="/img/logo.png">
            </button>
            <button class="nav_button" onclick="location.href='/'">Kursy</button>
            <button class="nav_button" onclick="location.href='/exercises'">Zadania</button>
            <button class="nav_button" onclick="location.href='/accountSettings'">Ustawienia konta</button>
            <button class="nav_button" onclick="location.href='/logOut'">Wyloguj</button>
        </nav>

        <main>
            <div class="top_bar">
                <button class="top-bar-button" onclick="location.href='/course/<?= htmlspecialchars($id_course) ?>/menage'">
                    Zarządzaj
                </button>
            </div>
            <hr>
            <?php if ($role === 'owner' || $role === 'teacher'): ?>
                <div class="set_form">
                    <form action="/addExerciseToPackage" method="POST">
                        <input type="hidden" name="id_package" value="<?= htmlspecialchars($id_package) ?>">
                        <label for="exercise">Wybierz zadanie:</label>
                        <select id="exercise" name="id_exercise">
                            <?php foreach ($userExercises as $exercise): ?>
                                <option value="<?= $exercise->getId() ?>">
                                    <?= htmlspecialchars($exercise->getName()) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="set-button">Dodaj</button>
                    </form>
                </div>
            <?php endif; ?>
            <div class="table-container">
                <table>
                    <?php foreach ($exercises as $exercise): ?>
                        <tr>
                            <td>
                                <a href="/package/<?= $id_package ?>/<?= $exercise->getId() ?>" class="title-link">
                                    <?= htmlspecialchars($exercise->getName()) ?>
                                </a>
                            </td>
                            <?php if ($role === 'owner' || $role === 'teacher'): ?>
                                <td class="td-button">
                                    <form action="/deleteExerciseFromPackage" method="POST" onsubmit="return confirm('Czy na pewno chcesz usunąć to zadanie?');">
                                        <input type="hidden" name="id_package" value="<?= htmlspecialchars($id_package) ?>">
                                        <input type="hidden" name="id_exercise" value="<?= htmlspecialchars($exercise->getId()) ?>">
                                        <button type="submit" class="button-in-td">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>

            
        </main>
    </div>

    <?php if (!empty($message)): ?>
        <div class="message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <script src="/data/js/messDisappear.js"></script>
    <script src="/data/js/packageActions.js"></script>
</body>
</html>