<?php
require 'config.php';

// Обращение к бд за старыми данными
$sql = "SELECT id, r_1, r_2, r_3, r_4, r_5, r_6, r_7, r_8,
    r_9, r_10, r_11, r_12, r_13, r_14, r_15, overall_rating
    FROM students";
$stmt = getConnection()->prepare($sql);
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_OBJ);

// Перебор по каждому студенту в базе
foreach ($students as $user) {
    // Сдвигаем данные
    for ($i = 15; $i > 1; $i--) {
        $num = "r_$i";
        $prevNum = "r_" . ($i-1);
        $user->$num = $user->$prevNum;
    }
    $user->r_1 = 0;

    // Пересчитываем общий рейтинг
    $user->overall_rating = getOverallRating($user);

    $params = [
        'rating' => $user->overall_rating,
        'id' => $user->id,
    ];
    for ($i = 1; $i < 16; $i++) {
        $num = "r_$i";
        $params["r$i"] = $user->$num;
    }

    $sql = "UPDATE students SET r_1=:r1, r_2=:r2, r_3=:r3, r_4=:r4, r_5=:r5, r_6=:r6, r_7=:r7, r_8=:r8,
        r_9=:r9, r_10=:r10, r_11=:r11, r_12=:r12, r_13=:r13, r_14=:r14, r_15=:r15, overall_rating=:rating
        WHERE id=:id";
    getConnection()->prepare($sql)->execute($params);
}
