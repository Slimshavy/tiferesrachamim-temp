var timeFormDate = function (date, addMinutes) {

    var numericAddMinutes = (typeof addMinutes !== 'undefined' ? addMinutes : 0);
    var hour = date.getHours();
    var minute = date.getMinutes() + numericAddMinutes;
    var ampm = 'am';

    if (minute > 59) {
        hour = hour + Math.floor(minute / 60);
        minute = minute % 60;
    }

    if (hour > 12) {
        ampm = 'pm';
        hour = hour - 12;
    }
    else if (hour == 12) {
        ampm = 'pm';
    }
    else if (hour == 0) {
        hour = 12;
    }

    return '' + hour + ':' + minute + ' ' + ampm;
}


$(document).ready(function () {
    $.get("http://www.hebcal.com/shabbat/?cfg=json&zip=11213&m=50&a=on", function (data) {

        var items = data.items;
        var candleLighting = '';
        var maariv = '';
        var shabbosEnd = '';
        var parsha = '';

        for (var index in items) {

            if (items[index].category == 'parashat') {
                parsha = items[index].title;
            }
            else if (items[index].category == 'candles') {
                candleLighting = timeFormDate(new Date(items[index].date));
                maariv = timeFormDate(new Date(items[index].date), 45);
            }
            else if (items[index].category == 'havdalah') {
                shabbosEnd = timeFormDate(new Date(items[index].date));
            }
        }

        $("#zmanim-header").text("Zmanim for Shabbos " + parsha);
        $(".candle-lighting").text(candleLighting);
        $(".shul-maariv").text(maariv);
        $(".shul-shachris").text("10:30 am");
        $(".shabbos-ends").text(shabbosEnd);
    });

    var saturday = new Date();
    saturday.setDate(saturday.getDate() + 6 - saturday.getDay());
    var satudrayFormatted = '' + saturday.getFullYear() + '-' + (saturday.getMonth() + 1) + '-' + saturday.getDate();
    var url = 'http://api.sunrise-sunset.org/json?lat=40.650002&lng=-73.949997&date=' + satudrayFormatted + '&formatted=0';

    $.get(url, function (data) {

        if (data.status === "OK") {

            var sunrise = new Date(data.results.sunrise);
            var sunset = new Date(data.results.sunset);
            var dayLength = data.results.day_length;
            var shaahZmanitInMinutes = dayLength / 12 / 60;
            var earliestMincha = timeFormDate(sunrise, Math.ceil(6.5 * shaahZmanitInMinutes));

            $(".shabbos-earliest-mincha").text(earliestMincha);
            $(".shabbos-shkiah").text(timeFormDate(sunset));
        }
    });
});

