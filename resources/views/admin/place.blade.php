<div id="app" >
    <div class="box box-warning">

        <div class="box-header with-border">
            <h3 class="box-title">{{ $event->title }}</h3>
{{--            <button id="myButton">My button</button>--}}
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body" style="display: block;">
            <div>
                <span class="success">Дата и время: {{ $event->eventTimes[0]->eventDate}} {{ $event->eventTimes[0]->eventTime }}</span>
            </div>
            <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
                 width="1100.000000pt" height="631.000000pt" viewBox="0 0 1500.000000 1031.000000"
                 preserveAspectRatio="xMidYMid meet" style="margin-top: -93px" >
                <g transform="translate(0.000000,1031.000000) scale(0.100000,-0.100000)"
                   fill="#000" stroke="none">
                    @foreach($path as $p)
                        <a class="alp-path"
                           href="{{ url('/admin/place-control/view?eventId='.$event->id.'&blockName='.$p->name_block.'&eventTime='.$event->eventTimes[0]->eventTime).'&eventDate='. $event->eventTimes[0]->eventDate }}"
                           rel="tooltip"
                           data-trigger="hover"
                           data-placement="bottom"
                           data-title ="<strong>Place</strong>"
                           data-html="true"
                           id="{{$p->id}}"
                           data-event="{{ $event->id }}"
                           data-id="{{ $p->id  }}"
                           data-block="{{ $p->name_block }}"
                        >
                            <path d="{{ $p->svg_path }}"   />
                            @if($p->svg_name)
                                {!! $p->svg_name !!}
                            @endif
                        </a>
                    @endforeach
                </g>
            </svg>
        </div>
        <!-- /.box-body -->
    </div>

</div>
<style>
    .alp-path:hover {
        fill: #0A075F;
    }
</style>

<script>
    // With the above scripts loaded, you can call `tippy()` with a CSS
    // selector and a `content` prop:

</script>
<script>
    $(function (){
        $('[rel="tooltip"]').tooltip({track:true, html:true, title: 'please wait'})
        // $(".alp-path").mouseout(function(){
        //     // re-initializing tooltip
        //     $(this).attr('title','Please wait...');
        //     $(this).tooltip();
        //     $('.ui-tooltip').hide();
        // });
    })
</script>
