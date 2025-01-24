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
            </div>
            <hr>
            <div class="table-container">
                <table>
                    <tbody>
                        <?php if (!empty($users)): ?>
                            <?php foreach ($users as $user): ?>
                                <?php if ($course->getAccess() === "student"): ?>
                                    <tr>
                                        <td>
                                            <a href="/course/<?= htmlspecialchars($course->getId()) ?>" class="course-title">
                                                <?= htmlspecialchars($course->getName()) ?>
                                            </a>
                                        </td>
                                        <td class="td-button">
                                            <form action="/leaveCourse" method="POST" onsubmit="return confirm('Czy na pewno chcesz opuścić kurs?');">
                                                <input type="hidden" name="id_course" value="<?= htmlspecialchars($course->getId()) ?>">
                                                <button type="submit" class="button-in-td">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endif; ?>
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
    <!-- <script src="/data/js/printGalleries.js"></script> -->
    <!-- <script src="/data/js/hideUnwanted.js"></script> -->
    <script src="/data/js/messDisappear.js"></script>
    <script src="https://kit.fontawesome.com/c3529cc8c8.js" crossorigin="anonymous"></script>
</body>
</html>