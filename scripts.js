function getCalendar(target, month, year) {
    $.ajax({
        type: 'POST',
        url: 'functions.php',
        data: 'function=getCalendar&month='+month+'&year='+year,
        success:function (html) {
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

function onLoad() {
    $('.calendar-container').on('change', '.month-select', function () {
        getCalendar('calendar-container', $('.month-select').val(), $('.year-select').val());
    });
    $('.calendar-container').on('change', '.year-select', function () {
        getCalendar('calendar-container', $('.month-select').val(), $('.year-select').val());
    });

    $('.day-button').click(function () {
        $('#change-day').fadeIn();
        $('.blackout').fadeIn();
    });
    $('.close-box').click(function() {
        $('#change-day').fadeOut();
        $('.blackout').fadeOut();
    });

    $('.add-task').click(function () {
        $('#add-task').fadeIn();
        $('.blackout').fadeIn();
    });
    $('.close-box').click(function() {
        $('#add-task').fadeOut();
        $('.blackout').fadeOut();
    });

    $('.day').sortable();
    $('.task').draggable({
        containment: '.calendar',
        helper: 'clone',
        appendTo: '.calendar',
        scroll: false,
        revert: true,
        cursor: "move",
        revertDuration: 0});
    $('.day').droppable({
        accept: '.task',
        over: function (event, ui) {
            $(this).addClass('hover');
        },
        out: function (event, ui) {
            $(this).removeClass('hover');
        },
        drop: function (event, ui) {
            $(this).children('.task-list').prepend(ui.draggable);
            $(this).removeClass('hover');
            let parts = ui.draggable.prop('id').split("_");
            if (parts[0] == "task") {
                let x = $(this).prop('id').split("_");
                if (x[0] == "day") {
                    moveTask(parts[1], x[1]);
                }
            }
        }
    });
}

$(document).ready(function () {
    onLoad()
})