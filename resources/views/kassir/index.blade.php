@extends('layouts.admin')

@section('content')


    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Поиск билета</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form>

                    <div class="card-body">
                        <div class="form-group">
                            <label for="qrcode">QrCode</label>
                            <input type="text" name="qrcode"  class="form-control" id="qrcode" placeholder="Qrcode">
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button id="btn-info" type="submit" class="btn btn-primary">Проверить</button>
                    </div>
                </form>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Инфо о билеты</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>User</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Reason</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>183</td>
                                        <td>John Doe</td>
                                        <td>11-7-2014</td>
                                        <td><span class="tag tag-success">Approved</span></td>
                                        <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
