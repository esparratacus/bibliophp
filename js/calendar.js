$(function() {
    $('#calendar').fullCalendar({
        weekends: false,
        defaultView: 'agendaWeek',
        header: {
            left: 'month,agendaWeek,agendaDay'
        },
        events: calendarData,
    });
});