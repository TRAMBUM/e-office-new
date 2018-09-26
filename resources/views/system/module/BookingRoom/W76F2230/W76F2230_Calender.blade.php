<div id='calendar'></div>

<script type="text/javascript">
    var viewmodeW76F4050 = "";
    var btnClickDel = false;
    $(document).ready(function () {
        var rooms =
                {!! $meetingRoomList !!}
        var events = [
                {
                    url: '{{url('w76f2230/loadCalendar')}}',
                    cache: false,
                    method: 'post',
                    data: function () { // a function that returns an object
                        return {
                            dynamic_value: Math.random(),
                        };
                    }
                }
            ];
        var events = {!! $newsCollection !!};
        $('#calendar').fullCalendar({
            //disableDragging: true,
            selectOverlap: false,
            eventOverlap: false,
            //editable: false,
            title: "HELLO BUM",
            defaultView: 'timeline',
            defaultDate: '2018-09-17',
            editable: true,
            //contentHeight: 'auto',
            duration: {days: 1},
            slotLabelFormat: "HH:mm",
            buttonText: {
                today: 'Today',
                month: 'Month',
                week: 'Week',
                day: 'Day',
                list: 'List'
            },
            eventLimit: false,
            dayOfMonthFormat: 'ddd DD/MM',
            theme: true,
            //minTime: '07:00',
            //maxTime: '10:30',
            header: {
                left: 'prev,next',
                center: 'title',
                right: 'timelineDay'
            },
            height: 450,
            resourceLabelText: 'Danh sách phòng hợp',
            resources: rooms,
            events: events,
            selectable: true,
            selectHelper: true,
            select: function (start, end, jsEvent, view, resource) {
                var event = {
                    start: start,
                    end: end
                };
                var momentStart = moment(event.start.format("HH:mm"));
                var momentEnd = moment(event.start.format("HH:mm"));

                var start = event.start.format("HH:mm");
                var end = event.end.format("HH:mm");
                var roomID = resource.id;
                var date = event.start.format("DD/MM/YYYY");
                console.log(momentStart);

                var data = {
                    start: start,
                    end: end,
                    roomID: roomID,
                    date: date,
                    _token: '{{ csrf_token() }}'
                }
                showFormDialogPost("{{url('/w76f2231/add')}}", 'myModal', data);
                $('#calendar').fullCalendar('renderEvent', event, true); // stick? = true
                $('#calendar').fullCalendar('unselect');
            },
            eventClick: function (calEvent, resource) {
                if (!btnClickDel) {
                    var start = calEvent.start.format("HH:mm");
                    var end = calEvent.end.format("HH:mm");
                    var roomID = calEvent.id;
                    var date = calEvent.start.format("DD/MM/YYYY");
                    //console.log(roomID);
                    var data = {
                        start: start,
                        end: end,
                        roomID: roomID,
                        ID: calEvent.ID,
                        date: date,
                        _token: '{{ csrf_token() }}'
                    }
                    showFormDialogPost("{{url('/w76f2231/edit')}}", 'myModal', data);
                    $('#calendar').fullCalendar('renderEvent', event, true); // stick? = true
                    $('#calendar').fullCalendar('unselect');
                }
            },
            eventDrag: function (event) {
                //event.preventDefault();
            },
            eventDrop: function (event) {
                console.log("HELLO BUM");
                //Điều chỉnh booking drag & drop
                var timefrom = event.start.format("HH:mm");
                var timeto = event.end.format("HH:mm");
                var date = event.start.format("DD/MM/YYYY");

                var data = {
                    start: timefrom,
                    end: timeto,
                    date: date,
                    roomID: event.resourceId,
                    ID: event.ID,
                    _token: '{{ csrf_token() }}'
                }
                hideAlert();
                postMethod("{{url('/w76f2231/updatedrag')}}", function (res) {
                    var result = JSON.parse(res);
                    console.log("luu");
                    switch (result.status) {
                        case 'ERROR':
                            alertError(result.message, $("#modalW76F2231"))
                            break;
                        case 'EXIST':
                            alertError(result.message, $("#modalW76F2231"))
                            break;
                        case 'SUCC':
                            alertSuccess("Dữ liệu đã được lưu thành công.")
                            window.location.reload();
                            break;
                    }
                }, data)
            },
            eventRender: function (event, element) {
                element.append('<span class="pull-right spanDelW76F2230"><a id="deleteW76F2230" title="{{Helpers::getRS("Xoa")}}"><i class="fas fa-trash-alt text-danger cursor-pointer"></i></a></span>');
                element.find("#deleteW76F2230").on("click", function (event) {
                    console.log(btnClickDel);
                    btnClickDel = true;
                    ask_delete(function () {
                        $.ajax({
                            method: "POST",
                            url: '{{url('/w76f2230/delete')}}',
                            data: {ID: event.ID, _token: '{{ csrf_token() }}'},
                            success: function (res) {
                                var data = JSON.parse(res);
                                switch (data.status) {
                                    case "SUCC":
                                        var $calender = $("#calendar");
                                        delete_ok(function () {
                                            update4ParamGrid($calender, null, 'delete');
                                        });
                                        break;
                                    case "ERROR":
                                        alertError(data.message);
                                        break;
                                }
                            }
                        })
                    });
//                    $('#calendar').fullCalendar('removeEvents', event._roomID);
                });
            },
            eventMouseover: function (data, event, events, view) {
                btnClickDel = false;
                tooltip = '<div class="tooltiptopicevent" style="width:auto;height:auto;background:#ECE0BB;position:absolute;z-index:10001;' +
                    'padding:5px 5px 5px 5px ;  line-height: 200%;">Title: ' + data.title + '</br>Time: ' + moment(data.start).format('HH:mm') + '</div>';
                $("body").append(tooltip);
                $(this).mouseover(function (e) {
                    $(this).css('z-index', 10000);
                    $('.tooltiptopicevent').fadeIn('500');
                    $('.tooltiptopicevent').fadeTo('10', 1.9);
                }).mousemove(function (e) {
                    $('.tooltiptopicevent').css('top', e.pageY + 10);
                    $('.tooltiptopicevent').css('left', e.pageX + 20);
                });
            },
            eventMouseout: function (data, event, view) {
                $(this).css('z-index', 8);
                $('.tooltiptopicevent').remove();
            },
            resourceRender: function (resourceObj, $td) {
                console.log(resourceObj);
                $td.eq(0).find('.fc-cell-content').popover({ //
                    placement: 'left',
                    title: resourceObj.title,
                    content: resourceObj.display,
                    trigger: 'hover',
                    container: "body",
                });
                $td.eq(0).find('.fc-cell-content').on('shown.bs.popover', function () {
                    var pop = $(this).attr('aria-describedby');
                    var left = $('#' + pop).offset().left;
                    var width = $('#' + pop).width();
                    $('#' + pop).offset({left: left + width + 15});
                    //console.log($('#'+pop).offset().left);
                });
            }
        });

    });
</script>