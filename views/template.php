<!DOCTYPE html>
<html lang="ru">
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
                font-family: "EmojiOne Android";
                src: url("emojione-android.ttf") format("truetype");
                unicode-range: U+0080-02AF, U+0600-06FF, U+0C00-0C7F, U+1DC0-1DFF, U+1E00-1EFF, U+2000-209F, U+20D0-214F, U+2190-23FF, U+2460-25FF, U+2600-27EF, U+2900-29FF, U+2B00-2BFF, U+2C60-2C7F, U+2E00-2E7F, U+3000-303F, U+A490-A4CF, U+E000-F8FF, U+FE00-FE0F, U+FE30-FE4F, U+1F000-1F02F, U+1F0A0-1F0FF, U+1F100-1F64F, U+1F680-1F6FF, U+1F910-1F96B, U+1F980-1F9E0;
            }

            @font-face {
                font-family: "Noto Color Emoji";
                src: url("NotoColorEmoji.ttf") format("truetype");
                unicode-range: U+23F1;
            }

            .emoji {
                font-family: "Noto Color Emoji", "EmojiOne Android",  'Montserrat', sans-serif !important;
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
                    <div class="change-day-list">
                    </div>
                    <div class="box-add"><div class="add-task"></div>Добавить задачу</div>
                    <form class="day-form">
                        <select name="status" id="status">
                            <option value="-1">Рабочий день</option>
                            <option value="1">День закончен</option>
                            <option value="0">Выходной</option>
                        </select>
                        <button type="submit" class="form-button">Обновить</button>
                    </form>
                </div>
            </div>

            <div class="popup-box" id="add-task">
                <h2 class="box-top"></h2>
                <div class="close-box">x</div>
                <div class="box-content">
                    <form class="task-form">
                        <p>Название задачи <sup>*</sup></p>
                        <input type="text" name="title">
                        <p>Цвет задачи <sup>*</sup></p>
                        <select name="color" class="emoji">
                            <option value="yellow" class="emoji">Желтый 🐥</option>
                            <option value="orange" class="emoji">Оранжевый 🦊</option>
                            <option value="red" class="emoji">Красный 🍓</option>
                            <option value="blue" class="emoji">Синий 🦋</option>
                            <option value="sky" class="emoji">Голубой 🐬</option>
                            <option value="green" class="emoji">Зеленый 🐸</option>
                            <option value="sea" class="emoji">Морской 🌊</option>
                            <option value="purple" class="emoji">Фиолетовый 🔮</option>
                            <option value="pink" class="emoji">Розовый 🐷</option>
                            <option value="brown" class="emoji">Коричневый 🐻</option>
                        </select>
                        <p>Количество часов</p>
                        <input type="number" name="hours" step="any">
                        <input type="hidden" name="date" id="add-task-date">
                        <button type="submit" class="form-button">Добавить</button>
                    </form>
                </div>
            </div>

            <div class="popup-box" id="change-task">
                <h2 class="box-top"></h2>
                <div class="close-box">x</div>
                <div class="box-content">
                    <form class="change-form">
                        <p>Изменить название</p>
                        <input type="text" name="title">
                        <p>Изменить цвет</p>
                        <select name="color" class="emoji">
                            <option value="yellow" class="emoji">Желтый 🐥</option>
                            <option value="orange" class="emoji">Оранжевый 🦊</option>
                            <option value="red" class="emoji">Красный 🍓</option>
                            <option value="blue" class="emoji">Синий 🦋</option>
                            <option value="sky" class="emoji">Голубой 🐬</option>
                            <option value="green" class="emoji">Зеленый 🐸</option>
                            <option value="sea" class="emoji">Морской 🌊</option>
                            <option value="purple" class="emoji">Фиолетовый 🔮</option>
                            <option value="pink" class="emoji">Розовый 🐷</option>
                            <option value="brown" class="emoji">Коричневый 🐻</option>
                        </select>
                        <p>Изменить время</p>
                        <input type="number" step="any" name="hours">
                        <select name="status" class="emoji">
                            <option value="0" class="emoji">Задача в работе 👀</option>
                            <option value="1" class="emoji">Задача выполнена ✅</option>
                        </select>
                        <input type="hidden" name="id" id="task-id">
                        <div class="change-form-flex">
                            <button type="submit" class="change-button">Обновить</button>
                            <button type="button" class="delete-button">Удалить задачу</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="popup-box" id="color-description">
                <h2 class="box-top">Цвета задач</h2>
                <div class="close-box">x</div>
                <div class="box-content">
                    <section class="task yellow">Желтый</section>
                    <section class="task orange">Оранжевый</section>
                    <section class="task red">Красный</section>
                    <section class="task blue">Синий</section>
                    <section class="task green">Зеленый</section>
                    <section class="task sea">Морской</section>
                    <section class="task purple">Фиолетовый</section>
                    <section class="task pink">Розовый</section>
                    <section class="task brown">Коричневый</section>
                </div>
            </div>

        </div>
    </body>
</html>
