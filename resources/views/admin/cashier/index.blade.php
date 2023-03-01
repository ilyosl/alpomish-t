<div class="row">
    @foreach($events as $event)
    <div class="col-md-4">
        <div class="box box-solid box-info text-center" >
            <div class="box-header with-border">
                <h3 class="box-title">{{$event->title}}</h3>
            </div>
            <div class="box-body">
                <img class="card-img-top"  width="100%" src="{{$event->image}}" alt="Card image cap">
                <p class="card-text">{{$event->desc}}</p>
                <a href="{{url('/admin/cashier/'.$event->id)}}" class="btn btn-primary">Открыт</a>
            </div>
        </div>
    </div>
    @endforeach
</div>
