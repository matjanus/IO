<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/data/css/styles.css">
    <title><?= htmlspecialchars($exercise->getName()) ?></title>
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
                <h2><?= htmlspecialchars($exercise->getName()) ?></h2>
            </div>
            <hr>
            <div class="exercise-container">
                <div class="exercise-content">
                    <p><b>Instrukcja:<br></b> <?= nl2br(htmlspecialchars($exercise->getFields()['instruction'])) ?></p>
                </div>

                <?php if (!empty($exercise->getFields()['hint'])): ?>
                    <div>
                        <button class="set-button" onclick="toggleVisibility('hint')">Pokaż podpowiedź</button>
                    </div>
                    <div id="hint" class="exercise-content hidden">
                        <p><b>Podpowiedź:<br></b> <?= nl2br(htmlspecialchars($exercise->getFields()['hint'])) ?></p>
                    </div>
                <?php endif; ?>

                <div class="exercise-content">
                    <form action="/submitSolution" method="POST">
                        <input type="hidden" name="id_exercise" value="<?= $exercise->getId() ?>">
                        <input type="hidden" name="id_package" value="<?= $id_package ?>">
                        <label for="solution">Twoje rozwiązanie:</label><br>
                        <textarea name="solution" rows="4" cols="50" required></textarea><br>
                        <button class="set-button" type="submit">Prześlij</button>
                    </form>
                </div>
                <div>
                    <button class="set-button exercise-button" onclick="toggleVisibility('result')">Pokaż oczekiwany wynik</button>
                </div>
                <div id="result" class="exercise-content hidden">
                    <p><b>Oczekiwany wynik:<br></b> <?= nl2br(htmlspecialchars($exercise->getFields()['result'])) ?></p>
                </div>
                <div>
                    <button class="set-button" onclick="toggleVisibility('solution')">Pokaż rozwiązanie</button>
                </div>
                <div id="solution" class="exercise-content hidden">
                    <p><b>Rozwiązanie:<br></b> <?= nl2br(htmlspecialchars($exercise->getFields()['solution'])) ?></p>
                </div>
                <?php if ($role === 'owner' || $role === 'teacher'): ?>
                    <div class="exercise-content">
                        <h3>Przesłane odpowiedzi:</h3>
                        <?php if (!empty($submittedAnswers)): ?>
                            <b>Odpowiedzi:</b>
                                <?php foreach ($submittedAnswers as $answer): ?>
                                         <?= nl2br(htmlspecialchars($answer)) ?><br><br>
                                <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
<script>
    function toggleVisibility(id) {
        const element = document.getElementById(id);
        if (element.classList.contains('hidden')) {
            element.classList.remove('hidden');
        } else {
            element.classList.add('hidden');
        }
    }
</script>
</html>