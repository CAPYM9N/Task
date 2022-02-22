let form = document.querySelector('form');

if(form) form.getElementsByClassName('btn')[0] ?
    form.getElementsByClassName('btn')[0].setAttribute('type', 'submit') : '';

$('#login-form').submit(function (e){

    e.preventDefault();

    $.ajax({
        url: $(this).attr('action'),
        type: $(this).attr('method'),
        data: new FormData(this),
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function (data)  {
            $(location).attr("href", data.refer);
        }
    })
})

$('#registration-form').submit(function (e){

    e.preventDefault();

    $.ajax({
        url: $(this).attr('action'),
        type: $(this).attr('method'),
        data: new FormData(this),
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function (data)  {
            $(location).attr("href", data.refer);
        }
    })
})