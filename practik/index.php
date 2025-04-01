<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>KidsContent</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Montserrat+Alternates:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
    rel="stylesheet">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  <link rel="stylesheet" href="css/fonts.css">
  <link rel="stylesheet" href="css/style.css">

</head>

<body>


  <header class="mt-2">
    <nav class="navbar navbar-expand-lg navbar-dark container">
      <div class="container">
        <a class="navbar-brand" href="#">
          <img src="img/Group 1.png" alt="Логотип KidsConnect" style="max-height: 60px;"> <span
            class="montserrat-alternates-semibold">KidsConnect</span>
        </a>
      </div>
    </nav>
  </header>


  <main class="mt-4">
    <div class="container block">
      <div class="row pt-5">
        <div class="col-md-12">
          <div class="d-flex justify-content-between align-items-center">
            <div class="input-group" style="max-width: 300px;">
              <div class="input-group-append">
                <button class="btn btn-outline-secondary search" type="button">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-search" viewBox="0 0 16 16">
                    <path
                      d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                  </svg>
                </button>
              </div>
              <input type="text" class="form-control" placeholder="Поиск" aria-label="Поиск">
            </div>

              <ul class="nav nav-tabs">
                  <li class="nav-item">
                      <button class="nav-link active montserrat-regular" type="button" id="filter-all">Все</button>
                  </li>
                  <li class="nav-item">
                      <button class="nav-link montserrat-regular" type="button" id="filter-paid">Платные</button>
                  </li>
                  <li class="nav-item">
                      <button class="nav-link montserrat-regular" type="button" id="filter-free">Бесплатные</button>
                  </li>
              </ul>

            <div>
              <button class="btn btn-outline-secondary" type="button">
                <span>На карте</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                  class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                  <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" />
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>











      <section class="mt-4">
        <div class="container">
          <div class="row">
            <div class="col-md-9">
              <div class="card-block">
                
<?php
$db = mysqli_connect('MySQL-8.0', 'root', '', 'mybase');

if (!$db) {
    die("Ошибка подключения к базе данных: " . mysqli_connect_error());
}

// Запрос для получения кружков из категории "Силовой спорт"
$category_name = 'Силовой спорт';
$query = "SELECT c.* FROM clubs c
          JOIN categories cat ON c.category_id = cat.category_id
          WHERE cat.name = ?";
$stmt = mysqli_prepare($db, $query);
mysqli_stmt_bind_param($stmt, "s", $category_name);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result) {
    // Проверяем, есть ли кружки в данной категории
    if (mysqli_num_rows($result) > 0) {
        echo '<h4 class="montserrat-bold">' . htmlspecialchars($category_name) . '</h4>';
        while ($club = mysqli_fetch_assoc($result)) {
            ?>
            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="row no-gutters">
                            <div class="col-md-3">
                                <div class="card-img-wrapper">
                                    <img src="<?php echo htmlspecialchars($club['image_path']); ?>" class="card-img"
                                         alt="<?php echo htmlspecialchars($club['title']); ?>">
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <h5 class="card-title"><?php echo htmlspecialchars($club['title']); ?>
                                            <?php if (!empty($club['location'])): ?>
                                                <br>(в <?php echo htmlspecialchars($club['location']); ?>)
                                            <?php endif; ?>
                                        </h5>
                                        <?php if ($club['is_free']): ?>
                                            <span class="badge badge-success montserrat-regular">Бесплатно</span>
                                        <?php else: ?>
                                            <?php if ($club['price'] === 'Первое бесплатно'): ?>
                                                <span class="badge badge-warning montserrat-alternates-bold">Первое бесплатно</span>
                                            <?php elseif (!empty($club['price'])): ?>
                                                <span class="badge badge-success montserrat-regular">
                                                    <?php echo htmlspecialchars($club['price']); ?>
                                                </span>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                    <p class="card-text"><small class="text-muted hashtag"><?php echo htmlspecialchars($club['hashtag']); ?></small></p>

                                    <div class="card-info-block venue">
                                        <img src="img/1.svg" alt="Возраст">
                                        <span><?php echo htmlspecialchars($club['age_range']); ?></span>
                                    </div>

                                    <div class="card-info-block venue">
                                        <img src="img/2.svg" alt="Адрес">
                                        <span><?php echo htmlspecialchars($club['address']); ?></span>
                                    </div>

                                    <div class="card-info-block venue">
                                        <img src="img/3.svg" alt="Место проведения">
                                        <span><?php echo htmlspecialchars($club['venue']); ?></span>
                                    </div>

                                    <div class="card-info-block schedule">
                                        <img src="img/4.svg" alt="Расписание">
                                        <span><?php echo htmlspecialchars($club['schedule_days']); ?></span>
                                        <?php
                                        $schedule_times = explode("\n", $club['schedule_times']);
                                        foreach ($schedule_times as $time):
                                            $time = trim($time);
                                            if (!empty($time)):
                                                ?>
                                                <span class="badge time montserrat-regular"><?php echo htmlspecialchars($time); ?></span>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                          <a href="club_details.php?id=<?php echo $club['id']; ?>" class="btn btn-outline-secondary card-link-button knopka">Подробнее</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    } else {
        echo '<p>Нет кружков в категории "' . htmlspecialchars($category_name) . '".</p>';
    }
} else {
    echo "Ошибка выполнения запроса: " . mysqli_error($db);
}

mysqli_close($db);
?>






<?php
$db = mysqli_connect('MySQL-8.0', 'root', '', 'mybase');

if (!$db) {
    die("Ошибка подключения к базе данных: " . mysqli_connect_error());
}

// Запрос для получения кружков из категории "Единоборства"
$category_name = 'Единоборства';
$query = "SELECT c.* FROM clubs c
          JOIN categories cat ON c.category_id = cat.category_id
          WHERE cat.name = ?";
$stmt = mysqli_prepare($db, $query);
mysqli_stmt_bind_param($stmt, "s", $category_name);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result) {
    // Проверяем, есть ли кружки в данной категории
    if (mysqli_num_rows($result) > 0) {
        echo '<h4 class="montserrat-bold">' . htmlspecialchars($category_name) . '</h4>';
        while ($club = mysqli_fetch_assoc($result)) {
            ?>
            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="row no-gutters">
                            <div class="col-md-3">
                                <div class="card-img-wrapper">
                                    <img src="<?php echo htmlspecialchars($club['image_path']); ?>" class="card-img"
                                         alt="<?php echo htmlspecialchars($club['title']); ?>">
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <h5 class="card-title"><?php echo htmlspecialchars($club['title']); ?>
                                            <?php if (!empty($club['location'])): ?>
                                                <br>(в <?php echo htmlspecialchars($club['location']); ?>)
                                            <?php endif; ?>
                                        </h5>
                                        <?php if ($club['is_free']): ?>
                                            <span class="badge badge-success montserrat-regular">Бесплатно</span>
                                        <?php else: ?>
                                            <?php if ($club['price'] === 'Первое бесплатно'): ?>
                                                <span class="badge badge-warning montserrat-alternates-bold">Первое бесплатно</span>
                                            <?php elseif (!empty($club['price'])): ?>
                                                <span class="badge badge-success montserrat-regular">
                                                    <?php echo htmlspecialchars($club['price']); ?>
                                                </span>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                    <p class="card-text"><small class="text-muted hashtag"><?php echo htmlspecialchars($club['hashtag']); ?></small></p>

                                    <div class="card-info-block venue">
                                        <img src="img/1.svg" alt="Возраст">
                                        <span><?php echo htmlspecialchars($club['age_range']); ?></span>
                                    </div>

                                    <div class="card-info-block venue">
                                        <img src="img/2.svg" alt="Адрес">
                                        <span><?php echo htmlspecialchars($club['address']); ?></span>
                                    </div>

                                    <div class="card-info-block venue">
                                        <img src="img/3.svg" alt="Место проведения">
                                        <span><?php echo htmlspecialchars($club['venue']); ?></span>
                                    </div>

                                    <div class="card-info-block schedule">
                                        <img src="img/4.svg" alt="Расписание">
                                        <span><?php echo htmlspecialchars($club['schedule_days']); ?></span>
                                        <?php
                                        $schedule_times = explode("\n", $club['schedule_times']);
                                        foreach ($schedule_times as $time):
                                            $time = trim($time);
                                            if (!empty($time)):
                                                ?>
                                                <span class="badge time montserrat-regular"><?php echo htmlspecialchars($time); ?></span>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                          <a href="club_details.php?id=<?php echo $club['id']; ?>" class="btn btn-outline-secondary card-link-button knopka">Подробнее</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    } else {
        echo '<p>Нет кружков в категории "' . htmlspecialchars($category_name) . '".</p>';
    }
} else {
    echo "Ошибка выполнения запроса: " . mysqli_error($db);
}

mysqli_close($db);
?>


<?php
$db = mysqli_connect('MySQL-8.0', 'root', '', 'mybase');

if (!$db) {
    die("Ошибка подключения к базе данных: " . mysqli_connect_error());
}

// Запрос для получения кружков из категории "Единоборства"
$category_name = 'ДПИ и ремесла';
$query = "SELECT c.* FROM clubs c
          JOIN categories cat ON c.category_id = cat.category_id
          WHERE cat.name = ?";
$stmt = mysqli_prepare($db, $query);
mysqli_stmt_bind_param($stmt, "s", $category_name);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result) {
    // Проверяем, есть ли кружки в данной категории
    if (mysqli_num_rows($result) > 0) {
        echo '<h4 class="montserrat-bold">' . htmlspecialchars($category_name) . '</h4>';
        while ($club = mysqli_fetch_assoc($result)) {
            ?>
            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="row no-gutters">
                            <div class="col-md-3">
                                <div class="card-img-wrapper">
                                    <img src="<?php echo htmlspecialchars($club['image_path']); ?>" class="card-img"
                                         alt="<?php echo htmlspecialchars($club['title']); ?>">
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <h5 class="card-title"><?php echo htmlspecialchars($club['title']); ?>
                                            <?php if (!empty($club['location'])): ?>
                                                <br>(в <?php echo htmlspecialchars($club['location']); ?>)
                                            <?php endif; ?>
                                        </h5>
                                        <?php if ($club['is_free']): ?>
                                            <span class="badge badge-success montserrat-regular">Бесплатно</span>
                                        <?php else: ?>
                                            <?php if ($club['price'] === 'Первое бесплатно'): ?>
                                                <span class="badge badge-warning montserrat-alternates-bold">Первое бесплатно</span>
                                            <?php elseif (!empty($club['price'])): ?>
                                                <span class="badge badge-success montserrat-regular">
                                                    <?php echo htmlspecialchars($club['price']); ?>
                                                </span>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                    <p class="card-text"><small class="text-muted hashtag"><?php echo htmlspecialchars($club['hashtag']); ?></small></p>

                                    <div class="card-info-block venue">
                                        <img src="img/1.svg" alt="Возраст">
                                        <span><?php echo htmlspecialchars($club['age_range']); ?></span>
                                    </div>

                                    <div class="card-info-block venue">
                                        <img src="img/2.svg" alt="Адрес">
                                        <span><?php echo htmlspecialchars($club['address']); ?></span>
                                    </div>

                                    <div class="card-info-block venue">
                                        <img src="img/3.svg" alt="Место проведения">
                                        <span><?php echo htmlspecialchars($club['venue']); ?></span>
                                    </div>

                                    <div class="card-info-block schedule">
                                        <img src="img/4.svg" alt="Расписание">
                                        <span><?php echo htmlspecialchars($club['schedule_days']); ?></span>
                                        <?php
                                        $schedule_times = explode("\n", $club['schedule_times']);
                                        foreach ($schedule_times as $time):
                                            $time = trim($time);
                                            if (!empty($time)):
                                                ?>
                                                <span class="badge time montserrat-regular"><?php echo htmlspecialchars($time); ?></span>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                          <a href="club_details.php?id=<?php echo $club['id']; ?>" class="btn btn-outline-secondary card-link-button knopka">Подробнее</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    } else {
        echo '<p>Нет кружков в категории "' . htmlspecialchars($category_name) . '".</p>';
    }
} else {
    echo "Ошибка выполнения запроса: " . mysqli_error($db);
}

mysqli_close($db);
?>



























<br><br><br>
                <!-- 2 card -->
                <div class="row">
                  <div class="col-md-12 mb-4">
                    <div class="card">
                      <div class="row no-gutters">
                        <div class="col-md-3">
                          <div class="card-img-wrapper"> <img src="img/Group 330.png" class="card-img"
                              alt="Placeholder Image">
                          </div>
                        </div>
                        <div class="col-md-9">
                          <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                              <h5 class="card-title">Тяжелая атлетика <br>(в Юбилейном мкр.)</h5>
                              <span class="badge badge-warning montserrat-alternates-bold">Первое бесплатно</span>
                              <span class="badge badge-success montserrat-regular">500 рублей</span>
                            </div>
                            <p class="card-text"><small class="text-muted hashtag">#Тяжелая атлетика</small></p>

                            <div class="card-info-block venue"> <img src="img/1.svg" alt="Возраст">
                              <span>10-18 лет</span>
                            </div>

                            <div class="card-info-block venue"> <img src="img/2.svg" alt="Адрес">
                              <span>г. Иркутск, Юбилейный мкр., стр. 49/1</span>
                            </div>

                            <div class="card-info-block venue"> <img src="img/3.svg" alt="Место проведения">
                              <span>ФОК "Юбилейный"</span>
                            </div>

                            <div class="card-info-block schedule"> <img src="img/4.svg" alt="Расписание">
                              <span>Пн, Ср, Пт</span>
                              <span class="badge time montserrat-regular">09:00 - 10:30</span>
                              <span class="badge time montserrat-regular">12:00 - 13:30</span>
                              <span class="badge time montserrat-regular">18:00 - 19:30</span>
                              <button class="btn btn-outline-secondary card-link-button knopka"
                                type="button">Подробнее</button>
                            </div>


                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>




              </div>
            </div>




            <div class="col-md-3 montserrat-regular">
              <h4 class="montserrat-bold">Фильтры</h4>
              <div class="filter-block">
                <div class="filter-group mt-3">
                  <h5 class="montserrat-bold">Возраст</h5>
                  <select class="form-control form-control-sm">
                    <option>Любой</option>
                    <option>7-10 лет</option>
                    <option>10-14 лет</option>
                    <option>14-18 лет</option>
                  </select>
                </div>

                <div class="filter-group mt-3">
                  <h5>Пол</h5>
                  <div class="gender-inputs-row">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="maleCheckbox" checked>
                      <label class="form-check-label" for="maleCheckbox">
                        Мужской
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="femaleCheckbox" checked>
                      <label class="form-check-label" for="femaleCheckbox">
                        Женский
                      </label>
                    </div>
                  </div>
                </div>





  <div class="filter-group mt-3">
    <h5 class="montserrat-bold">Каталог</h5>
    <div class="catalog-filter-list">
        <details class="catalog-filter-item">
            <summary class="catalog-filter-title">Силовой спорт <span class="filter-count">3</span></summary>
            <div class="catalog-filter-options">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Силовой спорт" id="silovoySportCheckbox">
                    <label class="form-check-label" for="silovoySportCheckbox">
                        Силовой спорт
                    </label>
                </div>
            </div>
        </details>
        <details class="catalog-filter-item">
            <summary class="catalog-filter-title">Единоборства <span class="filter-count">2</span></summary>
            <div class="catalog-filter-options">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Единоборства" id="edinoborstvaCheckbox">
                    <label class="form-check-label" for="edinoborstvaCheckbox">
                        Единоборства
                    </label>
                </div>
            </div>
        </details>
        <details class="catalog-filter-item">
            <summary class="catalog-filter-title">ДПИ и ремесла <span class="filter-count">4</span></summary>
            <div class="catalog-filter-options">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="ДПИ и ремесла" id="dpiRemeslaCheckbox">
                    <label class="form-check-label" for="dpiRemeslaCheckbox">
                        ДПИ и ремесла
                    </label>
                </div>
            </div>
        </details>
        <details class="catalog-filter-item">
            <summary class="catalog-filter-title">Техническое конструирование</summary>
            <div class="catalog-filter-options">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Техническое конструирование" id="tehKonstruirovanieCheckbox">
                    <label class="form-check-label" for="tehKonstruirovanieCheckbox">
                        Техническое конструирование
                    </label>
                </div>
            </div>
        </details>
        <details class="catalog-filter-item">
            <summary class="catalog-filter-title">Словесность</summary>
            <div class="catalog-filter-options">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Словесность" id="slovesnostCheckbox">
                    <label class="form-check-label" for="slovesnostCheckbox">
                        Словесность
                    </label>
                </div>
            </div>
        </details>
        <details class="catalog-filter-item">
            <summary class="catalog-filter-title">Иностранные языки</summary>
            <div class="catalog-filter-options">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Иностранные языки" id="inostrYazikiCheckbox">
                    <label class="form-check-label" for="inostrYazikiCheckbox">
                        Иностранные языки
                    </label>
                </div>
            </div>
        </details>
        <details class="catalog-filter-item">
            <summary class="catalog-filter-title">Развитие интеллекта</summary>
            <div class="catalog-filter-options">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Развитие интеллекта" id="razvitie интеллектаCheckbox">
                    <label class="form-check-label" for="razvitie интеллектаCheckbox">
                        Развитие интеллекта
                    </label>
                </div>
            </div>
        </details>
        <details class="catalog-filter-item">
            <summary class="catalog-filter-title">Информационные технологии</summary>
            <div class="catalog-filter-options">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Информационные технологии" id="informTehnologiiCheckbox">
                    <label class="form-check-label" for="informTehnologiiCheckbox">
                        Информационные технологии
                    </label>
                </div>
            </div>
        </details>
        <details class="catalog-filter-item">
            <summary class="catalog-filter-title">История и Традиции</summary>
            <div class="catalog-filter-options">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="История и Традиции" id="istoriaTradiciiCheckbox">
                    <label class="form-check-label" for="istoriaTradiciiCheckbox">
                        История и Традиции
                    </label>
                </div>
            </div>
        </details>
        <details class="catalog-filter-item">
            <summary class="catalog-filter-title">Педагогика</summary>
            <div class="catalog-filter-options">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Педагогика" id="pedagogikaCheckbox">
                    <label class="form-check-label" for="pedagogikaCheckbox">
                        Педагогика
                    </label>
                </div>
            </div>
        </details>
        <details class="catalog-filter-item">
            <summary class="catalog-filter-title">Музыка и звук</summary>
            <div class="catalog-filter-options">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Музыка и звук" id="muzikaZvukCheckbox">
                    <label class="form-check-label" for="muzikaZvukCheckbox">
                        Музыка и звук
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="singingCheckbox">
                    <label class="form-check-label" for="singingCheckbox">
                        Пение
                    </label>
                </div>
            </div>
        </details>
        <details class="catalog-filter-item">
            <summary class="catalog-filter-title">Хореография (танцы)</summary>
            <div class="catalog-filter-options">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Хореография (танцы)" id="horeografiaTanciCheckbox">
                    <label class="form-check-label" for="horeografiaTanciCheckbox">
                        Хореография (танцы)
                    </label>
                </div>
            </div>
        </details>
        <details class="catalog-filter-item">
            <summary class="catalog-filter-title">Зрелищные искусства</summary>
            <div class="catalog-filter-options">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Зрелищные искусства" id="zrelischnieIskusstvaCheckbox">
                    <label class="form-check-label" for="zrelischnieIskusstvaCheckbox">
                        Зрелищные искусства
                    </label>
                </div>
            </div>
        </details>
        <details class="catalog-filter-item">
            <summary class="catalog-filter-title">Мода и стиль</summary>
            <div class="catalog-filter-options">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Мода и стиль" id="modaStilCheckbox">
                    <label class="form-check-label" for="modaStilCheckbox">
                        Мода и стиль
                    </label>
                </div>
            </div>
        </details>
        <details class="catalog-filter-item">
            <summary class="catalog-filter-title">Познавательные развлечения</summary>
            <div class="catalog-filter-options">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Познавательные развлечения" id="poznavatelnieRazvlecheniaCheckbox">
                    <label class="form-check-label" for="poznavatelnieRazvlecheniaCheckbox">
                        Познавательные развлечения
                    </label>
                </div>
            </div>
        </details>
        <details class="catalog-filter-item">
            <summary class="catalog-filter-title">Туризм</summary>
            <div class="catalog-filter-options">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Туризм" id="turizmCheckbox">
                    <label class="form-check-label" for="turizmCheckbox">
                        Туризм
                    </label>
                </div>
            </div>
        </details>
        <details class="catalog-filter-item">
            <summary class="catalog-filter-title">Естественные науки</summary>
            <div class="catalog-filter-options">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Естественные науки" id="estestvennieNaukiCheckbox">
                    <label class="form-check-label" for="estestvennieNaukiCheckbox">
                        Естественные науки
                    </label>
                </div>
            </div>
        </details>
        <details class="catalog-filter-item">
            <summary class="catalog-filter-title">Люди и животные</summary>
            <div class="catalog-filter-options">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Люди и животные" id="ludiZivotnieCheckbox">
                    <label class="form-check-label" for="ludiZivotnieCheckbox">
                        Люди и животные
                    </label>
                </div>
            </div>
        </details>
        <details class="catalog-filter-item">
            <summary class="catalog-filter-title">Эстетические виды спорта</summary>
            <div class="catalog-filter-options">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Эстетические виды спорта" id="estetSportaCheckbox">
                    <label class="form-check-label" for="estetSportaCheckbox">
                        Эстетические виды спорта
                    </label>
                </div>
            </div>
        </details>
        <details class="catalog-filter-item">
            <summary class="catalog-filter-title">Технические виды спорта</summary>
            <div class="catalog-filter-options">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Технические виды спорта" id="tehSportaCheckbox">
                    <label class="form-check-label" for="tehSportaCheckbox">
                        Технические виды спорта
                    </label>
                </div>
            </div>
        </details>
        <details class="catalog-filter-item">
            <summary class="catalog-filter-title">Командно-игровой спорт</summary>
            <div class="catalog-filter-options">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Командно-игровой спорт" id="komandSportCheckbox">
                    <label class="form-check-label" for="komandSportCheckbox">
                        Командно-игровой спорт
                    </label>
                </div>
            </div>
        </details>
        <details class="catalog-filter-item">
            <summary class="catalog-filter-title">Индивидуально игровой спорт</summary>
            <div class="catalog-filter-options">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Индивидуально игровой спорт" id="individualSportCheckbox">
                    <label class="form-check-label" for="individualSportCheckbox">
                        Индивидуально игровой спорт
                    </label>
                </div>
            </div>
        </details>
        <details class="catalog-filter-item">
            <summary class="catalog-filter-title">Водные виды спорта</summary>
            <div class="catalog-filter-options">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Водные виды спорта" id="vodnieSportaCheckbox">
                    <label class="form-check-label" for="vodnieSportaCheckbox">
                        Водные виды спорта
                    </label>
                </div>
            </div>
        </details>
        <details class="catalog-filter-item">
            <summary class="catalog-filter-title">Лёгкая атлетика и гимнастика</summary>
            <div class="catalog-filter-options">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Лёгкая атлетика и гимнастика" id="legkayaAtletikaGimnastikaCheckbox">
                    <label class="form-check-label" for="legkayaAtletikaGimnastikaCheckbox">
                        Лёгкая атлетика и гимнастика
                    </label>
                </div>
            </div>
        </details>
        <details class="catalog-filter-item">
            <summary class="catalog-filter-title">Физкультура</summary>
            <div class="catalog-filter-options">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Физкультура" id="fizkulturaCheckbox">
                    <label class="form-check-label" for="fizkulturaCheckbox">
                        Физкультура
                    </label>
                </div>
            </div>
        </details>
    </div>
</div>








              













              







              




















              </div>
            </div>



          </div>
        </div>
      </section>



    </div>


  </main>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>




  <script>
document.addEventListener('DOMContentLoaded', function() {
    const categoryCheckboxes = document.querySelectorAll('.catalog-filter-options input[type="checkbox"]');
    const priceFilters = document.querySelectorAll('.nav-tabs button');
    const cardBlock = document.querySelector('.card-block'); // Блок, куда выводятся карточки
    let selectedPriceFilter = 'all'; // По умолчанию выбраны "Все"

    // Функция для получения выбранных категорий
    function getSelectedCategories() {
        return Array.from(categoryCheckboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value);
    }

    // Функция для отправки AJAX запроса
    function filterClubs() {
        const selectedCategories = getSelectedCategories();

        fetch('get_filtered_clubs.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'categories=' + encodeURIComponent(JSON.stringify(selectedCategories)) + '&price_filter=' + encodeURIComponent(selectedPriceFilter)
        })
        .then(response => response.text())
        .then(data => {
            cardBlock.innerHTML = data; // Обновляем блок с карточками
        })
        .catch(error => {
            console.error('Ошибка при фильтрации:', error);
            cardBlock.innerHTML = '<p>Произошла ошибка при загрузке данных.</p>';
        });
    }

    // Слушатели для фильтров по категориям
    categoryCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', filterClubs);
    });

    // Слушатели для фильтров по типу оплаты
    priceFilters.forEach(filterButton => {
        filterButton.addEventListener('click', function() {
            // Сбрасываем активное состояние у всех кнопок
            priceFilters.forEach(btn => btn.classList.remove('active'));
            // Устанавливаем активное состояние для нажатой кнопки
            this.classList.add('active');

            const filterId = this.id;
            if (filterId === 'filter-all') {
                selectedPriceFilter = 'all';
            } else if (filterId === 'filter-paid') {
                selectedPriceFilter = 'paid';
            } else if (filterId === 'filter-free') {
                selectedPriceFilter = 'free';
            }
            filterClubs(); // Вызываем функцию фильтрации
        });
    });
});
  </script>

</body>

</html>