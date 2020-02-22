<!DOCTYPE html>
<html>
    <head>
        <title>Календарь задач</title>
        <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
        <script src="scripts.js"></script>
    </head>
    <body>
        <div class="calendar-container">
            <?php getCalendar(); ?>
        </div>
        <div class="blackout">
            <div class="popup-box" id="change-day">
                <h2 class="box-top">Изменить задачи <?php echo strftime("%e %B");?></h2>
                <div class="close-box">x</div>
                <div class="box-content">
                    <p>Список задач</p>
                    <p>Изменить задачу</p>
                    <p>Удалить задачу</p>
                    <p>День закончен</p>
                    <p>Выходной день</p>
                </div>
            </div>
            <div class="popup-box" id="add-task">
                <h2 class="box-top">Добавить задачу на <?php echo strftime("%e %B");?></h2>
                <div class="close-box">x</div>
                <div class="box-content">
                    <p>Название задачи</p>
                    <p>Цвет задачи</p>
                    <p>Комментарий</p>
                    <button>Добавить</button>
                </div>
            </div>
        </div>
    </body>
</html>


<div style="background-color: white; display: none;">
    <?php
    echo date('d F, N, l');

    echo '<br>';
    echo strftime("Сегодня %e %B %Y, %A");

    echo '<br>';

    $result = $db->query('SELECT * from tasks');
    $rows = mysqli_num_rows($result); // количество полученных строк

    echo "<table><tr><th>Id</th><th>title</th><th>date</th><th>status</th><th>comment</th></tr>";
    for ($i = 0 ; $i < $rows ; ++$i)
    {
        $row = mysqli_fetch_row($result);
        echo "<tr>";
        for ($j = 0 ; $j < 5 ; ++$j) echo "<td>$row[$j]</td>";
        echo "</tr>";
    }
    echo "</table>";

    // очищаем результат
    mysqli_free_result($result);
    ?>
</div>
