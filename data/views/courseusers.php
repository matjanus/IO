<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/data/css/styles.css">
    <script src="https://kit.fontawesome.com/8fd9367667.js" crossorigin="anonymous"></script>
    <title>Uczestnicy Kursu</title>
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
                <div class="table-container">
                    <table>
                        <tbody>
                            <?php foreach ($participants as $participant): ?>
                                <?php if ($participant->getRole() !== 'owner'): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($participant->getUsername()) ?></td>
                                        <td class="td-button">
                                            <form action="/removeUserFromCourse" method="POST" onsubmit="return confirm('Czy na pewno chcesz usunąć tego użytkownika?');">
                                                <input type="hidden" name="id_course" value="<?= htmlspecialchars($id_course) ?>">
                                                <input type="hidden" name="id_user" value="<?= htmlspecialchars($participant->getId()) ?>">
                                                <button type="submit" class="button-in-td"><i class="fa-solid fa-trash"></i></button>
                                            </form>
                                        </td>
                                        <td class="td-button">
                                            <form action="/toggleUserRole" method="POST">
                                                <input type="hidden" name="id_course" value="<?= htmlspecialchars($id_course) ?>">
                                                <input type="hidden" name="id_user" value="<?= htmlspecialchars($participant->getId()) ?>">
                                                <button type="submit" class="button-in-td">
                                                    <?= $participant->getRole() === 'teacher' ? '<i class="fa-solid fa-arrow-down"></i>' : '<i class="fa-solid fa-arrow-up"></i>' ?>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
        <?php if (!empty($message)): ?>
            <div class="message"> <?= htmlspecialchars($message); ?> </div>
        <?php endif; ?>
        <script src="/data/js/messDisappear.js"></script>
    </body>
</html>
