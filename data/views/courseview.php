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
                <div>
                    <?php if ($role === 'owner'): ?>
                        <button class="top-bar-button" onclick="location.href='/course/<?= htmlspecialchars($id_course)?>/invite'">
                            Zaproszenia
                        </button>
                        <button class="top-bar-button" onclick="location.href='/course/<?= htmlspecialchars($id_course)?>/users'">
                            Członkowie
                        </button>
                    <?php endif; ?>
                </div>
                <?php if ($role === 'owner' || $role === 'teacher'): ?>
                    <form action="/addPackage" method="POST" class="top-bar-new-package-form">
                        <input type="hidden" name="id_course" value="<?= htmlspecialchars($id_course) ?>">
                        <input type="text" name="package_name" placeholder="Nazwa nowego pakietu" required>
                        <button type="submit" class="set-button">Dodaj pakiet</button>
                    </form>
                <?php endif; ?>
            </div>
            <hr>
            <div class="table-container">
            <table>
                <tbody>
                    <?php foreach ($packages as $index => $package): ?>
                        <tr>
                            <td>
                                <a class="title-link" href="/package/<?= htmlspecialchars($package->getId()) ?>">
                                    <?= htmlspecialchars($package->getName()) ?>
                                </a>
                            </td>
                            <?php if ($role === 'owner' || $role === 'teacher'): ?>
                                <td class="td-button">
                                    <form action="/deletePackage" method="POST" onsubmit="return confirm('Czy na pewno chcesz usunąć ten pakiet?');">
                                        <input type="hidden" name="id_package" value="<?= htmlspecialchars($package->getId()) ?>">
                                        <input type="hidden" name="id_course" value="<?= htmlspecialchars($id_course) ?>">
                                        <button type="submit" class="button-in-td">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                                <td class="td-button">
                                    <form action="/toggleVisibility" method="POST">
                                        <input type="hidden" name="id_package" value="<?= htmlspecialchars($package->getId()) ?>">
                                        <input type="hidden" name="id_course" value="<?= htmlspecialchars($id_course) ?>">
                                        <button type="submit" class="button-in-td"><?= $package->getIsHidden() ? '<i class="fa-solid fa-eye-slash"></i>' : '<i class="fa-solid fa-eye"></i>' ?></button>
                                    </form>
                                </td>
                                <td class="td-button">
                                    <form action="/movePackage" method="POST">
                                        <input type="hidden" name="id_package" value="<?= htmlspecialchars($package->getId()) ?>">
                                        <input type="hidden" name="id_course" value="<?= htmlspecialchars($id_course) ?>">
                                        <input type="hidden" name="direction" value="up">
                                        <button type="submit" class="button-in-td" <?= $index === 0 ? 'disabled' : '' ?>><i class="fa-solid fa-arrow-up"></i></button>
                                    </form>
                                </td>
                                <td class="td-button">
                                    <form action="/movePackage" method="POST">
                                        <input type="hidden" name="id_package" value="<?= htmlspecialchars($package->getId()) ?>">
                                        <input type="hidden" name="id_course" value="<?= htmlspecialchars($id_course) ?>">
                                        <input type="hidden" name="direction" value="down">
                                        <button type="submit" class="button-in-td" <?= $index === count($packages) - 1 ? 'disabled' : '' ?>><i class="fa-solid fa-arrow-down"></i></button>
                                    </form>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            <table>
            </div>
        </main>
    </div>
    <?php if (!empty($message)): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
    <script src="data/js/messDisappear.js"></script>
</body>
</html>