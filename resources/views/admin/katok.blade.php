

<section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-3 col-6">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">Продажа по оплату за сегодня</h3>
                        </div>
                        <div class="box-body">
                            <canvas id="typeListDay"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">Колечество билетов за сегодня</h3>
                        </div>
                        <div class="box-body">
                            <canvas id="typeListDayTicket"></canvas>
                        </div>
                    </div>
                </div>

                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">Продажа по оплату</h3>
                        </div>
                        <div class="box-body">
                            <canvas id="typeList"></canvas>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                {{--<div class="col-lg-3 col-6">
                    <!-- small box -->
                   {!! $sellTicketsToday !!}
                </div>--}}
                <!-- ./col -->

                <!-- ./col -->
            </div>
            <div class="row">
                <div class="col-lg-12 col-12">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">Продажа билетов</h3>
                            <form method="get">
                                <input type="date" name="dateFrom" value="@if(isset($_GET['dateFrom'])) {{ $_GET['dateFrom'] }} @endif">
                                <input type="date" name="dateTo" value="@if(isset($_GET['dateTo'])) {{ $_GET['dateTo'] }} @endif">
                                <button type="submit" class="btn btn-primary">Поиск</button>
                            </form>
                        </div>
                        <div class="box-body">
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-12">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">Продажа билетовдоп услугов</h3>
                            <form method="get">
                                <input type="date" name="dateFromAdd" value="@if(isset($_GET['dateFromAdd'])) {{ $_GET['dateFromAdd'] }} @endif">
                                <input type="date" name="dateToAdd" value="@if(isset($_GET['dateToAdd'])) {{ $_GET['dateToAdd'] }} @endif">
                                <button type="submit" class="btn btn-primary">Поиск</button>
                            </form>
                        </div>
                        <div class="box-body">
                            <canvas id="myChartAdd"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        $(function () {
            var today = new Date();
            var ctx = document.getElementById("myChart").getContext('2d');
            var ctxAdd = document.getElementById("myChartAdd").getContext('2d');
            var type = document.getElementById("typeList").getContext('2d');
            var typeDay = document.getElementById("typeListDay").getContext('2d');
            var typeDayT = document.getElementById("typeListDayTicket").getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! $data['date'] !!},
                    datasets: [{
                        label: `Продажа билетов Дата`,
                        data: {!! $data['price'] !!},
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255,99,132,1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                }
            });
            var myChartAdd = new Chart(ctxAdd, {
                type: 'line',
                data: {
                    labels: {!! $data['date'] !!},
                    datasets: [{
                        label: `Доп услуги`,
                        data: {!! $data['price'] !!},
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255,99,132,1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                }
            });
            var typeList = new Chart(type, {
                type: 'pie',
                data: {
                    labels: {!! $priceType['type'] !!},
                    datasets: [{
                        label: 'Продажа по оплату',
                        data: {!! $priceType['price'] !!},
                        backgroundColor: [
                            'rgb(255, 99, 132)',
                            'rgb(54, 162, 235)',
                            'rgb(255, 205, 86)'
                        ],
                        hoverOffset: 4
                    }]
                }
            });
            var typeListDay = new Chart(typeDay, {
                type: 'pie',
                data: {
                    labels: {!! $priceTypeDay['type'] !!},
                    datasets: [{
                        label: 'Продажа по оплату за сегодня',
                        data: {!! $priceTypeDay['price'] !!},
                        backgroundColor: [
                            'rgb(255, 99, 132)',
                            'rgb(54, 162, 235)',
                            'rgb(255, 205, 86)'
                        ],
                        hoverOffset: 4
                    }]
                }
            });
            var typeListDayT = new Chart(typeDayT, {
                type: 'pie',
                data: {
                    labels: {!! $priceTypeDay['type'] !!},
                    datasets: [{
                        label: 'Колечество билетов за сегодня',
                        data: {!! $priceTypeDay['countTicket'] !!},
                        backgroundColor: [
                            'rgb(255, 99, 132)',
                            'rgb(54, 162, 235)',
                            'rgb(255, 205, 86)'
                        ],
                        hoverOffset: 4
                    }]
                }
            });
        });
    </script>
