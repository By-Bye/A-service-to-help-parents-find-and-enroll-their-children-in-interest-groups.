<?php
$db = mysqli_connect('MySQL-8.0', 'root', '', 'mybase');

if (!$db) {
    die("Ошибка подключения к базе данных: " . mysqli_connect_error());
}

// Получаем ID кружка из URL параметра
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $club_id = $_GET['id'];

    // Запрос для получения информации о конкретном кружке
    $query = "SELECT * FROM clubs WHERE id = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "i", $club_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $club = mysqli_fetch_assoc($result);
        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="shortcut icon" href="img/LeavesPlay 1.svg" type="image/x-icon">
            <link rel="stylesheet" href="css/1.css">
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
                  rel="stylesheet">
            <title><?php echo htmlspecialchars($club['title']); ?> - KidsConnect</title>
        </head>

        <body>
        <header>
            <div class="header">
                <div class="header-content">
                    <img class="levitate" src="img/LeavesPlay 1 (2).svg" alt="">
                    <p class="KidsConnect">KidsConnect</p>
                </div>
            </div>
        </header>

        <main>
            <div class="main">

                <div class="back-maps">
                    <button class="back" onclick="window.history.back()">
                        <img src="img/Frame 462.svg" alt="">
                        <p>Назад</p>
                    </button>

                    <button id="openYandexMapButton" class="maps">
                        <p>На карты</p>
                        <img src="img/locationpointer_83774 1.svg" alt="">
                    </button>
                </div>

                <div class="name">
                    <p class="name-text"><?php echo htmlspecialchars($club['title']); ?>
                        <?php if (!empty($club['location'])): ?>
                            (в <?php echo htmlspecialchars($club['location']); ?>)
                        <?php endif; ?>
                    </p>
                </div>

                <div class="q">
                    <div class="qq">
                        <img src="<?php echo htmlspecialchars($club['image_path']); ?>" alt="<?php echo htmlspecialchars($club['title']); ?>">
                    </div>
                    <div class="qqq">
                        <div class="qqw">
                            <span class="qww">Набор открыт</span>
                            <span class="www">
                                <?php if ($club['is_free']): ?>
                                    Бесплатно
                                <?php elseif ($club['price'] === 'Первое бесплатно'): ?>
                                    Первое бесплатно
                                <?php else: ?>
                                    <?php echo htmlspecialchars($club['price']); ?>
                                <?php endif; ?>
                            </span>
                        </div>
                        <ul class="wwe">
                            <div class="wwe-img">
                                <img src="img/Frame 397.svg" alt="">
                                <li><?php echo htmlspecialchars($club['age_range']); ?></li>
                            </div>
                            <div class="wwe-img">
                                <img src="img/ui_affiliate_web_network_icon_233687 1.svg" alt="">
                                <li><?php echo htmlspecialchars($club['address']); ?></li>
                            </div>
                            <div class="wwe-img">
                                <img src="img/locationpointer_83774 1.svg" alt="">
                                <li><?php echo htmlspecialchars($club['venue']); ?></li>
                            </div>
                        </ul>
                        <div class="wee">
                            <button>Записаться</button>
                        </div>
                    </div>
                </div>

                <div class="q">
                    <div class="qqq-q">
                        <p class="grup">ГРУППЫ</p>
                        <p class="etap">Этап начальной подготовки</p>
                        <ul class="wwe">
                            <div class="wwe-img">
                                <img src="img/Frame 473.svg" alt="">
                                <li>Петрова Елена Александровна</li>
                            </div>
                            <div class="wwe-img">
                                <img src="img/Frame 474.svg" alt="">
                                <li>15 из 20</li>
                            </div>
                            <div class="wwe-img">
                                <img src="img/Frame 475.svg" alt="">
                                <li>12 месяцев</li>
                            </div>
                        </ul>
                    </div>
                </div>

                <div class="q">
                    <div class="schedule">
                        <p class="grup">РАСПИСАНИЕ ЗАНЯТИЙ</p>
                        <ul class="wwe">
                            <div class="wwe-img">
                                <img src="img/clock_time_icon_142903 1.svg" alt="">
                                <li class="day"><?php echo htmlspecialchars($club['schedule_days']); ?></li>
                            </div>
                            <div class="wwe-taim">
                                <img src="img/clock_time_icon_142903 1.svg" alt="">
                                <li class="day"><?php echo htmlspecialchars($club['schedule_days']); ?></li>
                                <?php
                                $schedule_times = explode("\n", $club['schedule_times']);
                                foreach ($schedule_times as $time):
                                    $time = trim($time);
                                    if (!empty($time)):
                                        ?>
                                        <div class="taim">
                                            <p><?php echo htmlspecialchars($time); ?></p>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </ul>
                    </div>
                </div>

                <div class="q">
                    <div class="qqq-q">
                        <p class="grup">ОПИСАНИЕ</p>
                        <p class="etap"><?php echo htmlspecialchars($club['description']); ?></p>
                    </div>
                </div>

                <div class="q-q">
                    <div class="qqq-qq">
                        <div class="content-container">
                            <div class="toggle-header">
                                <span class="header-text">СОДЕРЖАНИЕ ПРОГРАММЫ</span>
                                <img src="/img/Frame 462 (1).svg" alt="Стрелка" class="arrow">
                            </div>
                            <div class="dropdown-content">
                                <div class="level" data-level="base">
                                    <div class="level-header">
                                        <span class="level-title">Базовый уровень</span>
                                        <img src="/img/Frame 462 (1).svg" alt="Стрелка" class="level-arrow">
                                    </div>
                                    <div class="level-details">
                                        <p>Базовый уровень сложности первый-второй год обучения, 252 часа.</p>
                                        <p>
                                            <li>Обязательные предметы области (количество часов - 15);</li>
                                        </p>
                                        <p>
                                            <li>Вариативные предметные области (количество часов - 10);</li>
                                        </p>
                                        <p>
                                            <li>Теория (количество часов - 5);</li>
                                        </p>
                                        <p>
                                            <li>Практика (количество часов - 216);</li>
                                        </p>
                                        <p>
                                            <li>Самостоятельная работа (количество часов - 2);</li>
                                        </p>
                                        <p>
                                            <li>Аттестация (количество часов - 4).</li>
                                        </p>
                                        <p>Базовый уровень сложности третий-четвертый год обучения, 416 часов.</p>
                                        <p>Обязательные предметы области (количество часов - 25);</p>
                                        <p>
                                            <li>Вариативные предметные области (количество часов - 15);</li>
                                        </p>
                                        <p>
                                            <li>Теория (количество часов - 7);</li>
                                        </p>
                                        <p>
                                            <li>Практика (количество часов - 361);</li>
                                        </p>
                                        <p>
                                            <li>Самостоятельная работа (количество часов - 4);</li>
                                        </p>
                                        <p>
                                            <li>Аттестация (количество часов - 4).</li>
                                        </p>
                                        <p>Базовый уровень сложности пятый-шестой год обучения, 420 часов.</p>
                                        <p>
                                            <li>Обязательные предметы области (количество часов - 27);</li>
                                        </p>
                                        <p>
                                            <li>Вариативные предметные области (количество часов - 15);</li>
                                        </p>
                                        <p>
                                            <li>Теория (количество часов - 8);</li>
                                        </p>
                                        <p>
                                            <li>Практика (количество часов - 360);</li>
                                        </p>
                                        <p>
                                            <li>Самостоятельная работа (количество часов - 6);
                                        </p>
                                        <p>
                                            <li>Аттестация (количество часов - 4).
                                        </p>
                                    </div>
                                </div>
                                <div class="level" data-level="advanced">
                                    <div class="level-header">
                                        <span class="level-title">Углубленный уровень</span>
                                        <img src="/img/Frame 462 (1).svg" alt="Стрелка" class="level-arrow">
                                    </div>
                                    <div class="level-details">
                                        <p> Углубленный уровень сложности первый-второй год обучения, 504.</p>
                                        <p>
                                            <li> Обязательные предметы области (количество часов − 30);</li>
                                        </p>
                                        <p>
                                            <li> Вариативные предметные области (количество часов − 20);</li>
                                        </p>
                                        <p>
                                            <li> Теория (количество часов − 9);</li>
                                        </p>
                                        <p>
                                            <li> Практика (количество часов − 433);</li>
                                        </p>
                                        <p>
                                            <li> Самостоятельная работа (количество часов − 8);</li>
                                        </p>
                                        <p>
                                            <li> Аттестация (количество часов − 4).</li>
                                        </p>
                                        <p> Углубленный уровень сложности третий-четвертый год обучения, 588 часов.</p>
                                        <p>
                                            <li> Обязательные предметы области (количество часов − 35);</li>
                                        </p>
                                        <p>
                                            <li> Вариативные предметные области (количество часов − 23);</li>
                                        </p>
                                        <p>
                                            <li> Теория (количество часов − 10);</li>
                                        </p>
                                        <p>
                                            <li> Практика (количество часов − 506);</li>
                                        </p>
                                        <p>
                                            <li> Самостоятельная работа (количество часов − 10);</li>
                                        </p>
                                        <p>
                                            <li> Аттестация (количество часов − 4).</li>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <script>
            // JavaScript код для страницы подробнее (если есть)
        </script>

        <script src="js.js"></script>
        </body>

        </html>
        <?php
    } else {
        echo "Кружок не найден.";
    }
} else {
    echo "Некорректный запрос.";
}

mysqli_close($db);
?>