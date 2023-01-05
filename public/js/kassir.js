$(document).ready(function(){
    let token = $('meta[name="csrf-token"]').attr('content')
    // console.log(token)
    $("#btn-info").click(function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': token
            }
        });
        let qrcode = $('qrcode').val()

        $.ajax({
            type: 'POST',
            url: '/get-info-by-qr',
            data: {qrcode: qrcode},
            // dataType: 'json',
            success: function (data){
                console.log(data)
            }
        })
    });
})
