<!DOCTYPE html>
<html lang="en">

<head>
    <title>Coming Soon 4</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/png" href="{{ asset('landing') }}/images/icons/favicon.ico" />

    <link rel="stylesheet" type="text/css" href="{{ asset('landing') }}/vendor/bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css"
        href="{{ asset('landing') }}/fonts/font-awesome-4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" type="text/css"
        href="{{ asset('landing') }}/fonts/iconic/css/material-design-iconic-font.min.css">

    <link rel="stylesheet" type="text/css" href="{{ asset('landing') }}/vendor/animate/animate.css">

    <link rel="stylesheet" type="text/css" href="{{ asset('landing') }}/vendor/select2/select2.min.css">

    <link rel="stylesheet" type="text/css" href="{{ asset('landing') }}/css/util.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('landing') }}/css/main.css">

    <meta name="robots" content="noindex, follow">
    <script nonce="0352cc18-30e0-4515-b928-af5d6c70b3f7">
        (function(w, d) {
            ! function(a, e, t, r) {
                a.zarazData = a.zarazData || {}, a.zarazData.executed = [], a.zaraz = {
                    deferred: []
                }, a.zaraz.q = [], a.zaraz._f = function(e) {
                    return function() {
                        var t = Array.prototype.slice.call(arguments);
                        a.zaraz.q.push({
                            m: e,
                            a: t
                        })
                    }
                };
                for (const e of ["track", "set", "ecommerce", "debug"]) a.zaraz[e] = a.zaraz._f(e);
                a.addEventListener("DOMContentLoaded", (() => {
                    var t = e.getElementsByTagName(r)[0],
                        z = e.createElement(r),
                        n = e.getElementsByTagName("title")[0];
                    for (n && (a.zarazData.t = e.getElementsByTagName("title")[0].text), a.zarazData.x =
                        Math.random(), a.zarazData.w = a.screen.width, a.zarazData.h = a.screen.height, a
                        .zarazData.j = a.innerHeight, a.zarazData.e = a.innerWidth, a.zarazData.l = a
                        .location.href, a.zarazData.r = e.referrer, a.zarazData.k = a.screen.colorDepth, a
                        .zarazData.n = e.characterSet, a.zarazData.o = (new Date).getTimezoneOffset(), a
                        .zarazData.q = []; a.zaraz.q.length;) {
                        const e = a.zaraz.q.shift();
                        a.zarazData.q.push(e)
                    }
                    z.defer = !0;
                    for (const e of [localStorage, sessionStorage]) Object.keys(e).filter((a => a
                        .startsWith("_zaraz_"))).forEach((t => a.zarazData["z_" + t.slice(7)] = JSON
                        .parse(e.getItem(t))));
                    z.referrerPolicy = "origin", z.src = "../../../cdn-cgi/zaraz/sd0d9.js?z=" + btoa(
                        encodeURIComponent(JSON.stringify(a.zarazData))), t.parentNode.insertBefore(z,
                        t)
                }))
            }(w, d, 0, "script");
        })(window, document);
    </script>
</head>

<body>
    <div class="bg-g1 size1 flex-w flex-col-c-sb p-l-15 p-r-15 p-t-55 p-b-35 respon1">
        <span></span>
        <div class="flex-col-c p-t-50 p-b-50">
            <h3 class="l1-txt1 txt-center p-b-10">
                Your Screen Recording Has Been Started.
            </h3>

        </div>

        <script src="{{ asset('landing') }}/vendor/jquery/jquery-3.2.1.min.js"></script>

        <script src="{{ asset('landing') }}/vendor/bootstrap/js/popper.js"></script>
        <script src="{{ asset('landing') }}/vendor/bootstrap/js/bootstrap.min.js"></script>

        <script src="{{ asset('landing') }}/vendor/select2/select2.min.js"></script>

        <script src="{{ asset('landing') }}/vendor/countdowntime/moment.min.js"></script>
        <script src="{{ asset('landing') }}/vendor/countdowntime/moment-timezone.min.js"></script>
        <script src="{{ asset('landing') }}/vendor/countdowntime/moment-timezone-with-data.min.js"></script>
        <script src="{{ asset('landing') }}/vendor/countdowntime/countdowntime.js"></script>
        <script>
            $('.cd100').countdown100({
                // Set Endtime here
                // Endtime must be > current time
                endtimeYear: 0,
                endtimeMonth: 0,
                endtimeDate: 35,
                endtimeHours: 18,
                endtimeMinutes: 0,
                endtimeSeconds: 0,
                timeZone: ""
                // ex:  timeZone: "America/New_York", can be empty
                // go to " http://momentjs.com/timezone/ " to get timezone
            });
        </script>

        <script src="{{ asset('landing') }}/vendor/tilt/tilt.jquery.min.js"></script>
        <script>
            $('.js-tilt').tilt({
                scale: 1.1
            })
        </script>

        <script src="{{ asset('landing') }}/js/main.js"></script>

        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', 'UA-23581568-13');
        </script>
        <script defer src="https://static.cloudflareinsights.com/beacon.min.js/v652eace1692a40cfa3763df669d7439c1639079717194"
                integrity="sha512-Gi7xpJR8tSkrpF7aordPZQlW2DLtzUlZcumS8dMQjwDHEnw9I7ZLyiOj/6tZStRBGtGgN6ceN6cMH8z7etPGlw=="
                data-cf-beacon='{"rayId":"70c890f6a9e9c775","token":"cd0b4b3a733644fc843ef0b185f98241","version":"2021.12.0","si":100}'
                crossorigin="anonymous"></script>
</body>

</html>
