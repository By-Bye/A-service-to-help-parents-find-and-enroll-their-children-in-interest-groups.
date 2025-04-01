<?php
$db = mysqli_connect('MySQL-8.0', 'root', '', 'mybase');

if (!$db) {
    die("Ошибка подключения к базе данных: " . mysqli_connect_error());
}

if (isset($_POST['categories']) && isset($_POST['price_filter'])) {
    $categories_json = $_POST['categories'];
    $selected_categories = json_decode($categories_json, true);
    $price_filter = $_POST['price_filter'];

    $where_clause = "";
    $params = [];
    $types = "";

    if (is_array($selected_categories) && !empty($selected_categories)) {
        $placeholders = implode(',', array_fill(0, count($selected_categories), '?'));
        $where_clause .= "cat.name IN ($placeholders)";
        $params = array_merge($params, $selected_categories);
        $types .= str_repeat('s', count($selected_categories));
    }

    if ($price_filter === 'paid') {
        if (!empty($where_clause)) {
            $where_clause .= " AND ";
        }
        $where_clause .= "c.is_free = 0";
    } else if ($price_filter === 'free') {
        if (!empty($where_clause)) {
            $where_clause .= " AND ";
        }
        $where_clause .= "c.is_free = 1";
    }

    $query = "SELECT c.*, cat.name AS category_name FROM clubs c
              JOIN categories cat ON c.category_id = cat.category_id";

    if (!empty($where_clause)) {
        $query .= " WHERE " . $where_clause;
    }

    $stmt = mysqli_prepare($db, $query);

    if ($stmt) {
        if (!empty($params)) {
            mysqli_stmt_bind_param($stmt, $types, ...$params);
        }
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $current_category = null;
            while ($club = mysqli_fetch_assoc($result)) {
                if ($club['category_name'] !== $current_category) {
                    if ($current_category !== null) {
                        echo '</div>'; // Закрываем предыдущую категорию
                    }
                    echo '<h4 class="montserrat-bold">' . htmlspecialchars($club['category_name']) . '</h4><div class="row">';
                    $current_category = $club['category_name'];
                }
                ?>
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
                <?php
            }
            if ($current_category !== null) {
                echo '</div>'; // Закрываем последнюю категорию
            }
        } else {
            echo '<p>Нет кружков, соответствующих выбранным фильтрам.</p>';
        }
    } else {
        echo '<p>Выберите хотя бы одну категорию или тип оплаты.</p>';
    }
} else {
    echo "Ошибка: Не переданы данные для фильтрации.";
}

mysqli_close($db);
?>