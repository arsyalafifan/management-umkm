@extends('layouts.login')

@section('content')
<div class="login-box card" style="background-color: rgba(255, 255, 255, 0.6);">
    <div class="card-body text-center text-inverse">
        <h1 class="font-bold">Login <span class="text-danger">Terkunci</span></h1>
        <div class="m-b-40" class="ml-auto"><i class="ti-lock font-bold text-danger" style="font-size: 80px;"></i></div>
        <h4 class="text-inverse font-bold m-t-5 m-b-40"><i>Percobaan login melebihi limit</i></h4>
        <h3 class="font-bold" id="login-text">
        Login kembali dalam waktu
        </h3>
        <div class="countdown justify-content-center" data-count="2021/12/5">
            <div>
                <h3>%m</h3>
                <h4>Menit</h4>
            </div>
            <div>
                <h3>%s</h3>
                <h4>Detik</h4>
            </div>
        </div>
        <div class="ml-auto">
        © 2021 {{ config('app.name', 'SIPD-KAPITASI') }} by Kementerian Dalam Negeri
        </div>
    </div>
</div>
<script>
    var closeInSeconds = <?php echo $nextLoginTime; ?>;
    var displayText = "Login kembali dalam waktu<br>&nbsp;<br> #1",
        timer;

        function lpad(value, padstring, length) {
            return Array(Math.max(length - String(value).length + 1, 0)).join(padstring) + value;
        }

        /**
        * Easy selector helper function
        */
        const select = (el, all = false) => {
            el = el.trim()
            if (all) {
            return [...document.querySelectorAll(el)]
            } else {
            return document.querySelector(el)
            }
        }

        /**
        * Countdown timer
        */
        let countdown = select('.countdown');
        const output = countdown.innerHTML;
        const countDownDate = function() {
            let timeleft = closeInSeconds;

            let days = Math.floor(timeleft / (1000 * 60 * 60 * 24));
            let hours = Math.floor((timeleft % (60 * 60 * 24)) / (60 * 60));
            let minutes = Math.floor((timeleft % (60 * 60)) / (60));
            let seconds = Math.floor((timeleft % (60)));

            closeInSeconds--;
            if (closeInSeconds >= 0) {
                countdown.innerHTML = output.replace('%d', days).replace('%h', hours).replace('%m', lpad(minutes, '0', 2)).replace('%s', lpad(seconds, '0', 2));
            }
            if (closeInSeconds <= 0) {
                clearInterval(timer);
                location.reload();
            }
        }
        countDownDate();
        timer = setInterval(countDownDate, 1000);

</script>
@endsection
