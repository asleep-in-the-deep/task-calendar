function getCalendar(target, month, year) {
    $.ajax({
        type: 'POST',
        url: 'functions.php',
        data: 'function=getCalendar&month='+month+'&year='+year,
        success:function (html) {
            clear();
            $('.'+target).html(html);
            onLoad();
        }
    });
}

function moveTask(id, date) {
    $.ajax({
        type: 'POST',
        url: 'functions.php',
        data: 'function=moveTask&id='+id+'&date='+date,
        success:function (html) {
            clear();
            getCalendar('calendar-container', $('.month-select').val(), $('.year-select').val());
            onLoad();
        }
    });
}

function addTask() {
    $('.task-form').off();
    $('.task-form').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'functions.php?function=createTask',
            data: $('.task-form').serialize(),
            beforeSend: function () {
                $('.form-button').addClass('animate').append('<div class="loader"></div>');
            },
            success: function () {
                $('.loader').remove();
                $('.form-button').removeClass('animate');
                $('#add-task .box-content').append('<p class="answer">Добавлено!</p>');
                clear();
                getCalendar('calendar-container', $('.month-select').val(), $('.year-select').val());
                onLoad();
            }
        })
    });
}

function loadTasks(date) {
    $.ajax({
        type: 'POST',
        url: 'functions.php',
        data: 'function=loadTasks&date='+date,
        success: function (html) {
            $('.change-day-list').html(html);
        }
    });
}

function setStatusDay(date) {
    $('.day-form').off();
    $('.day-form').submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'functions.php?function=setStatusDay',
            data: {
                'date': date,
                'status': $('.day-form > #status').val()
            },
            success: function () {
                $('#change-day .box-content').append('<p class="answer">День изменен!</p>');
                let status = $('.day-form > #status').val();
                let day = $('.day[data-date="' + date + '"]');
                if (status == 0) {
                    day.addClass('disabled');
                } else if (status == 1) {
                    day.append('<div class="finished"></div>');
                } else if (status == -1) {
                    day.removeClass('disabled');
                    $('.day[data-date="' + date + '"] .finished').remove();
                }
            }
        })
    });
}

function changeTask() {
    $('.change-form').off();
    $('.change-form').submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'functions.php?function=changeTask',
            data: $('.change-form').serialize(),
            beforeSend: function () {
                $('.change-button').addClass('animate').append('<div class="loader"></div>');
            },
            success: function () {
                $('.loader').remove();
                $('.change-button').removeClass('animate');
                $('#change-task .box-content').append('<p class="answer">Задача изменена!</p>');
                clear();
                getCalendar('calendar-container', $('.month-select').val(), $('.year-select').val());
                onLoad();
            }
        })
    });
}

function deleteTask() {
    $('.delete-button').off();
    $('.delete-button').click(function (e) {
       e.preventDefault();
       $.ajax({
           type: 'POST',
           url: 'functions.php?function=deleteTask',
           data: $('.change-form').serialize(),
           success: function () {
               $('#change-task .box-content').append('<p class="answer">Задача удалена!</p>');
               clear();
               getCalendar('calendar-container', $('.month-select').val(), $('.year-select').val());
               onLoad();
               setTimeout(function() {
                       $('#change-task').fadeOut();
                       $('.blackout').fadeOut();
                   }, 2000);
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

function HandleAddTask(current, returnTo = null) {
    let date = $(current).parent().attr('data-date');
    $("#add-task > .box-top").html('Добавить задачу на ' + formatDate(date));
    $("#add-task-date").val(date);

    addTask();

    $('#change-day').css("display", "none");
    popupAnimate('#add-task', returnTo);
}

function HandleChangeTask(current) {
    $("#change-task > .box-top").html('Изменить задачу');

    let id = $(current).parent().attr('id');
    let title = $(current).prev('span').text();
    let color = $(current).parent().attr('class').split(' ')[1];
    let hours = $(current).parent().attr('data-hours');

    $('#change-task input[name=title]').val(title);
    $('#change-task select[name=color]').val(color).change();
    $('#change-task input[name=hours]').val(hours);
    if ($(current).parent().attr('class').split(' ')[1] == 'done') {
        $('#change-task select[name=status]').val('1');
    } else {
        $('#change-task select[name=status]').val('0');
    }
    $('#task-id').val(id.split('_')[1]);

    changeTask();
    deleteTask();

    let returnTo = '#change-day';
    $('#change-day').css("display", "none");
    popupAnimate('#change-task', returnTo);
}

function popupAnimate(popup, returnTo = null) {
    $(popup).fadeIn();
    $('.blackout').fadeIn();

    $('.close-box').off();

    $('.close-box').click(function() {
        $('.answer').remove();
        $('.task-form')[0].reset();
        if (returnTo === null) {
            $(popup).fadeOut();
            $('.blackout').fadeOut();
        } else {
            $(popup).css("display", "none");
            let date = $(returnTo + ' .box-content').attr('data-date');
            loadTasks(date);
            $(returnTo).fadeIn();
            popupAnimate(returnTo);
        }
    });
}

function onLoad() {
    $('.calendar-container').on('change', '.month-select', function () {
        getCalendar('calendar-container', $('.month-select').val(), $('.year-select').val());
    });
    $('.calendar-container').on('change', '.year-select', function () {
        getCalendar('calendar-container', $('.month-select').val(), $('.year-select').val());
    });

    $('.day-button').click(function () {
        let date = $(this).parent().attr('data-date');
        $('#change-day > .box-top').html('Изменить задачи на ' + formatDate(date));
        $('#change-day > .box-content').attr('data-date', date);

        $('.box-add').click(function () {
            HandleAddTask(this,'#change-day');
        });

        setStatusDay(date);

        popupAnimate('#change-day');
        loadTasks(date);
    });

    $('.day > .add-task').click(function () {
        HandleAddTask(this);
    });

    $(document).on('click','.task > .edit-task', function(){
        HandleChangeTask(this);
    });

    $('.color-desc').click(function () {
        popupAnimate('#color-description');
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
            let taskId = ui.draggable.attr('id').split('_')[1];
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

function clear() {
    $('.calendar-container').off();
    $('.form-button').off();

    $('#change-task input[type=checkbox]').prop('checked', false);

    $('.day').off();
    $('.task').off();
}

$(document).ready(function () {
    onLoad();
});
