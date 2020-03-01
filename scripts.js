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

function loadTasks(date) {
    $.ajax({
        type: 'POST',
        url: 'functions.php',
        data: 'function=loadTasks&date='+date,
        success:function (html) {
            $('#change-day-list').html(html);
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
    $('.task-form').off()
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

function setStatusDay(date) {
    $('#day-form').off()
    $('#day-form').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'functions.php?function=setStatusDay',
            data: {'date': date, 'status': $("#day-form > #status").val()}, // использовать $('#day-form').serialize() ?
            success: function (html) {
                let status = $("#day-form > #status").val()
                let day_block = $("#day_"+date)
                if (status == 0) {
                    day_block.addClass("disabled")
                } else if (status == 1) {
                    day_block.children(".task-group").append('<div class="finished"></div>');
                } else if (status == -1) {
                    day_block.removeClass("disabled")
                    $("#day_" + date + " > .task-group > .finished").remove()
                }
            }
        })
    })
}

function formatDate(date) {
    let monthArray = new Array('января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря');

    let formatDate = new Date(date);
    let day = formatDate.getDate();
    let month = monthArray[formatDate.getMonth()];

    let result = day + ' ' + month;

    return result;
}

function popupAnimate(popup) {
    $(popup).fadeIn()
    $('.blackout').fadeIn()

    $('.close-box').click(function() {
        $(popup).fadeOut()
        $('.blackout').fadeOut()
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
        let date = $(this).parent().attr('data-date')
        $("#change-day > .box-top").html('Изменить задачи ' + formatDate(date))
        $(".tasks-in").html('Задачи на ' + formatDate(date))

        setStatusDay(date);

        popupAnimate('#change-day')
        loadTasks(date)
    });

    $('.add-task').click(function () {
        let date = $(this).parent().attr('data-date')
        $("#add-task > .box-top").html('Добавить задачу на ' + formatDate(date))

        addTask()

        popupAnimate('#add-task')
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
            let taskElementId = ui.draggable.attr('id');
            let date = $(this).parent().attr('data-date');
            let parts = taskElementId.split("_");
            if (parts[0] == "task") {
                let taskId = parts[1];
                moveTask(taskId, date);
            }
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
