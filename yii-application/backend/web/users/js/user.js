//начало оброботки данных модуля user
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
    var DOMEN = "sv";
    //Задаем масску ввода для клсса phone
    $(".phone").mask("8(999)-999-99-99");
    //Обработчик нажатия кнопки редактировать в userbox
    $('.my_content_bloc').on('click', '.user_edit_button', function(){
        var status_card = Number($('#status_card').val());
        console.log(status_card);
        if(status_card == 0){
            var buffer = this.id.split('-');
            console.log(buffer);
            var id = buffer[1];
            console.log(id);
            $('#user_card_button_edit_archive-'+id).css('display', 'none');
            $('#user_data-'+id).css('display', 'none');
            $('#user_cancel_button_card_apply-'+id).css('display', 'flex');
            $('#user_data_edit-'+id).css('display', 'block');
            $('#block_button_photo_edit-'+id).css('display', 'block');
            var employeename = $('#span_user_employeename-'+id).text();
            console.log(employeename);
            $('#status_card').val(1);
            $('#status_card').attr('data-user-card', employeename);
            return false;
        }else{
            var employeename = $('#status_card').attr('data-user-card');
            console.log(employeename);
            alert('Вы уже редактируете '+employeename);
            return false;
        }
        
    });
    //Обработчик нажатия кнопки отмена в userbox
    $('.my_content_bloc').on('click', '.user_cancel_button', function(){
        console.log(this);
        var status_card = Number($('#status_card').val());
        console.log(status_card);
        if(status_card == 1){
            var buffer = this.id.split('-');
            console.log(buffer);
            var id = buffer[1];
            console.log(id);
            if(id==0){
                //alert("Работаю");
                сleanFieldsAdded(id);
                сleanErrorServerTreatment(id);
                var data = {'UserPhoto[id]':id,'_csrf-backend':$('input[name="_csrf-backend"]').val()};
                $.ajax({
                        url: '/yii-application/backend/web/user/user/filedeletegeneral',
                        type: 'POST',
                        data: data,
                        success: function(res){
                            $('#user_img_photo-'+id).attr('src',"http://"+DOMEN+"/yii-application/backend/web/img/users/default/default.svg");
                            $('#input_photo_update-'+id).fileinput('clear');
                            $('#Block_add_user').css('display', 'none'); 
                            $('#status_card').val(0);
                            $('#status_card').attr('data-user-card', '');
                        },
                        error: function(){
                            alert('По неизвестной причине сервер не ответил обратитесь к админу.');
                        }
                    });                
            }else{
                GetDataFromSpan(id);
                $('#user_card_button_edit_archive-'+id).css('display', 'flex');
                $('#user_data-'+id).css('display', 'block');
                $('#user_cancel_button_card_apply-'+id).css('display', 'none');
                $('#user_data_edit-'+id).css('display', 'none');
                $('#block_button_photo_edit-'+id).css('display', 'none');
                $('#status_card').val(0);
                $('#status_card').attr('data-user-card', '');            
                return false;
            }
        }    
     });
    //Обработка нажатия кнопки применить в userbox
    $('.my_content_bloc').on('click', '.user_apply_button', function(){
        console.log(this);
        var status_card = Number($('#status_card').val());
        console.log(status_card);
        if(status_card == 1){
            var buffer = this.id.split('-');
            console.log(buffer);
            var id = buffer[1];
            console.log(id);            
            console.log($('#input_user_employeename-'+id).val());
            $('#span_user_alert_server-'+id).text('');
            $('#user_alert_server-'+id).css('display', 'none');
            if(validationUser(id)){
                var data = $('#form-update_user-'+id).serialize();
                console.log(data);
                сleanErrorServerTreatment(id)
                if(id==0){
                     $.ajax({
                        url: '/yii-application/backend/web/user/user/create',
                        type: 'POST',
                        data: data,
                        success: function(res){
                            if(res[0]!=0){
                                console.log(res); 
                                $("#w0").prepend(res);
                                сleanFieldsAdded(id);
                                $('#Block_add_user').css('display', 'none'); 
                                $('#status_card').val(0);
                                $('#status_card').attr('data-user-card', '');
                                $('[data-toggle="tooltip"]').tooltip();
                                return false;
                            }else{
                                console.log(res);
                                $('#span_user_alert_server-'+id).text(res['msg']);
                                $('#user_alert_server-'+id).css('display', 'block');
                                errorServerTreatment(res['model'],id);
                                console.log(res['modeltest']);
                                return false;    
                            }    
                        },
                        error: function(){
                            alert('По неизвестной причине сервер не ответил обратитесь к админу.');
                        }
                    });
                      
                     
                    return false;
                }else{
                    $.ajax({
                        url: '/yii-application/backend/web/user/user/update',
                        type: 'POST',
                        data: data,
                        success: function(res){
                            if(res[0]!=0){
                                console.log(res);
                                addUserCardDataServer(res['model'],id)
                                $('#user_card_button_edit_archive-'+id).css('display', 'flex');//Показываем группу кнопок редактировать в архив
                                $('#user_data-'+id).css('display', 'block');//
                                $('#user_cancel_button_card_apply-'+id).css('display', 'none');// 
                                $('#user_data_edit-'+id).css('display', 'none');
                                $('#block_button_photo_edit-'+id).css('display', 'none');
                                $('#status_card').val(0);
                                $('#status_card').attr('data-user-card', '');
                                return false;
                            }else{
                                console.log(res);
                                $('#span_user_alert_server-'+id).text(res['msg']);
                                $('#user_alert_server-'+id).css('display', 'block');
                                errorServerTreatment(res['model'],id);
                                console.log(res['modeltest']);
                                return false;
                            }    
                        },
                        error: function(){
                            alert('По неизвестной причине сервер не ответил обратитесь к админу.');
                        }
                    });
                    return false;
                }
            }else{
                return false;
            } 
        }    
    });
    //Обработчик нажатия кнопки в архив userbox
    $('.my_content_bloc').on('click', '.user_archive_button', function(){        
        console.log(this);
        var buffer = this.id.split('-');
        console.log(buffer);
        var id = buffer[1];
        console.log(id);
        var employeename = $('#span_user_employeename-'+id).text();
        var addArhive = "Перемещаем в архив сотрудника - ";
        var deleteArhive = "Перемещаем из архива сотрудника - ";
        if(Number($("#user_archive_val-"+id).val())==0){
            var isArhive = confirm(addArhive+employeename);
        }else{
            var isArhive = confirm(deleteArhive+employeename);
        }
        if(isArhive){
            var data = $('#form_archive_user-'+id).serialize();
            console.log(data);
            $.ajax({
                url: '/yii-application/backend/web/user/user/archive',
                type: 'POST',
                data: data,
                success: function(res){
                    console.log(res);
                    if(res[0]==0){
                        var namePost = postCreation(id,res['msg'],false);
                        setTimeout(postDelete, 5000,namePost);
                    }else{
                        var namePost = postCreation(id,res['msg'],true);
                        setTimeout(postDelete, 5000,namePost);
                        console.log($("#user_bloc_kard-"+id));
                        $("#user_bloc_kard-"+id).remove();    
                    }    
                },
                error: function(){
                    alert('По неизвестной причине сервер не ответил обратитесь к админу.');
                }
            });
            return false;
        }
     });
    //Обработчик нажатия кнопки изменения фото userbox
    $('.my_content_bloc').on('click', '.btn-update-photo', function(){
        var buffer = this.id.split('-');
        console.log(buffer);
        var id = buffer[1];
        console.log(id);
        console.log($('#input_photo_update-'+id));
        $('#input_photo_update-'+id).fileinput({
            language: 'ru',
            theme: 'fas',
            required: true,
            uploadUrl: "/yii-application/backend/web/user/user/updatephoto",
            minFileCount: 1,
            maxFileCount: 1,
            showRemove: false,
            showCancel: false,
            fileActionSettings:{
                showUpload: false,
            },
            initialPreview:getImgPreviewAjax(id),
            initialPreviewConfig: getImgPreviewConfigAjax(id),
            initialPreviewShowDelete: false,
            uploadExtraData: {
                'UserPhoto[id]':id,
                '_csrf-backend':$('input[name="_csrf-backend"]').val(),
            },
        });   
        $('#modal_update_photo_user-'+id).modal();
        return false;
    });
    $('.my_content_bloc').on('hidden.bs.modal', '.modal', function () {
        //alert('вы закрыли модальное окно');
        var buffer = this.id.split('-');
        console.log(buffer);
        var id = buffer[1];
        console.log(id);
        if($('#modal_user_img_photo-'+id).is('#modal_user_img_photo-'+id)){
            console.log('есть фото');
            console.log($('#img_photo_preview-'+id));
            $('#user_img_photo-'+id).attr('src',$('#modal_user_img_photo-'+id).attr('src'));
        }else{
            console.log('Элемент не найден');
            console.log($('#img_photo_preview-'+id));
            $('#user_img_photo-'+id).attr('src',"http://"+DOMEN+"/yii-application/backend/web/users/img/users/default/default.svg");
        }
    });
    function getImgPreviewAjax(id){
        //console.log($('#img_photo-'+id).attr('src'));
        var src = $('#user_img_photo-'+id).attr('src').split('/');
        console.log(src);
        if(src[7].localeCompare('default')==0){
            //console.log('Сработал по умолчанию');
            return '';
        }else{
            //console.log('Сработал не по умолчанию');
            //console.log("<img id='img_photo'  src='"+$('#img_photo-'+id).attr('src')+"' style=' width: 200px; height: 200px;'>");
            return "<img id='modal_user_img_photo-"+id+"' class='file-preview-image' src='"+$('#user_img_photo-'+id).attr('src')+"' style=' width: 100px; height: 120px;'>";
        }
    }
    function getImgPreviewConfigAjax(id){
        //console.log($('#img_photo-'+id).attr('src'));
        var src = $('#user_img_photo-'+id).attr('src').split('/');
        console.log(src);
        if(src[7].localeCompare('default')==0){
            //console.log('Сработал по умолчанию');
            return '';
        }else{
            //console.log('Сработал не по умолчанию');
            return [
                {
                caption: src[8], 
                width: '120px', 
                url: '/yii-application/backend/web/user/user/filedeletegeneral', 
                key: 100, 
                extra: {
                    'UserPhoto[id]':id,
                    '_csrf-backend':$('input[name="_csrf-backend"]').val(),
                }
            }
        ];
        }
    }
    //Функция создает сообшение об ошибке или об успехе
    function postCreation(id,str,result){
        if(!result){
            var text = ""+
                "<div id='users_alert_server_block-"+id+"' class='col-xl-10 col-lg-10 col-md-12 col-sm-12 col-12  my-1 alert alert-danger' role='alert'>"+
                    "<span id='span_users_alert_server-"+id+"'>"+str+" - "+$('#span_user_employeename-'+id).text()+"</span>"               
                "</div>";
                console.log(text);
                $(".my_content_bloc").prepend(text);
                return "#users_alert_server_block-"+id; 
        }else{
            var text = ""+
                "<div id='users_alert_server_block-"+id+"' class='col-xl-10 col-lg-10 col-md-12 col-sm-12 col-12  my-1 alert alert-success' role='alert'>"+
                    "<span id='span_users_alert_server-"+id+"'>"+str+" - "+$('#span_user_employeename-'+id).text()+"</span>"               
                "</div>";
                console.log(text);
                $(".my_content_bloc").prepend(text);
                return "#users_alert_server_block-"+id;
        }   
    }
    //Функция удаляет созданую ошибку 
    function postDelete(str){
        $(str).remove();    
    }
    //Функция проверяет сушествует ли переменная
    function empty(e) {
        switch (e) {
            case "":
            case 0:
            case "0":
            case null:
            case false:
            case typeof this == "undefined":    
            return true;
        default:
            return false;
        }
    }
    //Функция проверки полей редактируемых карточек
    function validationUser(id){
        //Сбрасываем ошибку к полю ФИО
        $('#error_user_employeename-'+id).text('');
        $('#error_user_employeename-'+id).css('display', 'none');
        //Сбрасываем ошибку к полю email
        $('#error_user_email-'+id).text('');
        $('#error_user_email-'+id).css('display', 'none');
        //Сбрасываем ошибку к полю телефон
        $('#error_user_phone-'+id).text('');
        $('#error_user_phone-'+id).css('display', 'none');
        //Сбрасываем ошибку к полю адрес
        $('#error_user_address-'+id).text('');
        $('#error_user_address-'+id).css('display', 'none');
        //Сбрасываем ошибку к полю пароль
        $('#error_user_password-'+id).text('');
        $('#error_user_password-'+id).css('display', 'none');
        //Сбрасываем ошибку к полю повторный ввод пароля
        $('#error_user_prePassword-'+id).text('');
        $('#error_user_prePassword-'+id).css('display', 'none');
        if(id==0){
            //Сбрасываем ошибку к полю должность
            $('#error_user_id_position-'+id).text('');
            $('#error_user_id_position-'+id).css('display', 'none');
        }
        //Начинаем проверки полей
        //Проеверяем существует ли значение в поле ФИО
        if(!empty($('#input_user_employeename-'+id).val())){
            $('#input_user_employeename-'+id).removeClass('is-invalid');//Удаляем класс у инпута который подкрашивает его в красный
            //Проверям добавление нового сатрудника или редактирование старого
            if(id==0){
                if(empty($('#input_user_id_position-'+id).val())){
                    console.log($('#input_user_id_position-'+id).val());
                    //если поле должность пустое
                    $('#error_user_id_position-'+id).text('Вы не выбрали должность! Выберете!');//Добавляем текст ошибки
                    $('#error_user_id_position-'+id).css('display', 'block');//Блок ошибки показываем пользователю
                    $('#input_user_id_position-'+id).addClass('is-invalid');//Окрашиваем поле где ошибка в красный
                    return false;
                }
            }
            //Проверяем существует ли значение в поле email
            if(!empty($('#input_user_email-'+id).val())){
                $('#input_user_employeename-'+id).removeClass('is-invalid');//Удаляем класс у инпута который подкрашивает его в красный
                console.log($('#input_user_email-'+id).val());
                //Проверяем правильно ли введен email в поле email
                if(!emailEmpty($('#input_user_email-'+id).val())){
                    $('#input_user_employeename-'+id).removeClass('is-invalid');//Удаляем класс у инпута который подкрашивает его в красный
                    console.log("Значение инпута телефон:"+$('#input_user_phone-'+id).val());
                    //Проверяем существует ли значение в поле телефон
                    if(!empty($('#input_user_phone-'+id).val())){
                        $('#input_user_phone-'+id).removeClass('is-invalid');//Удаляем класс у инпута который подкрашивает его в красный
                        //Проверяем существует ли значение в поле адрес
                        if(!empty($('#input_user_address-'+id).val())){
                            $('#input_user_address-'+id).removeClass('is-invalid');//Удаляем класс у инпута который подкрашивает его в красный                        
                            if($('#check_user_pass_change-'+id).is(':checked') || id==0){
                                $('#input_user_password-'+id).removeClass('is-invalid');//Удаляем класс у инпута который подкрашивает его в красный
                                if(!empty($('#input_user_password-'+id).val())){
                                   $('#input_user_prePass-'+id).removeClass('is-invalid');//Удаляем класс у инпута который подкрашивает его в красный
                                   if(!empty($('#input_user_prePassword-'+id).val())){
                                        if(($('#input_user_password-'+id).val()).localeCompare($('#input_user_prePassword-'+id).val())==0){  
                                            return true; //Возврашаем true если все проверки пройденны
                                        }else{
                                            //если поле смены пароля пустое
                                            $('#error_user_prePassword-'+id).text('Введеные пароли не совпадают. Повторите ввод!');//Добавляем текст ошибки
                                            $('#error_user_prePassword-'+id).css('display', 'block');//Блок ошибки показываем пользователю
                                            $('#input_user_prePassword-'+id).addClass('is-invalid');//Окрашиваем поле где ошибка в красный
                                            return false;
                                        }
                                   }else{
                                        //если поле смены пароля пустое
                                        $('#error_user_prePassword-'+id).text('Вы не заполнили поле повторного ввода! Заполните!');//Добавляем текст ошибки
                                        $('#error_user_prePassword-'+id).css('display', 'block');//Блок ошибки показываем пользователю
                                        $('#input_user_prePassword-'+id).addClass('is-invalid');//Окрашиваем поле где ошибка в красный
                                        return false;
                                   }    
                                }else{
                                    //если поле смены пароля пустое
                                    $('#error_user_password-'+id).text('Вы не заполнили поле пароль! Заполните!');//Добавляем текст ошибки
                                    $('#error_user_password-'+id).css('display', 'block');//Блок ошибки показываем пользователю
                                    $('#input_user_password-'+id).addClass('is-invalid');//Окрашиваем поле где ошибка в красный
                                    return false;
                                    
                                }
                            }else{
                                return true; //Возврашаем true если все проверки пройденны
                            }
                        }else{
                            //если поле адресс пустое
                            $('#error_user_address-'+id).text('Вы не заполнили поле адреса! Заполните!');//Добавляем текст ошибки
                            $('#error_user_address-'+id).css('display', 'block');//Блок ошибки показываем пользователю
                            $('#input_user_address-'+id).addClass('is-invalid');//Окрашиваем поле где ошибка в красный
                            return false;
                        }
                    }else{
                        //если поле телефон пустое
                        $('#error_user_phone-'+id).text('Вы не заполнили поле телефон! Заполните!');//Добавляем текст ошибки
                        $('#error_user_phone-'+id).css('display', 'block');//Блок ошибки показываем пользователю
                        $('#input_user_phone-'+id).addClass('is-invalid');//Окрашиваем поле где ошибка в красный
                        return false;
                    }                    
                }else{
                    //если email не правильно введен
                    $('#error_user_email-'+id).text('Вы неправильно ввели почту!');//Добавляем текст ошибки
                    $('#error_user_email-'+id).css('display', 'block');//Блок ошибки показываем пользователю
                    $('#input_user_email-'+id).addClass('is-invalid');//Окрашиваем поле где ошибка в красный
                    return false;
                }    
            }else{
                //если поле email пустое
                $('#error_user_email-'+id).text('Вы оставили пустым поле Почты! Заполните.');//Добавляем текст ошибки
                $('#error_user_email-'+id).css('display', 'block');//Блок ошибки показываем пользователю
                $('#input_user_email-'+id).addClass('is-invalid');//Окрашиваем поле где ошибка в красный
                return false;
            }    
        }else{
            //если поле ФИО пустое
            $('#error_user_employeename-'+id).text('Вы оставили пустым поле ФИО! Заполните.');//Добавляем текст ошибки
            $('#error_user_employeename-'+id).css('display', 'block');//Блок ошибки показываем пользователю
            $('#input_user_employeename-'+id).addClass('is-invalid');//Окрашиваем поле где ошибка в красный
            return false;
        }
    }
    //Функция проверки email
    function emailEmpty(email){
        var re =  /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        return !re.test(email);
    }
    //Функция обработки полученных ошибок с сервера
    function errorServerTreatment(res,id){
        //перебирает поля с данными, присланные с сервера
        $.each(res,function(index,value){
            console.log('Индекс: ' + index.toString() + '; Значение: ' + value.toString());
            $('#error_user_'+index.toString()+'-'+id).text(value.toString());//Добавляем текст ошибки
            $('#error_user_'+index.toString()+'-'+id).css('display', 'block');//Блок ошибки показываем пользователю
            $('#input_user_'+index.toString()+'-'+id).addClass('is-invalid');//Окрашиваем поле где ошибка в красный
        });
        return false;
    }
    //Функция которая очишает и убирает поля ошибок перед повторной отправкой на сервер
    function сleanErrorServerTreatment(id){
        var res = ['employeename','email','phone','address','password','prePassword','id_position'];
        //переберает поля с данными присланные с сервера
        $.each(res,function(index,value){
            console.log('Индекс: ' + index.toString() + '; Значение: ' + value.toString());
            $('#error_user_'+value.toString()+'-'+id).text('');//Убирает текст ошибки
            $('#error_user_'+value.toString()+'-'+id).css('display', 'none');//Блок ошибки скрываем от  пользователя
            $('#input_user_'+value.toString()+'-'+id).removeClass('is-invalid');//Убираем окрашивание у поля где ошибка была
        });
        return false;
    }
    //функция очистки полей после завершения добавления пользователя
    function сleanFieldsAdded(id){
        var res = ['employeename','email','phone','address','password','prePassword','id_position'];
        //переберает поля с данными присланные с сервера
        $.each(res,function(index,value){
            console.log('Индекс: ' + index.toString() + '; Значение: ' + value.toString());
            if(index == 6){
                $('#input_user_'+value.toString()+'-'+id).val(0);//убирает значение поля
            }else{
                $('#input_user_'+value.toString()+'-'+id).val('');//убирает значение поля
            }
            
        });
        return false;
    }
    //Функция применяет полученные данные с сервера о обновляет карточку
    function addUserCardDataServer(res,id){
        //перебирает поля с данными присланные с сервера
        $.each(res,function(index,value){
            console.log('Индекс: ' + index.toString() + '; Значение: ' + value.toString());
            $('#span_user_'+index.toString()+'-'+id).text(value.toString());//Заменяем текст в карточке на текст присланный с сервера
        });
        return false;
    }
    // Обработчик нажатия кнопки добавить нового сотрудника
    $('.my_heders_bloc').on('click', '#add_new_user', function(){
         var status_card = Number($('#status_card').val());
        console.log(status_card);
        if(status_card == 0){
            $('#Block_add_user').css('display', 'flex'); 
            var employeename = 'нового сотрудника'
            $('#status_card').val(1);
            $('#status_card').attr('data-user-card', employeename);
         return false;
        }else{
            var employeename = $('#status_card').attr('data-user-card');
            console.log(employeename);
            alert('Вы уже редактируете '+employeename);
            return false;
        }
    });
   //Обрабатуем нажатие на чекбокс редоктировать пороль или нет добовляем поля в форму 
    $('.my_content_bloc').on('click', '.form-check-input', function(){ 
       var buffer = this.id.split('-');
       console.log(buffer);
       var id = buffer[1];
       console.log(id); 
      if ($('#check_user_pass_change-'+id).is(':checked')){
            //alert('Включен');
            $('#check_user_pass_change_hidden-'+id).val(1); 
            $('#user_change_pass_block-'+id).css('display', 'block'); 
        }else{
           //alert('Выключен');
           $('#check_user_pass_change_hidden-'+id).val(0);
           $('#user_change_pass_block-'+id).css('display', 'none');
           //console.log( $('#input_user_pass-'+id));
           $('#input_user_password-'+id).val('');
           $('#input_user_prePassword-'+id).val('');
           //Сбрасываем ошибку к полю пароль
            $('#error_user_password-'+id).text('');
            $('#error_user_password-'+id).css('display', 'none');
            $('#input_user_password-'+id).removeClass('is-invalid');//Удаляем класс у инпута который подкрашивает его в красный
            //Сбрасываем ошибку к полю повторный ввод пароля
            $('#error_user_prePassword-'+id).text('');
            $('#error_user_prePassword-'+id).css('display', 'none');
            $('#input_user_prePassword-'+id).removeClass('is-invalid');//Удаляем класс у инпута который подкрашивает его в красный        
        }
      
   });
    //Возврашаяем поля в исходное положение
    function GetDataFromSpan(id){
        var res = ['employeename','email','phone','address','name_position'];
        $.each(res,function(index,value){
            console.log('Индекс: ' + index.toString() + '; Значение: ' + value.toString());
            console.log($('#span_user_'+value.toString()+'-'+id));
            if(index!=4){
                $('#input_user_'+value.toString()+'-'+id).val($('#span_user_'+value.toString()+'-'+id).text());
            }else{
                $('#option_select_'+$('#span_user_'+value.toString()+'-'+id).text()+'-'+id).prop('selected', true);
            }    
        });
        сleanErrorServerTreatment(id);
        $('#input_user_password-'+id).val('');
        $('#input_user_prePassword-'+id).val('');
        $('#check_user_pass_change-'+id).prop('checked', false);
        $('#user_change_pass_block-'+id).css('display', 'none');
        $('#check_user_pass_change_hidden-'+id).val(0);
        $('#span_user_alert_server-'+id).text('');
        $('#user_alert_server-'+id).css('display', 'none');
        return false;
    }
//конец обработки данных модуля user
