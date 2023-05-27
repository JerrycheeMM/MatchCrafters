<div class="header py-4">
    <div class="container">
        <div class="d-flex">
            <a class="header-brand" href="{{ url('/') }}">
{{--                <img src="{{ url('img/logo-min.png') }}" alt="MoneyMatch" style="max-width: 2.5rem;" class="mr-2">--}}
                MatchCrafters
            </a>
            <div class="d-flex order-lg-2 ml-auto align-items-center">
                @include('partials.menus.user-menu')
            </div>
            <a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0 fx-calc-toggler-mobile" data-toggle="modal" data-target="#rate-calculator">
                <i class="fa fa-lg fa-calculator mx-2 my-2"></i>
            </a>
            <a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse" data-target="#mobileMenu">
                <span class="header-toggler-icon"></span>
            </a>
        </div>
    </div>
</div>

<div class="header collapse d-lg-flex p-0" id="mobileMenu">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg order-lg-first">
                @include('partials.menus.main-menu')
            </div>
        </div>
    </div>
</div>
<div class="text-center h3 pt-4" id="timed-out">Your session will be expiring in : <span id="timer"></span></div>
<script type="text/javascript">
    var timeout = {{ config('session.user_timeout')  }};

    var timer = new Date().getTime() + (timeout * 60000);
    var x = setInterval( function(){
        var now = new Date().getTime();
        var distance = timer - now;
        var minutes = Math.floor( (distance % (1000 * 60 * 60)) / (1000 * 60) );
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        document.getElementById("timer").innerHTML =  minutes + "m " + seconds + "s ";

        if (distance < 0) {
            clearInterval(x);
            document.getElementById("timed-out").classList.add('alert','alert-danger','container');
            document.getElementById("timed-out").innerHTML = "SESSION HAS EXPIRED.";
            document.getElementById('timer').style.display = 'none';
        }
    }, 1000 );
</script>
@if (session('success'))
    <div class="alert alert-success" role="alert">
        <div class="container">
            {{ session('success') }}
        </div>
    </div>
@endif
