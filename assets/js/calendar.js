$(function () {
    var base_url = 'http://localhost/server/payroll/';
    $('#calendar').fullCalendar({
        themeSystem: 'bootstrap4',
        displayEventTime: false,
        timeFormat: 'H(:mm)',
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay,listMonth'
        },
        weekNumbers: false,
        eventLimit: true, // allow "more" link when too many events
        //events: 'https://localhost:44361/Events/getEvents'
//      events: 'http://morolongkj-001-site1.dtempurl.com/Events/getEvents'
        eventSources: [
            {
                events: function (start, end, timezone, callback) {
                    $.ajax({
                        url: base_url + 'events/get_json_events',
                        dataType: 'json',
                        data: {
                            // our hypothetical feed requires UNIX timestamps
                            start: start.unix(),
                            end: end.unix()
                        },
                        success: function (msg) {
                            var events = msg.events;
                            callback(events);
                        }
                    });
                },
                color: '#0d47a1',
                textColor: '#ffffff'
            },
            {
                events: [{
                        id: 1,
                        title: "Power Hour",
                        start: '17:30',
                        end: '18:30',
                        dow: [3]
//                        excludedDate: new Date('2019/8/29') //Exclude the august 29th from concurrent event
                    }
                ],
                color: '#df902a',
                textColor: '#ffffff'
            },
            {
                events: [{
                        id: 1,
                        title: "English Service",
                        start: '08:30',
                        end: '10:00',
                        dow: [0]
//                        excludedDate: new Date('2019/8/29') //Exclude the august 29th from concurrent event
                    }
                ],
                color: 'green',
                textColor: '#ffffff'
            },
            {
                events: [{
                        id: 1,
                        title: "Sunday Service",
                        start: '10:30',
                        end: '13:30',
                        dow: [0]
//                        excludedDate: new Date('2019/8/29') //Exclude the august 29th from concurrent event
                    }
                ],
                color: '#f44336',
                textColor: '#ffffff'
            }
        ]

    });

});