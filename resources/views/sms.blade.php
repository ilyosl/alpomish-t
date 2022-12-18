@extends('layouts.main')

@section('content')
    <div class="login">
        <div class="container">
            <form class="d-flex align-items-center justify-content-center">
                <div class="bg-white p-5 rounded-16">
                    <img src="images/logo.png" class="me-4 mb-3" alt="logo">

                    <p class="fw-800 text-black_medium fs-20">Введите код из SMS</p>

                    <p class="fw-light text-black_medium">
                        Мы отправили его на
                        +998 (99) 999-99-99
                    </p>

                    <div class="d-flex m-0">
                        <input type="text" class="border-bottom border-0 border-black_medium me-2 focus-none fs-20 text-black_dark text-center" style="height: 36px;width: 36px">
                        <input type="text" class="border-bottom border-0 border-black_medium me-2 focus-none fs-20 text-black_dark text-center" style="height: 36px;width: 36px">
                        <input type="text" class="border-bottom border-0 border-black_medium me-2 focus-none fs-20 text-black_dark text-center" style="height: 36px;width: 36px">
                        <input type="text" class="border-bottom border-0 border-black_medium me-2 focus-none fs-20 text-black_dark text-center" style="height: 36px;width: 36px">
                    </div>

                    <div class="form-check mt-4">
                        <input class="form-check-input focus-none" type="checkbox" value="" id="flexCheckChecked" checked>
                        <label class="form-check-label focus-none mt-1 ms-2 fw-light text-black_medium" for="flexCheckChecked">
                            Запомнить на этом устройстве
                        </label>
                    </div>

                    <a href="#" class="text-blue_4 mt-4 text-decoration-none w-100 d-block">Отправить код повторно</a>

                    <a href="#" class="text-blue_4 mt-4 text-decoration-none w-100 d-block">Войти с другим номером</a>

                    <a href="#" class="text-grey mt-4 text-decoration-none w-100 d-block">Не получается войти</a>
                </div>
            </form>
        </div>
    </div>
@endsection
