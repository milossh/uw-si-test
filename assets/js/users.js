const api_url = 'http://uwsi.loc/';

$( window ).on('load', function() {

    $.ajax({
        url: api_url + 'users/',
        type: 'get',
        success: function(data){
            if( data.status == 0 ) {
                window.location.href = "/login.html";
            } else {
                // Make paginator
                for(let i=1; i<=data.response.total_pages; i++) {
                    let li = '<li data-page="' + i + '">' + i + '</li>';
                    $("#paginator").append(li);
                }
                
                for( let j=1; j<=data.response.students.length; j++ ) {
                    // An student object from response
                    let curstudent = data.response.students[j-1];

                    // Table Row for Single Student HTML
                    let trsshtml = '<tr class="single-student"><td class="td-icon"><i class="fa fa-check-circle"></i></td><td class="td-left"><table><tr><td class="td-username">'+curstudent.username+'</td></tr><tr><td class="td-fullname">'+curstudent.full_name+'</td></tr></table></td><td class="td-right"><table><tr><td>...</td></tr><tr><td>'+curstudent.group_name+'</td></tr></table></td></tr>';

                    $('.students-wrapper').append(trsshtml);
                }
            }
        }
    });


    $('.preload-wrapper').fadeOut();
    $('body').removeClass( 'preload' );
});

$("#paginator").on('click', 'li', function(){
    let data = {
        'page': $(this).data('page')
    };

    $.ajax({
        url: api_url + 'users/',
        type: 'get',
        data: data,
        success: function(data){
            if( data.status == 0 ) {
                window.location.href = "/login.html";
            } else {

                $('.students-wrapper').text('');

                // Change values in the student table given new response(page)
                for( let j=1; j<=data.response.students.length; j++ ) {
                    // An student object from response
                    let curstudent = data.response.students[j-1];

                    // Table Row for Single Student HTML
                    let trsshtml = '<tr class="single-student"><td class="td-icon"><i class="fa fa-check-circle"></i></td><td class="td-left"><table><tr><td>'+curstudent.username+'</td></tr><tr><td>'+curstudent.full_name+'</td></tr></table></td><td class="td-right"><table><tr><td>...</td></tr><tr><td>'+curstudent.group_name+'</td></tr></table></td></tr>';

                    $('.students-wrapper').append(trsshtml);
                }
            }
        }
    });
});

$(".logout-wrap").on('click', function(){
    $.ajax({
        url: api_url + 'auth/',
        type: 'DELETE',
        success: function(data){
            if( data.status == 1 ) {
                window.location.href = "/login.html";
            }
        }
    });
});