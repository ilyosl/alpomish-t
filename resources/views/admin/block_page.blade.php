<?php
//$countPlace =
?>
<div>
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Название блока {{$tmpPlace->name_block}}</h3>
        </div>
        <div class="box-body">
            <div>

                    <div>
                        @foreach($convert as $key => $value)
                        <div class="place">

                                <span style="margin-right: 50px">Ряд: {{$key}}</span>
                                @foreach($value as $pkey => $place)

                                        <div
                                            class="joy {{$place['status'] == 0 ? 'free':'buyed' }} {{$place['exists'] == 0 ? 'empty':''}}"
                                            title="Сумма: {{$place['price']}}"
                                            data-position="{{ $key }}"
                                            data-place="{{ $pkey }}"
                                            data-status = "{{ $place['status'] }}"
                                        >{{ $pkey }}</div>

                                @endforeach

                        </div>
                        @endforeach
                    </div>
                    <div>


                    </div>

            </div>
        </div>
    </div>
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Форма</h3>
        </div>
        <div class="box-body">
            <div class="selectallplace" style="cursor:pointer; color:black; width: 120px;">
                <div class="btn btn-success videlit_vse"><i class="fa fa-check-circle-o" style="font-size: 16px; position: relative; left: -5px;" aria-hidden="true"></i>Выделить все</div>
            </div>
            <form method="post" action="{{ url('/admin/place-control/set-ticket') }}" class="form-horizontal" id="set_ticket_form">
                @csrf

                <input type="hidden" name="block_name" value="{{ $tmpPlace->name_block }}">
                <input type="hidden" name="event_id" value="{{ $event->id }}">
                <input type="hidden" name="eventDate" value="{{ $event->eventTimes[0]->eventDate }}">
                <input type="hidden" name="eventDate" value="{{ $event->eventTimes[0]->eventDate }}">
                <input type="hidden" name="eventTime" value="{{ $event->eventTimes[0]->eventTime }}">
                <div class="col-sm-3 control-label"><b><i class="fa fa-circle-o" style="position: relative; left: -5px;" aria-hidden="true"></i>Статус:</b> </div>
                <div class="col-sm-9 radio-pole">
                    <div class="radio">
                        <label style="color: green;">
                            <input type="radio" name="status" id="optionsRadios" value="0" checked="">
                            Установить цену
                        </label>
                    </div>
                    <div class="radio">
                        <label style="color: #7b7b7b;">
                            <input type="radio" name="status" id="optionsRadios" value="3">
                            Пригласительные
                        </label>
                    </div>
                    <div class="radio">
                        <label style="color: red">
                            <input type="radio" name="status" id="optionsRadios" value="2">
                            Купленные
                        </label>
                    </div>
                </div>
                <div class="form-group pole-info puli">
                    <label for="inputEmail3" class="col-sm-3 control-label">
                        <i class="fa fa-money" style="position: relative; left: -5px;" aria-hidden="true"></i>Стоимость:
                    </label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="inputEmail3" name="costTicket" placeholder="Введите стоимость билета*">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-10">
                        <br>
                        <button type="submit" class="btn btn-primary save"><i class="fa fa-floppy-o" style="position: relative; left: -5px;" aria-hidden="true"></i>Сохранить</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('.joy').tooltip();
        $('.joy').click(function (){
            var status = $(this).data('status')
            p = $(this).data('position');
            place = $(this).data('place');
            var $myF = $('#set_ticket_form');
            if($myF.find('input[value="'+p+','+place+'"]').length){
                $myF.find('input[value="'+p+','+place+'"]').remove();
            }
            else{
                $myF.append('<input type="hidden" name="tickets[]" value="'+p+','+place+'">');
            }
            if(status == 0){
                if($(this).hasClass('clicked')){
                    $(this).removeClass('clicked')
                }else{
                    $(this).addClass('clicked')
                }
            }

        })
        $('.selectallplace').on('click', function(){
            console.log($(this))
            $(".joy").each(function(index, el) {
                if($(this).hasClass('buyed') || $(this).hasClass('block_buyed')){
                    return true;
                }
                var $myF = $('#set_ticket_form');
                if ( $myF.length){
                    p = $(this).data('position');
                    place = $(this).data('place');
                    $(this).addClass('clicked');

                    if($myF.find('input[value="'+p+','+place+'"]').length){
                        $myF.find('input[value="'+p+','+place+'"]').remove();
                    }
                    else{
                        $myF.append('<input type="hidden" name="tickets[]" value="'+p+','+place+'">');
                    }
                }
            });
        });
    })
</script>
<style>
    .place {
        display: flex;
        align-content: center;
        align-items: start;
    }
    .joy:hover{
        background-color: #0c84ff;
    }


    .joy{
        cursor: pointer;
        width: 32px;
        height: 25px;
        color: white;
        text-align: center;
        /*font-family: Akrobat-Black;*/
        letter-spacing: 1px;
        font-size: 14px;
        padding: 2px 0 0px 3px;
        margin: 2px;
        /* font-weight: bold; */
        line-height: 17px;
        background-position: 1px;
        background-size: 100%;
        background-repeat: no-repeat;
        background-color: #0A075F;
    }
    .free{
        background-color: green;
    }
    .buyed {
        background-color: red;
        cursor: no-drop;
    }
    .empty{
        background-color: #4b646f;
    }
    .clicked {
        background-color: #0A075F;
    }

</style>
