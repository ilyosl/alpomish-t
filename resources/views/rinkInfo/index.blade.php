@extends('layouts.main')


@section('content')
    <div class="bg-snow-2">
        <div class="mt-4 pb-10 mb-5">
            <div class="container">
                <div class="d-flex justify-content-center align-items-center">
                    <div class="w-lg-70 mt-5 position-relative">
                        <p class="text-blue_1 fw-bold fs-40 text-center">
                            Наши секции
                        </p>

                        <div class="row align-items-center">
                            <div class="col-lg-8">
                                <p class="fw-bold fs-30 text-black_dark">Хоккей</p>

                                <div class="d-flex align-items-center justify-content-between">
                                    <p class="text-black_dark mb-2 w-lg-50"> Дни: Пн-Ср-Сб</p>

                                    <p class="text-black_dark mb-2 w-lg-50">Тренер:</p>
                                </div>

                                <div class="d-flex align-items-center justify-content-between">
                                    <p class="text-black_dark mb-0 w-lg-50">Время: 13:00 - 14:30</p>

                                    <p class="text-black_dark mb-0 w-lg-50">Михайлов Андрей Сергеевич</p>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card-3d mt-4" style="background: linear-gradient(99.29deg, #387EC1 0.94%, #47A8DF 100%);" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    <div class="w-lg-45">
                                        <img class="mb-3" src="images/logo_white.png" alt="logo">

                                        <p class="mb-0 text-white">
                                            Записаться в секцию
                                            по хоккею
                                        </p>
                                    </div>
                                    <div class="card-3d-img position-relative d-flex align-items-center w-lg-55">
                                        <img src="images/person.png" alt="image" style="right: 10px">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row align-items-center mt-5">
                            <div class="col-lg-8">
                                <p class="fw-bold fs-30 text-black_dark">Фигурное катание</p>

                                <div class="d-flex align-items-center justify-content-between">
                                    <p class="text-black_dark mb-2 w-lg-50">Дни: Пн-Ср-Сб</p>

                                    <p class="text-black_dark mb-2 w-lg-50">Тренер:</p>
                                </div>

                                <div class="d-flex align-items-center justify-content-between">
                                    <p class="text-black_dark mb-0 w-lg-50">Время: 13:00 - 14:30</p>

                                    <p class="text-black_dark mb-0 w-lg-50">Медведева Евгения Антоновна</p>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card-3d mt-5" style="background: linear-gradient(99.29deg, #E4048F 0.94%, #7A1B86 100%);" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    <div class="card-3d-img position-relative d-flex align-items-center w-lg-30">
                                        <img src="images/balerina.png" alt="image" style="left: 10px">
                                    </div>

                                    <div class="w-lg-65">
                                        <img class="mb-3" src="images/logo_white.png" alt="logo">

                                        <p class="mb-0 text-white">
                                            Записаться в секцию
                                            по фигурному катанию
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content p-3">
                    <div class="modal-header border-0 text-blue_1 fs-20 fw-bold text-center">
                        <p class="w-100">Запись на секцию по хоккею</p>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex align-items-center mt-4">
                            <div class="me-4">
                                <label for="name" class="form-label">Имя</label>
                                <input type="text" class="form-control rounded-8 py-3" id="name">
                            </div>
                            <div>
                                <label for="surname" class="form-label">Фамилия</label>
                                <input type="text" class="form-control rounded-8 py-3" id="surname">
                            </div>
                        </div>

                        <div class="d-flex align-items-center mt-4">
                            <div class="me-4">
                                <label for="number" class="form-label">Номер</label>
                                <input type="text" class="form-control rounded-8 py-3" id="number">

                                <button class="btn login-btn mt-4 w-100">Записаться</button>
                            </div>
                            <div>
                                <label for="comment" class="form-label">Коментарий</label>
                                <textarea type="text" class="form-control rounded-8 py-3" id="comment" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
