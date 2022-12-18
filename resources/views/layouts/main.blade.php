<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Lato:wght@100;300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href=" {{ asset('css/style.css') }} ">
    <title>
        @yield('title')
    </title>
</head>

<body>

<div class="body-site">

    <header class="header">
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <a class="navbar-brand" href="/"><img src="{{asset('images/logo.png')}}" alt="logo"></a>
                    <button class="navbar-toggler focus-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-xl-9 ms-lg-5 ms-0">
                            <li class="nav-item">
                                <a class="nav-link text-grey active" aria-current="page" href="#">Мероприятий</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-grey" href="#">Секции</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-grey" href="#">Каток</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-grey" href="#">Контакты</a>
                            </li>
                        </ul>
                        <form class="d-flex justify-content-between align-items-center" role="search">
                            <button class="btn focus-none basket-btn text-grey me-4" type="button">
                                <img src="{{asset('images/basket_icon.svg')}}" alt="icon"> Корзина
                            </button>
                            <a href="{{ url('login') }}" class="btn focus-none login-btn" type="button">Войти</a>
                        </form>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    @yield('content')

    <footer class="footer">
        <div class="container">
            <div class="row row-cols-xl-4 row-cols-md-2 pb-lg-7 pb-5 border-bottom border-blue_3">
                <div>
                    <img src="{{ asset('images/logo_white.png') }}" class="w-md-auto w-100" alt="logo">

                    <div class="mt-4">
                        <div class="mb-2">
                            <a href="tel: +99899 939-44-09" class="text-light_grey fw-bold text-decoration-none">+99899
                                939-44-09</a>
                        </div>

                        <div class="mb-2">
                            <a href="tel: +99890 094-49-88" class="text-light_grey fw-bold text-decoration-none">+99890
                                094-49-88</a>
                        </div>

                        <div class="mb-2">
                            <span class="text-light_grey">Служба поддержки</span>

                            <div class="mt-3">
                                <img src="images/facebook.svg" class="" alt="social">
                                <img src="images/twitter.svg" class="mx-3" alt="social">
                                <img src="images/linkedin.svg" class="" alt="social">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-2">
                    <span class="text-white text-capitalize fw-bold fs-18">Информация</span>

                    <div class="mt-4">
                        <div class="mb-2">
                            <a href="#" class="text-light_grey text-decoration-none font-DM fw-500">Помощь</a>
                        </div>
                        <div class="mb-2">
                            <a href="#" class="text-light_grey text-decoration-none font-DM fw-500">Правила и условия</a>
                        </div>
                        <div class="mb-2">
                            <a href="#" class="text-light_grey text-decoration-none font-DM fw-500">Возврат и обмен</a>
                        </div>
                        <div class="mb-2">
                            <a href="#" class="text-light_grey text-decoration-none font-DM fw-500">Политика
                                конфиденциальности</a>
                        </div>
                    </div>
                </div>

                <div class="pt-2">
                    <span class="text-white text-capitalize fw-bold fs-18">О нас</span>

                    <div class="mt-4">
                        <div class="mb-2">
                            <a href="#" class="text-light_grey text-decoration-none font-DM fw-500">Наш адресс</a>
                        </div>
                        <div class="mb-2">
                            <a href="#" class="text-light_grey text-decoration-none font-DM fw-500">Контакты</a>
                        </div>
                        <div class="mb-2">
                            <a href="#" class="text-light_grey text-decoration-none font-DM fw-500">Новости</a>
                        </div>
                    </div>
                </div>
                <div class="pt-2">
                    <span class="text-white text-capitalize fw-bold fs-18">Настройки</span>

                    <div class="dropdown mt-4">
                        <button class="btn dropdown-toggle custom-dropdown focus-none" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Русский <i class="fas fa-sort ms-3 text-grey"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="text-center my-3 text-light_grey">
                Copyright © 2022 Alpomish Muz Saroyi
            </div>
        </div>
    </footer>
</div>

<script src="{{ asset('js/vendor.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>

<script>
    var swiper = new Swiper(".mySwiper", {
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });
</script>
</body>

</html>
