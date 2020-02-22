function getCalendar(target, month, year) {
    $.ajax({
        type: 'POST',
        url: 'functions.php',
        data: 'function=getCalendar&month='+month+'&year='+year,
        success:function (html) {
            $('.'+target).html(html);
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

$(document).ready(function(){
    $('.calendar-container').on('change', '.month-select', function () {
        getCalendar('calendar-container', $('.month-select').val(), $('.year-select').val());
    });
    $('.calendar-container').on('change', '.year-select', function () {
        getCalendar('calendar-container', $('.month-select').val(), $('.year-select').val());
    });
});

$(document).ready(function () {
    $('.day-button').click(function () {
        $('#change-day').fadeIn();
        $('.blackout').fadeIn();
    });
    $('.close-box').click(function() {
        $('#change-day').fadeOut();
        $('.blackout').fadeOut();
    });
});

$(document).ready(function () {
    $('.add-task').click(function () {
        $('#add-task').fadeIn();
        $('.blackout').fadeIn();
    });
    $('.close-box').click(function() {
        $('#add-task').fadeOut();
        $('.blackout').fadeOut();
    });
});

$(document).ready(function () {
    $('.day').sortable();
    $('.task').draggable({
        containment: '.calendar',
        scroll: false,
        revert: true,
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
            $(this).append(ui.draggable);
            $(this).removeClass('hover');
        }
    });
})