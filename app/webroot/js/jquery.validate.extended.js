$.validator.addMethod(
        "cellPhoneUS",
        function(value, element) {
            return this.optional(element) || /^[0-9]{3}[-\s.]{1}[0-9]{3}[-\s.]{1}[0-9]{4}$/.test(value);
        },
        "Phone number is not valid (Format: 123-123-1234)."
        );

$.validator.addMethod(
        "emailAddress",
        function(value, element) {
            var invalidChars = new Array(' ', '$', '%');
            var val = value.trim();

            for (i = 0; i < invalidChars.length; i++) {
                val = val.replace(invalidChars[i], '');
            }

            $(element).val(val);
            return this.optional(element) || /^\s*[\w\-\+_]+(\.[\w\-\+_]+)*\@[\w\-\+_]+\.[\w\-\+_]+(\.[\w\-\+_]+)*\s*$/.test(val);
            //return this.optional(element) || /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(val);   // Other option
        },
        "Phone number is not valid (Format: 123-123-1234)."
        );

$.validator.addMethod(
        "notFutureDate",
        function(value, element) {
            var today = new Date();
            var curDateStr = (today.getMonth() + 1) + '/' + today.getDate() + '/' + today.getFullYear();
            var selected = $.datepicker.parseDate(datePickerDateFormat, value);
            var curDate = $.datepicker.parseDate(datePickerDateFormat, curDateStr);
            return this.optional(element) || selected.getTime() <= curDate.getTime();
        },
        "You cannot select a future date."
        );

$.validator.addMethod(
        "notPastDate",
        function(value, element) {
            if (value.match(datePattern)) {
                var today = new Date();
                var curDateStr = (today.getMonth() + 1) + '/' + today.getDate() + '/' + today.getFullYear();
                var selected = $.datepicker.parseDate(datePickerDateFormat, value);
                var curDate = $.datepicker.parseDate(datePickerDateFormat, curDateStr);
                return this.optional(element) || selected.getTime() >= curDate.getTime();
            }
        },
        "You cannot select a past date."
        );

$.validator.addMethod(
        "notPastTime",
        function(value, element, params) {
            if ($('#' + params[0]).val().match(datePattern)) {
                var today = new Date();
                var timeStr = $('#' + params[0]).val() + ' ' + $('#' + params[1] + 'Hours').val() + ':' +
                        $('#' + params[1] + 'Minutes').val() + ' ' + $('#' + params[1] + 'AMPM').val();
                //var selected = Date.parse(timeStr);
                var selected = new Date(timeStr);
                return this.optional(element) || selected.getTime() >= today.getTime();
            }
        },
        "You cannot select a past time."
        );

$.validator.addMethod(
        "notBeforeTime",
        function(value, element, params) {
            var curDate = new Date().toString('MM/dd/yyyy');
            var comparatorStr = curDate + ' ' + $('#' + params[1] + 'Hours').val() + ':' +
                    $('#' + params[1] + 'Minutes').val() + ' ' + $('#' + params[1] + 'AMPM').val();
            //var comparator = Date.parse(comparatorStr);
            var comparator = new Date(comparatorStr);

            var selectedStr = curDate + ' ' + $('#' + params[0] + 'Hours').val() + ':' +
                    $('#' + params[0] + 'Minutes').val() + ' ' + $('#' + params[0] + 'AMPM').val();
            //var selected = Date.parse(selectedStr);
            var selected = new Date(selectedStr);
            return this.optional(element) || selected.getTime() >= comparator.getTime();
        },
        "Selected time cannot before the given time."
        );

function checkDoubleBook(curEvent) {
    var result = true;

    // Get stylist double book setting
    var doubleBook = true;
    for (i = 0; i < calStylistJSON.length; i++) {
        if (calStylistJSON[i].key == curEvent.stylist_id) {
            doubleBook = calStylistJSON[i].double_book;
            break;
        }
    }
    if (doubleBook == false) {
        $('#calendar').find('.dhx_cal_event').each(function() {
            var comparator = scheduler.getEvent($(this).attr('event_id'));
            if (curEvent.id != comparator.id && curEvent.stylist_id == comparator.stylist_id) {
                if (
                        (
                                (curEvent.start_date.getTime() >= comparator.start_date.getTime() && curEvent.start_date.getTime() < comparator.end_date.getTime()) ||
                                (curEvent.end_date.getTime() > comparator.start_date.getTime() && curEvent.end_date.getTime() <= comparator.end_date.getTime())
                                ) ||
                        (
                                (comparator.start_date.getTime() >= curEvent.start_date.getTime() && comparator.start_date.getTime() < curEvent.end_date.getTime()) ||
                                (comparator.end_date.getTime() > curEvent.start_date.getTime() && comparator.end_date.getTime() <= curEvent.end_date.getTime())
                                )
                        ) {
                    result = false;
                    return false; // Break   
                }
            }
        });
    } 
    
    return result;
}

function checkIsDoubleBook(curEvent) {
    var result = true;

    // Get stylist double book setting
    var doubleBook = true;
    for (i = 0; i < calStylistJSON.length; i++) {
        if (calStylistJSON[i].key == curEvent.stylist_id) {
            doubleBook = calStylistJSON[i].double_book;
            break;
        }
    }
    if (doubleBook == true) {
        var start = new Date(curEvent.start_date.getTime() + 1000);
        var end = (curEvent.end_date.getTime() - 1000);
        var events = scheduler.getEvents(start, end);
        if (events.length > 2) {
            result = false;
            return false; // Break   
        }
    }
    
    return result;
}

$.validator.addMethod(
        "checkIsDoubleBook",
        function(value, element, params) {
            var curEvent = scheduler.getEvent(scheduler.getState().lightbox_id);

            return this.optional(element) || checkIsDoubleBook(curEvent);
        },
        "Cannot set more double booking for this stylist."
        );

$.validator.addMethod(
        "checkDoubleBook",
        function(value, element, params) {
            var curEvent = scheduler.getEvent(scheduler.getState().lightbox_id);

            return this.optional(element) || checkDoubleBook(curEvent);
        },
        "This stylist does not offer double book."
        );

$.validator.addMethod(
        "match",
        function(value, element, pattern) {
            return this.optional(element) || value.match(pattern);
        },
        "Selected value is not matched the given pattern."
        );

$.validator.addMethod(
        "remoteCheck",
        function(value, element, field) {
            var pass = 'true';

            if (field == 'email' || field == 'username') {
                $.ajax({
                    url: webroot + 'users/ajaxCheckExistence',
                    type: "post",
                    async: false,
                    data: {
                        'field': field,
                        'value': value
                    },
                    success: function(response) {
                        pass = response;
                    }
                });
            } else if (field == 'stylist_id') {
                $.ajax({
                    url: webroot + 'stylists/ajaxCheckExistence',
                    type: "post",
                    async: false,
                    data: {
                        'value': value
                    },
                    success: function(response) {
                        pass = response;
                    }
                });
            }

            return this.optional(element) || pass == 'true';
        },
        "Selected value is exist in the system."
        );