function getCalendar(target, month, year) {
    $.ajax({
        type: 'POST',
        url: 'functions.php',
        data: 'function=getCalendar&month='+month+'&year='+year,
        success:function (html) {
            clear()
            $('.'+target).html(html)
            onLoad()
        }
    });
}

function getTasks(date) {
    $.ajax({
        type: 'POST',
        url: 'functions.php',
        data: 'function=getTasks&date='+date,
        success:function (html) {
            $('#task-list').html(html);
        }
    });
}

function moveTask(id, date) {
    $.ajax({
        type: 'POST',
        url: 'functions.php',
        data: 'function=moveTask&date='+date+'&id='+id
    });
}

function addTask() {
    $('.task-form').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'add-task.php',
            data: $('.task-form').serialize(),
            beforeSend: function () {
                $('.form-button').addClass('animate').append('<div class="loader"></div>');
            },
            success: function (html) {
                $('.loader').remove();
                $('.form-button').removeClass('animate');
                $('.box-content').append('<p>Добавлено!</p>');
                clear();
                getCalendar('calendar-container', $('.month-select').val(), $('.year-select').val());
                onLoad();
            }
        })
    });
}

function formatDate(date) {
    let monthArray = new Array('января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря');

    let formatDate = new Date(date);
    let day = formatDate.getDate();
    let month = monthArray[formatDate.getMonth()];

    let result = day + ' ' + month;

    return result;
}

function getChangeDayContent() {
    let content = '<div class="box-content"><p>Список задач, изменить задачу, добавить, выходной/зак день</p></div>';
    return content;
}

function getAddTaskContent(date) {
    let boxOpen = '<div class="box-content">';
    let options = '<option value="yellow">Желтый 🐥</option>' +
        '<option value="orange">Оранжевый 🦊</option>' +
        '<option value="red">Красный 🍓</option>' +
        '<option value="blue">Синий 🦋</option>' +
        '<option value="sky">Голубой 🐬</option>' +
        '<option value="green">Зеленый 🐸</option>' +
        '<option value="sea">Морской 🌊</option>' +
        '<option value="purple">Фиолетовый 🔮</option>' +
        '<option value="pink">Розовый 🐷</option>' +
        '<option value="brown">Коричневый 🐻</option>';
    let form = '<form class="task-form">' +
        '<p>Название задачи <sup>*</sup></p>' +
        '<input type="text" name="title">' +
        '<p>Цвет задачи <sup>*</sup></p>' +
        '<select name="color">' + options + '</select>' +
        '<p>Комментарий</p>' +
        '<textarea name="comment"></textarea>' +
        '<input type="hidden" name="date" value="' + date + '">' +
        '<button type="submit" class="form-button">Добавить</button>' +
        '</form>';
    let boxClose = '</div>';

    let content = boxOpen + form + boxClose;
    return content;
}

function popupAnimate() {
    $('.popup-box').fadeIn();
    $('.blackout').fadeIn();

    $('.close-box').click(function() {
        $('.popup-box').fadeOut();
        $('.blackout').fadeOut();
        $('.blackout').remove();
    });
}

function clear() {
    $('.calendar-container').off();
    $('.calendar-container').off();

    $('.day').off();
    $('.task').off();
}

function onLoad() {
    $('.calendar-container').on('change', '.month-select', function () {
        getCalendar('calendar-container', $('.month-select').val(), $('.year-select').val());
    });
    $('.calendar-container').on('change', '.year-select', function () {
        getCalendar('calendar-container', $('.month-select').val(), $('.year-select').val());
    });

    $('.day-button').click(function () {
        $(document.body).append('<div class="blackout"></div>');
        $('.blackout').append('<div class="popup-box" id="change-day"></div>');

        let date = $(this).parent().attr('data-date');
        let heading = '<h2 class="box-top">Изменить задачи ' + formatDate(date) + '</h2>';
        let close = '<div class="close-box">x</div>';

        $('#change-day').append(heading + close + getChangeDayContent());

        popupAnimate();
    });

    $('.add-task').click(function () {
        $(document.body).append('<div class="blackout"></div>');
        $('.blackout').append('<div class="popup-box" id="add-task"></div>');

        let date = $(this).parent().attr('data-date');
        let heading = '<h2 class="box-top">Добавить задачу на ' + formatDate(date) + '</h2>';
        let close = '<div class="close-box">x</div>';

        $('#add-task').append(heading + close + getAddTaskContent(date));

        addTask();

        popupAnimate();
    });

    $('.task').draggable({
        containment: '.calendar',
        appendTo: 'body',
        cursor: 'move',
        helper: 'clone',
        scroll: false,
        revert: 'valid',
        revertDuration: 0,
    });
    $('.task-group').droppable({
        accept: '.task',
        over: function (event, ui) {
            $(this).addClass('drop-hover'); },
        out: function (event, ui) {
            $(this).removeClass('drop-hover'); },
        drop: function (event, ui) {
            $(this).append(ui.draggable);
            $(this).removeClass('drop-hover');
            let taskId = ui.draggable.attr('id');
            let date = $(this).parent().attr('data-date');
            moveTask(taskId, date);
        }
    });

    let month = $('.month-select option:selected').attr('value');
    let selectBox = $('.month-select');
    let body = $(document.body);

    if (month == '01') {
        selectBox.css('width', '90px');
        body.css('background-image', 'url(img/months/january.jpg)');
    } else if (month == '02') {
        selectBox.css('width', '110px');
        body.css('background-image', 'url(img/months/february.jpg)');
    } else if (month == '03') {
        selectBox.css('width', '70px');
        body.css('background-image', 'url(img/months/march.jpg)');
    } else if (month == '04') {
        selectBox.css('width', '90px');
        body.css('background-image', 'url(img/months/april.jpg)');
    } else if (month == '05') {
        selectBox.css('width', '60px');
        body.css('background-image', 'url(img/months/may.jpg)');
    } else if (month == '06') {
        selectBox.css('width', '70px');
        body.css('background-image', 'url(img/months/june.jpg)');
    } else if (month == '07') {
        selectBox.css('width', '70px');
        body.css('background-image', 'url(img/months/july.jpg)');
    } else if (month == '08') {
        selectBox.css('width', '80px');
        body.css('background-image', 'url(img/months/august.jpg)');
    } else if (month == '09') {
        selectBox.css('width', '110px');
        body.css('background-image', 'url(img/months/september.jpg)');
    } else if (month == '10') {
        selectBox.css('width', '100px')
        body.css('background-image', 'url(img/months/october.jpg)');
    } else if (month == '11') {
        selectBox.css('width', '90px');
        body.css('background-image', 'url(img/months/november.jpg)');
    } else if (month == '12') {
        selectBox.css('width', '100px')
        body.css('background-image', 'url(img/months/december.jpg)');
    }
}

$(document).ready(function () {
    onLoad()
})
