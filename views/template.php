<!DOCTYPE html>
<html>
    <head>
        <title>Календарь задач</title>
        <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
        <link rel="icon" type="image/png" href="img/calendar.png">
        <link rel="stylesheet" href="style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
        <script src="scripts.js"></script>
    </head>
    <body>
        <div class="calendar-container">
            <?php getCalendar(); ?>
        </div>
    </body>
</html>
