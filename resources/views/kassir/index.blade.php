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
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
