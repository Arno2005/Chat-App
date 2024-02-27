$(document).ready(function ($) {

    $('.file-input').change(function() {
        $('.filename-container').empty();
        $file = $(this).val();
        $file = $file.replace(/.*[\/\\]/, ''); //grab only the file name not the path
        $('.filename-container').append("<span  class='filename'>" + $file + "</span>").show();
    
    })

    function sendAjaxRequest(formData) {
        $.ajax({
            type: "POST",
            url: "/chat/send",
            data: formData,
            cache: false,
            processData: false,
            contentType: false
        }).done(function () {
            $('#error').text('');
            $('.filename-container').empty();
        }).fail(function (data) {
            let error = JSON.parse(data.responseText);
            $('#error').text(error['msg']);
        });
    }

    $('#main-form').keypress(function (e) {
        if (e.which == 13) {
          $('#main-form').submit();
          e.preventDefault;
          return false;
        }
    });

    $.ajax({
        type: "POST",
        url: "/user/check",
    }).done(
        function (data) {
            let res = JSON.parse(data);
            $('#user_id').val(res['user_id']);
        }
    );

    let scrollDown = true;
    $("#main-form").submit(function (event){

        var formData = new FormData(this);
        var fileInput = $('#formFile')[0].files[0];

        if(fileInput && fileInput.type == 'image/jpeg'){

            new Compressor(fileInput, {
                quality: 0.5,
                success(result){

                    var compressedFile = new File([result], fileInput.name, { type: 'image/jpeg' });
                    formData.set('file', compressedFile);

                    sendAjaxRequest(formData);

                },error(err) {
                    console.error('Compression Error:', err.message);
                },
            })
        }else{
            sendAjaxRequest(formData);
        }

        $("#text").val('');

        scrollDown = true;

        event.preventDefault();
    });

    setInterval(() => {
        $.ajax({    
            type: "GET",
            url: "/chat/display",               
            success: function(data){
                $('#main-chat').empty();
                let messages = JSON.parse(data);
                if(messages['status'] != 404){
                    for(let i in messages){
                        if(i != 'my_id'){

                            let hasFile = messages[i].file != '';
                            
                            switch (messages[i].user_id) {
                                case 0:
                                    $('#main-chat').append('<div class="notif mb-3">' + messages[i].text + '</div>');
                                    break;
                                    
                                case messages.my_id:
                                    if(hasFile){
                                        if(messages[i].file.split('.')[1] == 'jpg' || messages[i].file.split('.')[1] == 'jpeg'){
                                            $('#main-chat').append('<div class="my message darker mb-3 pe-2"> <span style="font-weight:bold">' + messages[i].username + ':</span> ' + messages[i].text + `<div> <a href="/file/get/${messages[i].file.split('.')[0]}/${messages[i].file.split('.')[1]}" target="_blank"><img src="/file/get/${messages[i].file.split('.')[0]}/${messages[i].file.split('.')[1]}" width="250" height="250"></a> </div></div>`);    
                                        }else{
                                            $('#main-chat').append('<div class="my message darker mb-3 pe-2"> <span style="font-weight:bold">' + messages[i].username + ':</span> ' + messages[i].text + ` <a href="/file/get/${messages[i].file.split('.')[0]}/${messages[i].file.split('.')[1]}" target="_blank">${messages[i].file.replace('%', ' ')}</a></div>`);    
                                        }
                                    }else{
                                        $('#main-chat').append('<div class="my message darker mb-3 pe-2"> <span style="font-weight:bold">' + messages[i].username + ':</span> ' + messages[i].text + '</div>');
                                    }
                                    break;
                                    
                                    default:
                                        if(hasFile){
                                            if(messages[i].file.split('.')[1] == 'jpg' || messages[i].file.split('.')[1] == 'jpeg'){
                                                $('#main-chat').append('<div class="message darker mb-3 pe-2"> <span style="font-weight:bold">' + messages[i].username + ':</span> ' + messages[i].text + `<div> <a href="/file/get/${messages[i].file.split('.')[0]}/${messages[i].file.split('.')[1]}" target="_blank"><img src="/file/get/${messages[i].file.split('.')[0]}/${messages[i].file.split('.')[1]}" width="250" height="250"></a> </div></div>`);    
                                            }else{
                                                $('#main-chat').append('<div class="message darker mb-3 pe-2"> <span style="font-weight:bold">' + messages[i].username + ':</span> ' + messages[i].text + ` <a href="/file/get/${messages[i].file.split('.')[0]}/${messages[i].file.split('.')[1]}" target="_blank">${messages[i].file.replace('%', ' ')}</a></div>`);    
                                            }
                                    }else{
                                        $('#main-chat').append('<div class="message darker mb-3 pe-2"> <span style="font-weight:bold">' + messages[i].username + ':</span> ' + messages[i].text + '</div>');
                                    }
                                    break;
                            }
                        }
                        
                    };

                    if(scrollDown){
                        var d = $('#main-chat');
                        d.scrollTop(d.prop("scrollHeight"));
                        scrollDown = false;
                    }
                }
                
            }
        });
    }, 2000);

    
});