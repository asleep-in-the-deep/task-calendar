<!DOCTYPE html>
<html lang="ru_RU">
    <head>
        <title>Календарь задач</title>
        <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
        <link rel="icon" type="image/png" href="img/calendar.png">
        <link rel="stylesheet" href="style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
        <script src="scripts.js"></script>
        <?php
        if (UseEmojiHook()) {
        ?>
        <style>
            @font-face {
                font-family: "Emoji Font";
                src: url("emojione-android.ttf") format("truetype");
            }
            select, option {
                font-family: "Emoji Font", Montserrat, serif, "sans-serif" !important;
            }
        </style>
        <?php
        }
        ?>
    </head>
    <body>
        <div class="calendar-container">
            <?php getCalendar(); ?>
        </div>

        <div class="blackout">
        <div class="popup-box" id="change-day">
            <h2 class="box-top"></h2>
            <div class="close-box">x</div>
            <div class="box-content">
                <p class="tasks-in"></p>
                <div id="change-day-list">
                </div>
                <div class="box-add"><div class="add-task"></div>Добавить задачу</div>
                <form id="day-form">
                    <select name="status" id="status">
                        <option value="-1">Рабочий день</option>
                        <option value="1">День закончен</option>
                        <option value="0">Выходной</option>
                    </select>
                    <button type="submit">Обновить</button>
                </form>
            </div>
        </div>
        <div class="popup-box" id="add-task">
            <h2 class="box-top"></h2>
            <div class="close-box">x</div><div class="box-content">
                <form class="task-form">
                    <p>Название задачи <sup>*</sup></p>
                    <input type="text" name="title">
                    <p>Цвет задачи <sup>*</sup></p>
                    <select name="color">
                        <option value="yellow">Желтый 🐥</option>
                        <option value="orange">Оранжевый 🦊</option>
                        <option value="red">Красный 🍓</option>
                        <option value="blue">Синий 🦋</option>
                        <option value="sky">Голубой 🐬</option>
                        <option value="green">Зеленый 🐸</option>
                        <option value="sea">Морской 🌊</option>
                        <option value="purple">Фиолетовый 🔮</option>
                        <option value="pink">Розовый 🐷</option>
                        <option value="brown">Коричневый 🐻</option>
                    </select>
                    <p>Комментарий</p>
                    <textarea name="comment"></textarea>
                    <input type="hidden" name="date" id="add-task-date">
                    <button type="submit" class="form-button">Добавить</button>
                </form>
            </div>
        </div>
        </div>
    </body>
</html>
