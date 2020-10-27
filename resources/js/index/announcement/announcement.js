import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';

document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new Calendar(calendarEl, {
        plugins: [ dayGridPlugin, timeGridPlugin, listPlugin ],
        initialDate: '2020-10-07',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        // customButtons: {
        //     addRoom: {
        //         text: 'Add room',
        //     },
        //     addReservation: {
        //         text: 'Add reservation',
        //     },
        // },
        events: [
            {
                title: 'τεστ ',
                start: '2020-10-27',
            },
            {
                title: 'τεστ2 ',
                start: '2020-10-10',
            },
            {
                title: 'τεστ3 ',
                start: '2020-10-05',
            },
            ]
    });





    calendar.render();
});

