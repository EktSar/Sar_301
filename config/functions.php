<?php
// Функция подключения pdo - соединение с бд
function getConnection(){
    require  'db.php'; // Подключаем данные бд
    static $pdo;

    if (empty($pdo)) {
        try {
            $pdo = new PDO("$driver:host=$host; dbname=$db_name; charset=$charset",
                $db_user, $db_pass, $options);
        } catch (PDOException $e){
            die ('Произошла ошибка при подключении к базе данных!');
        }
    }

    return $pdo;
}

// Вывод уровня подготовки в таблице СТУДЕНТОВ на странице админа
function getLevelPreparing($level) {
    if ($level == 1)
        return 'Базовый';
    elseif ($level == 2)
        return 'Олимпиадный';
    elseif ($level == 3)
        return 'Продвинутый';
    else
        return 'Неизвестен';
}

// Вывод типа соревнования в таблице СОРЕВНОВАНИЯ на странице админа
function getTypeCompetitions($type) {
    if ($type == 1)
        return 'Персональный тренинг';
    elseif ($type == 2)
        return 'Командный тренинг';
    elseif ($type == 3)
        return 'Чемпионат по программированию факультета ВШ ЭКН';
    elseif ($type == 4)
        return 'Открытый командный чемпионат по программированию областного центра';
    elseif ($type == 5)
        return 'Открытый командный чемпионат по программированию федерального округа';
    elseif ($type == 6)
        return 'Интернет-версия открытого чемпионата УрФУ по программированию';
    elseif ($type == 7)
        return 'Четвертьфинал чемпионата мира по программированию';
    else
        return 'Тип неизвестен';
}
// Получение постоянного коэффициента рейтинга по типу соревнования
function getConstRating($type) {
    if ($type == 1) return 15;
    elseif ($type == 2) return 5;
    elseif ($type == 3) return 50;
    elseif ($type == 4) return 10;
    elseif ($type == 5) return 20;
    elseif ($type == 6) return 30;
    elseif ($type == 7) return 25;
    else return 0;
}
// Получение доп. баллов по занятому месту
function getAdditionalPoint($type, $place) {
    // персональный
    if ($type == 1) {
        if ($place == 1) return 20;
        elseif ($place == 2) return 10;
        elseif ($place == 3) return 5;
        else return 0;
    }
    // командный
    elseif ($type == 2) {
        if ($place == 1) return 15;
        elseif ($place == 2) return 10;
        elseif ($place == 3) return 5;
        else return 0;
    }
    // ВШ ЭКН
    elseif ($type == 3) {
        if ($place == 1) return 100;
        elseif ($place == 2) return 50;
        elseif ($place == 3) return 10;
        else return 0;
    }
    // областное
    elseif ($type == 4) {
        if ($place == 1) return 150;
        elseif ($place == 2) return 75;
        elseif ($place == 3) return 15;
        else return 0;
    }
    // федеральное
    elseif ($type == 5) {
        if ($place == 1) return 200;
        elseif ($place == 2) return 100;
        elseif ($place == 3) return 30;
        else return 0;
    }
    // УрФУ
    elseif ($type == 6) return 0;
    // 1/4 финал чемпионата мира
    elseif ($type == 7) {
        if ($place == 1) return 400;
        elseif ($place == 2) return 200;
        elseif ($place == 3) return 50;
        else return 0;
    }
    else return 0;
}

// Вывод показа соревнований в таблице СОРЕВНОВАНИЯ
function getView($view) {
    if ($view == 1)
        return 'Да';
    else
        return 'Нет';
}

// Получение номера месяца рейтинга, в котором должен измениться рейтинг, поиск по дате соревнования
function getRatingNumber($date) {
    // Дата соревнования, которое выбрал администратор, обрезанная до года и месяца (yyyy-mm)
    $dateCompetition = mb_strimwidth($date, 0, 7);

    // Получение всех 15 месяцев по номерам (массив [r_i] => "yyyy-mm")
    $arrRatingDate = getArrRatingDate();

    // Номер рейтинга, к которому нужно добавить баллы за прошедшее соревнование
    $ratingNumber = '';
    foreach ($arrRatingDate as $rNum => $rDate) {
        if ($rDate === $dateCompetition) {
            $ratingNumber = $rNum;
        }
    }

    return $ratingNumber;
}

// Массив с месяцем и годом для каждого из 15 номеров рейтинга, подсчет идет исходя из текущего месяца
function getArrRatingDate() {
    // Текущий месяц
    $curMonth = date('m');

    // Массив с месяцем и годом для каждого номера рейтинга
    $arrRatingDate = [];

    for ($i = 1; $i < 16; $i++) {
        $arrRatingDate["r_$i"] = date('Y-m', mktime(0, 0, 0, $curMonth - $i + 1, '1'));
    }

    return $arrRatingDate;
}

// Функция авторизации в личном кабинете
function checkUser($data) {
    if (isset($data['log_in'])) {
        $user = getStudentByEmail($data['email']); // Получить пользователя по полученной почте

        if ($user) {
            if (password_verify($data['password'], $user->password)) {
                $_SESSION['logged_user'] = $user;
                return true;
            }
        }
    }
    return false;
}
// Функция проверки логина и пароля админа
function checkAdmin($data) {
    if (isset($data['log_in_admin'])) {
        $login = 'admin-nimda';
        $password = 'V3CqZNJPMgjQYA4nmj$mLTaB';

        if ($data['login'] == $login && $data['password_admin'] == $password) {
            $_SESSION['logged_admin'] = true;
            return true;
        } else {
            session_write_close();
        }
    }
    return false;
}

// Расчет рейтинга при введении необходимых данных
function ratingCalculate($data) {
    $idComp = (int) htmlspecialchars(trim($data['comp']));
    $idStudent = (int) htmlspecialchars(trim($data['student']));
    $place = (int) htmlspecialchars(trim($data['place'])); // занятое место: 1-3 или участник
    $C = (int) htmlspecialchars(trim($data['count_tasks'])); // количество задач, решенных участником (командой)

    // Получить тип соревнования из бд
    $dataCompetition = getDataCompetition($idComp);

    // Получение константы формулы исходя из типа соревнования
    $k = getConstRating($dataCompetition->type);
    // Премиальные баллы, начисляемые участнику за занятое место (степень полученного диплома)
    $P = getAdditionalPoint($dataCompetition->type, $place);

    // Формула для высчитывания рейтинга по введеному соревнованию
    $rating = $C * $k + $P + 0.1;

    // Вставка в таблицу competitions_result
    insertResultCompetition($idComp, $idStudent, $C, $place, $rating);
    return ['rating' => $rating, 'idStudent' => $idStudent, 'date' => $dataCompetition->date];
}

// Изменение рейтинга у студента за конкретный месяц
function changeStudentRating($data) {
    // Номер месяца рейтинга, в котором должен измениться рейтинг, поиск по дате соревнования, либо пустая строка
    $ratingNumber = getRatingNumber($data['date']);

    if (!empty($ratingNumber)) {
        $objWithRating = getMonthlyRating($data['idStudent']); // Объект из бд со значениями рейтинга за 15 месяцев данного студента

        // Рассчитать новый рейтинг за месяц = предыдущий рейтинг + начисленный рейтинг
        $newRatingForMonth = ((float) $objWithRating->$ratingNumber) + $data['rating'];

        // Обновляем в объекте месяц, в котором проводилось соревнование (вставляется float)
        $objWithRating->$ratingNumber = $newRatingForMonth;

        // Рассчитать общий рейтинг с новыми данными
        $overallRating = getOverallRating($objWithRating);

        // Вставить обновленные рейтинг за конкретный месяц и общий рейтинг в бд
        updateRating($data['idStudent'], $ratingNumber, $newRatingForMonth, $overallRating);
    }
}

// Функция подсчетывает общий рейтинг
function getOverallRating($obj) {
    $overallRating = $obj->r_1 + $obj->r_2 + $obj->r_3 + $obj->r_4 + $obj->r_5 + $obj->r_6 +
        $obj->r_7 + $obj->r_8 + $obj->r_9 + $obj->r_10 + $obj->r_11 + $obj->r_12 +
        $obj->r_13/2 + $obj->r_14/4 + $obj->r_15/8;
    return $overallRating;
}

// Запросы к бд //
// SELECT //
// Получить тип, дату и название соревнования
function getDataCompetition($id) {
    $sql = "SELECT comp.type, comp.date
        FROM competitions AS comp WHERE comp.id = :id_comp";
    $stmt = getConnection()->prepare($sql);
    $stmt->execute([':id_comp' => $id]);
    return $stmt->fetch(PDO::FETCH_OBJ);
}

// Получить максимальное значение рейтинга из таблицы студентов
function getMaxRating() {
    $sql = "SELECT s.overall_rating FROM students AS s
        WHERE overall_rating=(SELECT MAX(overall_rating) FROM students)";
    $stmt = getConnection()->prepare($sql);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ)->overall_rating;
}
// Получить минимальное значение рейтинга из таблицы студентов
function getMinRating() {
    $sql = "SELECT s.overall_rating FROM students AS s
        WHERE overall_rating=(SELECT MIN(overall_rating) FROM students)";
    $stmt = getConnection()->prepare($sql);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ)->overall_rating;
}
// Получить среднее значение рейтинга из таблицы студентов
function getAvgRating() {
    $sql = "SELECT round(AVG(overall_rating), 2) AS overall_rating FROM students";
    $stmt = getConnection()->prepare($sql);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ)->overall_rating;
}

// Получить значение рейтинга за каждый из 15 месяцев по id студента
function getMonthlyRating($id) {
    $sql = "SELECT r_1, r_2, r_3, r_4, r_5, r_6, r_7,
        r_8, r_9, r_10, r_11, r_12, r_13, r_14, r_15
        FROM students
        WHERE id = ?";
    $stmt = getConnection()->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_OBJ);
}

// Получить список соревнований студента за весь период
function getListCompetitions($id) {
    $sql = "SELECT comp_res.rating, c.name, c.date
        FROM competitions_result as comp_res, competitions AS c 
        WHERE comp_res.student_id = :id AND comp_res.competitions_id = c.id ORDER BY date DESC";
    $stmt = getConnection()->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

// Получить все соревнования по названию
function getAllCompetitionsByName($params = '*') {
    $sql = "SELECT $params FROM competitions ORDER BY name ASC";
    return getConnection()->query($sql)->fetchAll(PDO::FETCH_OBJ);
}
// Получить все соревнования, сначала новые
function getAllCompetitionsByDate($params = '*') {
    $sql = "SELECT $params FROM competitions ORDER BY date DESC";
    return getConnection()->query($sql)->fetchAll(PDO::FETCH_OBJ);
}

// Получить всех участников цоп по названию
function getAllStudentsByName() {
    $sql = "SELECT id, name, login_codeforces, login_informatics,
        group_name, email, phone, level_preparing, year_acceptance
        FROM students ORDER BY name ASC";
    return getConnection()->query($sql)->fetchAll(PDO::FETCH_OBJ);
}
// Получить всех участников цоп по рейтингу
function getAllStudentsByRating() {
    $sql = "SELECT id, name, group_name, overall_rating
        FROM students ORDER BY overall_rating DESC";
    return getConnection()->query($sql)->fetchAll(PDO::FETCH_OBJ);
}

// Получение всех работников
function getAllWorkers() {
    $sql = "SELECT * FROM workers";
    return getConnection()->query($sql)->fetchAll(PDO::FETCH_OBJ);
}
// Получение всех партнеров
function getAllPartnersByName() {
    $sql = "SELECT * FROM partners ORDER BY name";
    return getConnection()->query($sql)->fetchAll(PDO::FETCH_OBJ);
}

// Получение данных для меню конкрентного соревнования
function getDataForMenuById($id) {
    $sql = "SELECT * FROM competitions_menu WHERE competition_id = ? ORDER BY title";
    $stmt = getConnection()->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

// Получение данных для фотогалереи по всем соревнованиям
function getDataForGallery() {
    $sql = "SELECT c.name, c.date, c_img.* FROM competitions AS c, competitions_img AS c_img
        WHERE c.id = c_img.competition_id AND c_img.url IS NOT NULL ORDER BY date DESC";
    return getConnection()->query($sql)->fetchAll(PDO::FETCH_OBJ);
}
// ... по конкретному
function getDataForGalleryById($id) {
    $sql = "SELECT c.name, c_img.url FROM competitions AS c, competitions_img AS c_img
        WHERE c_img.id = :id AND c_img.competition_id = c.id";
    $stmt = getConnection()->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_OBJ);
}

// Получить данные студента по id
function getStudentById($id) {
    $sql = 'SELECT * FROM students WHERE id = ?';
    $stmt = getConnection()->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_OBJ);
}
// Получить данные студента по email
function getStudentByEmail($email) {
    $sql = 'SELECT * FROM students WHERE email = ?';
    $stmt = getConnection()->prepare($sql);
    $stmt->execute([$email]);
    return $stmt->fetch(PDO::FETCH_OBJ);
}
// Получить данные соревнования по id
function getCompetitionById($id, $paramsSql = '*') {
    $sql = "SELECT $paramsSql FROM competitions WHERE id = ?";
    $stmt = getConnection()->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_OBJ);
}
// Получить данные новости по id
function getNewsById($id) {
    $sql = 'SELECT * FROM news WHERE id = ?';
    $stmt = getConnection()->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_OBJ);
}

// INSERT //
// Вставка в таблицу competitions_result
function insertResultCompetition($idComp, $idStudent, $countCompletedTasks, $place, $rating) {
    $params = [
        'competitions_id' => $idComp,
        'student_id' => $idStudent,
        'count_tasks' => $countCompletedTasks,
        'place' => $place,
        'rating' => $rating,
    ];
    $sql = "INSERT INTO competitions_result (competitions_id, student_id, count_tasks, place, rating)
        VALUES (:competitions_id, :student_id, :count_tasks, :place, :rating)";
    getConnection()->prepare($sql)->execute($params);
}

// Вставка студентов в бд
function insertStudent($data) {
    // Проверка введенных данных пользователя
    $params = [
        'name' => htmlspecialchars(trim($data['name'])),
        'logC' => htmlspecialchars(trim($data['login_codeforces'])),
        'logIn' => htmlspecialchars(trim($data['login_informatics'])),
        'pas' => password_hash($data['password'], PASSWORD_DEFAULT),
        'group' => htmlspecialchars(trim($data['group_name'])),
        'email' => htmlspecialchars(trim($data['email'])),
        'phone' => $data['phone'],
        'level' => htmlspecialchars(trim($data['level_preparing'])),
        'year' => $data['year_acceptance'],
        'rating' => getAvgRating(),
    ];
    $sql = "INSERT INTO students (name, login_codeforces, login_informatics, password,
        group_name, email, phone, level_preparing, year_acceptance, r_1, overall_rating)
        VALUES (:name, :logC, :logIn, :pas, :group, :email, :phone, :level, :year, :rating, :rating)";
    getConnection()->prepare($sql)->execute($params);

    // Вставка в таблицу с результами
    $sql = "INSERT INTO competitions_result (competitions_id, student_id, count_tasks, place, rating)
        VALUES (0, LAST_INSERT_ID(), 0, 0, :rating)";
    getConnection()->prepare($sql)->execute(['rating' => $params['rating']]);
}

// Вставка соревнования в бд
function insertCompetition($data) {
    // Проверка введенных данных пользователя
    $params = [
        'name' => htmlspecialchars(trim($data['name'])),
        'date' => $data['date'],
        'type' => htmlspecialchars(trim($data['type'])),
        'count' => htmlspecialchars(trim($data['count_tasks'])),
        'place' => htmlspecialchars(trim($data['place'])),
        'view' => htmlspecialchars(trim($data['view'])),
    ];
    $sql = "INSERT INTO competitions (name, date, type, count_tasks, place, view)
        VALUES (:name, :date, :type, :count, :place, :view)";
    getConnection()->prepare($sql)->execute($params);
}

// UPDATE //
// Обновление студента в бд
function updateStudent($data, $id) {
    // Если пароль был изменен
    if (!empty($data['password'])) {
        $params = [
            'name' => htmlspecialchars(trim($data['name'])),
            'logC' => htmlspecialchars(trim($data['login_codeforces'])),
            'logIn' => htmlspecialchars(trim($data['login_informatics'])),
            'pas' => password_hash($data['password'], PASSWORD_DEFAULT),
            'group' => htmlspecialchars(trim($data['group_name'])),
            'email' => htmlspecialchars(trim($data['email'])),
            'phone' => $data['phone'],
            'level' => $data['level_preparing'],
            'year' => $data['year_acceptance'],
            'id' => (int) $id,
        ];

        $sql = "UPDATE students SET name=:name, login_codeforces=:logC, login_informatics=:logIn, password=:pas,
        group_name=:group, email=:email, phone=:phone, level_preparing=:level, year_acceptance=:year
        WHERE id=:id";
    } else {
        $params = [
            'name' => htmlspecialchars(trim($data['name'])),
            'logC' => htmlspecialchars(trim($data['login_codeforces'])),
            'logIn' => htmlspecialchars(trim($data['login_informatics'])),
            'group' => htmlspecialchars(trim($data['group_name'])),
            'email' => htmlspecialchars(trim($data['email'])),
            'phone' => $data['phone'],
            'level' => $data['level_preparing'],
            'year' => $data['year_acceptance'],
            'id' => (int) $id,
        ];

        $sql = "UPDATE students SET name=:name, login_codeforces=:logC, login_informatics=:logIn,
        group_name=:group, email=:email, phone=:phone, level_preparing=:level, year_acceptance=:year
        WHERE id=:id";
    }
    getConnection()->prepare($sql)->execute($params);
}

// Обновление соревнования в бд
function updateCompetition($data, $id) {
    $params = [
        'name' => htmlspecialchars(trim($data['name'])),
        'date' => $data['date'],
        'type' => htmlspecialchars(trim($data['type'])),
        'count' => htmlspecialchars(trim($data['count_tasks'])),
        'place' => htmlspecialchars(trim($data['place'])),
        'view' => htmlspecialchars(trim($data['view'])),
        'id' => (int) $id,
    ];

    $sql = "UPDATE competitions SET name=:name, date=:date, type=:type,
        count_tasks=:count, place=:place, view=:view
        WHERE id=:id";
    getConnection()->prepare($sql)->execute($params);
}

// Обновление измененного рейтинга за конкретный месяц и общего в бд
function updateRating($idStudent, $rNumber, $newRating, $overallRating) {
    $params = [
        'rating' => $newRating,
        'ovrllRating' => $overallRating,
        'id' => $idStudent,
    ];
    $sql = "UPDATE students SET $rNumber=:rating, overall_rating=:ovrllRating WHERE id=:id";
    getConnection()->prepare($sql)->execute($params);
}

// DELETE //
// Удаление студента из бд
function deleteStudentById($id) {
    $sql = "DELETE FROM students WHERE id = ?";
    getConnection()->prepare($sql)->execute([$id]);
}
// Удаление соревнования из бд
function deleteCompetitionById($id) {
    $sql = "DELETE FROM competitions WHERE id = ?";
    getConnection()->prepare($sql)->execute([$id]);
}
// //
