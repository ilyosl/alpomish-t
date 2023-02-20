    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-3 col-6">
                    {!! $onlineKatok !!}
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    {!! $sellTickets !!}
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                   {!! $sellTicketsToday !!}
                </div>
                <!-- ./col -->

                <!-- ./col -->
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">Продажа билетов</h3>
                        </div>
                        <div class="box-body">
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">Продажа по оплату</h3>
                        </div>
                        <div class="box-body">
                            <canvas id="typeList"></canvas>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <script>
        $(function () {
            var ctx = document.getElementById("myChart").getContext('2d');
            var type = document.getElementById("typeList").getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! $data['date'] !!},
                    datasets: [{
                        label: 'Продажа билетов',
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
        });
    </script>
