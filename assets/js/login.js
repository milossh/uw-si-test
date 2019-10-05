const api_url = 'http://uwsi.loc/'

$( ".login-button button" ).on( "click", function( event ) {
    let form_data = {
        'username': $("#username").val().trim(),
        'password': $("#password").val().trim()
    }

    $.ajax({
        url: api_url + 'auth/',
        type: 'post',
        data: form_data,
        success: function(data){
            if( data.status == 0 ) {
                $(".error").text(data.response);
            } else {
                window.location.href = "/students.html";
            }
        }
    });
});