    //Задаем масску ввода для клсса phone
    $(".phone").mask("8(999)-999-99-99");
    //Обработчик нажатия кнопки добавить новый заказ
    $('.my_heders_bloc').on('click', '#add_new_orders', function(){
        if(GetStatusCard()){
            SetStatusCard(0,"");
            $('#Block_add_orders-0').show();
            $(window).scrollTop(0);
            $(this).tooltip('hide');
            $(this).blur();
            return false;
        }else{
            $(this).tooltip('hide');
            $(this).blur();
            return false;
        }
    });
    //Обработчик нажатия кнопки добавить еше один телефон
    $('.my_box_content').on('click', '.add_another_phone', function(){
        var id_orders = GetId($(this),1);
        var count_phone = Number($(this).attr('data-count-phone'));
        console.log('id_orders-'+id_orders+" count_phone-"+count_phone);
        addInputPhone(id_orders,count_phone);
        $(this).tooltip('update');
        $(this).tooltip('hide');
        $(this).blur();
        return false;
    });
    //Функция добавляет поле телефона для заполнения не больше трех полей одному клиенту
    function addInputPhone(id_orders,count_phone){
        var count = $('.orders_phone-'+id_orders).length;
        if(count<=2){
            var next = count_phone+1;
            var buttondelete=""+
                    "<a  id = 'delete_another_phone-"+id_orders+"-"+next+"' class='btn btn-dark delete_another_phone delete_another_phone-"+id_orders+" mx-1'  data-count-phone='"+next+"' data-toggle='tooltip' data-placement='right' title='Удалить телефон'>"+
                        "<img id ='menu_navbar_top' class='' src='/yii-application/backend/web/m_orders/img/minus.svg' alt='Удалить телефон'>"+
                    "</a>";
            var buttondeleteFirst=""+
                    "<a  id = 'delete_another_phone-"+id_orders+"-1' class='btn btn-dark delete_another_phone delete_another_phone-"+id_orders+" mx-1'  data-count-phone='"+next+"' data-toggle='tooltip' data-placement='right' title='Удалить телефон'>"+
                        "<img id ='menu_navbar_top' class='' src='/yii-application/backend/web/m_orders/img/minus.svg' alt='Удалить телефон'>"+
                    "</a>";
            var input =''+
                "<div id = 'div_orders_clients_phone-"+id_orders+"-"+next+"' class='div_orders_phone-"+id_orders+"'>"+     
                    "<p id='p_orders_clients_phone-"+id_orders+"-"+next+"' class='form-row my-2 orders_phone-"+id_orders+" orders_phone'>"+
                        "<img class='my_icon mx-1 my-2' src='/yii-application/backend/web/img/smartphone-call.svg'>"+
                        "<input id='input_orders_clients_phone-"+id_orders+"-"+next+"' name='ClientsPhonesEdit[phone_number-"+next+"]'  form='' class='form-control col-8 phone phone_input phone_input-"+id_orders+"' type='text' placeholder='*Введите номер телефона'>"+
                        "<p id = 'error_orders_clients_phone-"+id_orders+"-"+next+"' class='text-danger my-2 mx-2 error_orders_phone error_orders_phone-"+id_orders+"' style='display: none;'>Ошибка</p>"+
                    "</p>"+
                "</div>";
            $("#search_input_phone_number-"+id_orders).remove();
            $('#add_another_phone-'+id_orders).attr('data-count-phone',next);
            $('#delete_another_phone-'+id_orders).attr('data-count-phone',next);
            $("#div_orders_clients_phone-"+id_orders+"-"+count_phone).after(input); 
            $(("#input_orders_clients_phone-"+id_orders+"-"+next)).after(buttondelete);
            $('[data-toggle="tooltip"]').tooltip();
            $(".phone").mask("8(999)-999-99-99");
            if(count_phone==1){
                $(("#input_orders_clients_phone-"+id_orders+"-1")).after(buttondeleteFirst);
                $('[data-toggle="tooltip"]').tooltip();
            }    
            console.log(count_phone);
            console.log(input);
            return true;
        }else{
            alert("Больше трех телефонов клиенту добавлять нельзя");
            return true;
        }    
    }
    //Обработчик нажатия кнопки Удалить еше один телефон
    $('.my_content_bloc').on('click', '.delete_another_phone', function(){
        var id_orders = GetId($(this),1);
        var id_delete = GetId($(this),2);
        var count_phone = Number($(this).attr('data-count-phone'));
        console.log('id_orders-'+id_orders+" id_delete-"+id_delete);
        $(this).tooltip('update');
        $(this).tooltip('hide');
        $(this).blur();
        deleteInputPhone(id_orders,id_delete,count_phone);
        return false;
    });
    //Функция инпут телефона 
    function deleteInputPhone(id_orders,id_delete,count_phone){
        var count = $('.orders_phone-'+id_orders).length;
        console.log(count);
        $("#search_input_phone_number-"+id_orders).remove();
        if(count>1){
            $("#div_orders_clients_phone-"+id_orders+"-"+id_delete).remove();
            $('.div_orders_phone-'+id_orders).each(function(index){
                console.log($(this));
                $(this).attr('id',("div_orders_clients_phone-"+id_orders+"-"+(index+1)));
                $(this).find("input").attr('id',("input_orders_clients_phone-"+id_orders+"-"+(index+1)));
                $(this).find("input").attr('name',("ClientsPhonesEdit[phone_number-"+(index+1)+"]"));
                $(this).find("a").attr('id',("delete_another_phone-"+id_orders+"-"+(index+1)));
                $(this).find("p .error_orders_phone").attr('id',("error_orders_phone-"+id_orders+"-"+(index+1)));
                $(this).find("p .orders_phone").attr('id',("p_orders_clients_phone-"+id_orders+"-"+(index+1)));
                console.log( index + ": ");
            });
            $('#add_another_phone-'+id_orders).attr('data-count-phone',(count-1));
            if(count==2){
                $("#delete_another_phone-"+id_orders+"-1").remove();
            }
        }
        
    }
    
    //Обработчик нажатия кнопки редактировать в userbox
    $('.my_content_bloc').on('click', '.orders_edit_button', function(){
        var id = GetId($(this),1);
        if(GetStatusCard()){
            SetStatusCard(id,"#span_orders_id_orders_text-");
            $('#user_card_button_edit_print-'+id).hide();
            $('#orders_content-'+id).hide();        
            $('#orders_cancel_button_card_apply-'+id).show();
            $('#orders_form-'+id).show();
            return false;
        }else{
            return false;
        }
       
    });
    
    //Обработчик нажатия кнопки Применить в userbox
    $('.my_content_bloc').on('click', '.orders_apply_button', function(){
        //alert("Вы нажали кнопку пременить");
        var id = GetId($(this),1);
        var arrayFieldsChecked = ['clients_name-','clients_phone-','clients_email-','clients_address-','brand_name-','device_type-']; 
        if(formFieldCheck(id,arrayFieldsChecked)){
            alert("Проверка Проверка прошла успешно");
        }else{
            alert("Проверка Проверка прошла не успешно");
        }
    });
    
    //Обработчик ввода текста в input_clients_name
    $('.my_box_content').on('keyup', '.input_clients_name', function(eventObject){
        var id = GetId($(this),1);
        var data={};
        if(eventObject.which != 27){
        console.log($("#input_orders_clients_name-"+id).val());
        data={  'SearchInputOrders[id_orders]':id,
                'SearchInputOrders[clients_name]':$("#input_orders_clients_name-"+id).val(),
                '_csrf-backend':$('input[name="_csrf-backend"]').val()
            };       
        console.log(data);
        $.ajax({
                url: '/yii-application/backend/web/orders/default/takenameclient',
                type: 'POST',
                data: data,
                success: function(res){
                    console.log(res);
                    if(res[0]!=0){
                        $("#search_input_clients_name-"+id).remove();
                        $("#input_orders_clients_name-"+id).after(res['msg']);
                    }else{
                        $("#search_input_clients_name-"+id).remove();
                        return false;
                    }    
                },
                error: function(){
                    alert('По неизвестной причине сервер не ответил обратитесь к админу.');
                }
            });
        }else{
            $("#search_input_clients_name-"+id).remove();
            return false;
        }    
    });
    
    
    //Обработчик нажатия на option в подсказке clients_name в userbox
    $('.my_box_content').on('click', '.option_clients_name', function(){
        var id_orders = GetId($(this).parent(),1);
        var id_clients = GetId($(this),1);
        console.log(id_orders);
        console.log(id_clients);
        var data={};
        data={  'SearchClientsSubstitution[id_orders]':id_orders,
                'SearchClientsSubstitution[id_clients]':id_clients,
                '_csrf-backend':$('input[name="_csrf-backend"]').val()
            };       
        console.log(data);
        $.ajax({
            url: '/yii-application/backend/web/orders/default/takeclient',
            type: 'POST',
            data: data,
            success: function(res){
                console.log(res);
                if(res[0]!=0){
                    $("#search_input_clients_name-"+id_orders).remove();
                    $("#orders_clients_form-"+id_orders).remove();
                    $("#form-update_orders-"+id_orders).prepend(res['msg']);
                }else{
                    var numberAlert = getRandomArbitary(1, 50);
                    var namePost = CreateErrorCards(res['msg'],id_orders,numberAlert);
                    setTimeout(postDelete, 3000,namePost);
                }    
            },
            error: function(){
                alert('По неизвестной причине сервер не ответил обратитесь к админу.');
            }
        });
    });
    
    //Обработчик нажатия на option в подсказке input_clients_email в userbox
    $('.my_box_content').on('click', '.option_clients_email', function(){
        var id_orders = GetId($(this).parent(),1);
        var id_clients = GetId($(this),1);
        console.log(id_orders);
        console.log(id_clients);
        var data={};
        data={  'SearchClientsSubstitution[id_orders]':id_orders,
                'SearchClientsSubstitution[id_clients]':id_clients,
                '_csrf-backend':$('input[name="_csrf-backend"]').val()
            };       
        console.log(data);
        $.ajax({
            url: '/yii-application/backend/web/orders/default/takeclient',
            type: 'POST',
            data: data,
            success: function(res){
                console.log(res);
                if(res[0]!=0){
                    $("#search_input_clients_name-"+id_orders).remove();
                    $("#orders_clients_form-"+id_orders).remove();
                    $("#form-update_orders-"+id_orders).prepend(res['msg']);
                }else{
                    var numberAlert = getRandomArbitary(1, 50);
                    var namePost = CreateErrorCards(res['msg'],id_orders,numberAlert);
                    setTimeout(postDelete, 3000,namePost);
                }    
            },
            error: function(){
                alert('По неизвестной причине сервер не ответил обратитесь к админу.');
            }
        });
    });
    
    //Обработчик ввода текста в input_phone
    $('.my_box_content').on('keyup', '.phone_input', function(eventObject){        
        var id_orders = GetId($(this),1);
        var id_phone = GetId($(this),2);
        if(eventObject.which != 27){
        console.log("id_phone="+id_phone);
        console.log($(this).val());
        var data={};
        data={  'SearchInputOrders[id_orders]':id_orders,
                'SearchInputOrders[phone_number]':$(this).val(),
                '_csrf-backend':$('input[name="_csrf-backend"]').val()
            };       
        console.log(data);
        $.ajax({
                url: '/yii-application/backend/web/orders/default/takephonenumber',
                type: 'POST',
                data: data,
                success: function(res){
                    console.log(res);
                    if(res[0]!=0){
                        $("#search_input_phone_number-"+id_orders).remove();
                        console.log($("#p_orders_clients_phone-"+id_orders+"-"+id_phone));
                        $("#p_orders_clients_phone-"+id_orders+"-"+id_phone).after(res['msg']);                        
                    }else{
                        $("#search_input_phone_number-"+id_orders).remove();
                    }    
                },
                error: function(){
                    alert('По неизвестной причине сервер не ответил обратитесь к админу.');
                }
            });
        }else{
            $("#search_input_phone_number-"+id_orders).remove();
        }    

    });
    
    //Обработчик ввода текста в input_clients_email
    $('.my_box_content').on('keyup', '.input_clients_email', function(eventObject){
        var id = GetId($(this),1);
        var data={};
        if(eventObject.which != 27){
        console.log($("#input_orders_clients_email-"+id).val());
        data={  'SearchInputOrders[id_orders]':id,
                'SearchInputOrders[clients_email]':$("#input_orders_clients_email-"+id).val(),
                '_csrf-backend':$('input[name="_csrf-backend"]').val()
            };       
        console.log(data);
        
        $.ajax({
                url: '/yii-application/backend/web/orders/default/takeemailclient',
                type: 'POST',
                data: data,
                success: function(res){
                    console.log(res);
                    if(res[0]!=0){
                        $("#search_input_clients_email-"+id).remove();
                        $("#input_orders_clients_email-"+id).after(res['msg']);
                    }else{
                        $("#search_input_clients_email-"+id).remove();
                        return false;
                    }    
                },
                error: function(){
                    alert('По неизвестной причине сервер не ответил обратитесь к админу.');
                }
            });
      
        }else{
            $("#search_input_clients_email-"+id).remove();
            return false;
        }
            
    });
    
    //ССылка создае ошибку в карточке заказа
    function CreateErrorCards(msg,id_orders,numberAlert){
    var result = ""+    
        "<div id='orders_alert_server-"+id_orders+"-"+numberAlert+"' class='alert alert-danger' role='alert'>"+
            "<span id='span_user_alert_server'>"+msg+"</span>"+
        "</div>";
        $("#orders_form-"+id_orders).prepend(result);
        return "#orders_alert_server-"+id_orders+"-"+numberAlert;
    }
    //Функция удаляет созданую ошибку 
    function postDelete(str){
        $(str).remove();    
    }
    //Функция случайного числа
    function getRandomArbitary(min, max)
    {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }
    
    /** 
     * @param {dom element} obg дом элемент
     * @param {int} number число которое характерезует в каком мести мтроки обозначен id
     * @returns Возврашаем id передоваемого елемента
     */
    function GetId(obg,number){
        obg = obg.first();
        var buffer = (obg.attr('id')).split('-');
        console.log(buffer);
        var id = buffer[number];
        console.log(id);
        return id;
    }
    /**
     * Функция устанавливает значения 
     * в скрытый статус открытой
     * либо закрытой карты
     */
    function SetStatusCard(id,StartSelector){
        var status_card = Number($('#status_card').val());
        console.log(status_card);
        if(status_card == 0){
            if(id!=0){
                var employeename ='Вы уже редактируете '+$(StartSelector+id).text();
            }else{
                var employeename = "Вы добавляете новый заказ";
            }    
            console.log(employeename);
            $('#status_card').val(1);
            $('#status_card').attr('data-user-card', employeename);
        }else{
            $('#status_card').val(0);
            $('#status_card').attr('data-user-card', '');
        }
        
    }
    /**
     * Функция проверяет открыта ли карточка если 
     * открыта выводит сообшени какая карточка открыта
     * и возврашает ложь
     */
    function GetStatusCard(){
        var status_card = Number($('#status_card').val());
        console.log(status_card);
        if(status_card == 0){
            return true;
        }else{
            var employeename = $('#status_card').attr('data-user-card');
            console.log(employeename);
            alert(employeename);
            return false;
        }
    }
    /**
     * Функция проверяет поля редактируемого пользователя
     * */
    function formFieldCheck(id,arrayFieldsChecked){
        var arrayError={};
        var countError = 0;
        $.each(arrayFieldsChecked, function(i, val) {            
            console.log(i+" - "+val);
            switch ("input_orders_"+val) {
                case "input_orders_clients_name-":
                    if(empty($('#input_orders_'+val+id).val())){
                        countError++;
                        arrayError['clients_name-'+id]='Заполните ФИО клиента';
                    }
                    break;
                case "input_orders_clients_phone-":
                    $(".phone_input-"+id).each(function(index){
                        if(empty($('#input_orders_'+val+id+"-"+(index+1)).val())){
                            countError++;
                            arrayError['clients_phone-'+id+"-"+(index+1)]='Заполните телефон клиента';
                        }
                    });
                    break;
                case "input_orders_clients_email-":
                    if(empty($('#input_orders_'+val+id).val())){
                        countError++;
                        arrayError['clients_email-'+id]='Заполните email клиента';
                    }else{
                        if(emailEmpty($('#input_orders_'+val+id).val())){
                            countError++;
                            arrayError['clients_email-'+id]='Вы неправильно ввели email клиента';
                        }
                    }
                    break;
                case "input_orders_clients_address-":
                    if(empty($('#input_orders_'+val+id).val())){
                        countError++;
                        arrayError['clients_address-'+id]='Заполните адрес клиента';
                    }
                    break;
                case "input_orders_brand_name-":
                    if(empty($('#input_orders_'+val+id).val())){
                        countError++;
                        arrayError['brand_name-'+id]='Заполните поле Бренд';
                    }
                    break;
                case "input_orders_device_type-":
                    if(empty($('#input_orders_'+val+id).val())){
                        countError++;
                        arrayError['device_type-'+id]='Заполните поле тип устройства';
                    }
                    break;
            }            
        });
        if(countError == 0){
            return true
        }else{
            errorServerTreatment(arrayError,id);
            return false
        }
    }
    //Функция обработки полученных ошибок с сервера
    function errorServerTreatment(arrayError){
        //перебирает поля с данными, присланные с сервера
        $.each(arrayError,function(index,value){
            console.log('Индекс: ' + index.toString() + '; Значение: ' + value.toString());
            $('#error_orders_'+index.toString()).text(value.toString());//Добавляем текст ошибки
            $('#error_orders_'+index.toString()).show();//Блок ошибки показываем пользователю
            console.log($('#error_orders_'+index.toString()));
            $('#input_orders_'+index.toString()).addClass('is-invalid');//Окрашиваем поле где ошибка в красный
            console.log($('#input_orders_'+index.toString()));
        });
        return false;
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
    //Функция  кнопки прокрутки    
    $(function() {
    // при нажатии на кнопку scrollup
    $('.scroll_to_up').click(function() {
        // переместиться в верхнюю часть страницы
        $("html, body").animate({
          scrollTop:0
        },1000);
    });
    });
    $(window).scroll(function() {
        // при прокрутке окна (window)
        // если пользователь прокрутил страницу более чем на 200px
        if ($(this).scrollTop()>200) {
            // то сделать кнопку scroll_to_up видимой
            $('.scroll_to_up').fadeIn();
        }
        // иначе скрыть кнопку scrollup
        else {
            $('.scroll_to_up').fadeOut();
        }
    });

    //чтобы tooltip пропадал при зажимании кнопок
    $('[data-toggle="tooltip"]').on("click", function() {
        $(this).tooltip('hide');
        $(this).blur();
    });

    //Функция проверки email
    function emailEmpty(email){
        var re =  /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        return !re.test(email);
    }
    
    //Обрабатуем нажатие на чекбокс диагностика и ремонт 
    $('.my_content_bloc').on('click', '.check_repair_type', function(){
        //Вытаскиваем id карточки заказа
        var id = GetId($(this),1);
        console.log(id);
        //вытаскиваем имя с которым производились манипуляции
        var inputChecked = GetId($(this),0);
        console.log(inputChecked);
        console.log($("#orders_hidden_repair_type-"+id));
        //массив для работы с противоположным чекбоксом
        var arrayInputChecked = {check_diagnostics:'check_repair',check_repair:'check_diagnostics'}
        console.log("#"+arrayInputChecked[inputChecked]+'-'+id);
        // 1-1 3 при нажатие на пустой чекбокс
        if ($(this).is(':checked') && $("#"+arrayInputChecked[inputChecked]+'-'+id).is(':checked')){
            //alert('Подставим 3');
            $("#orders_hidden_repair_type-"+id).val(3);
            return true;
        }
        // 1-0 1 или 0-1 2 при нажатие на пустой чекбокс
        if ($(this).is(':checked') && !$("#"+arrayInputChecked[inputChecked]+'-'+id).is(':checked')){
            if(inputChecked.localeCompare('check_diagnostics')==0){
                //alert('Подставим 1');
                $("#orders_hidden_repair_type-"+id).val(1);
                return true;
            }
            if(inputChecked.localeCompare('check_repair')==0){
                //alert('Подставим 2');
                $("#orders_hidden_repair_type-"+id).val(2);
                return true;
            }
        }
        // 1-0 1 или 0-1 2 при нажатие на не пустой чекбокс
        if (!$(this).is(':checked') && $("#"+arrayInputChecked[inputChecked]+'-'+id).is(':checked')){
            if(arrayInputChecked[inputChecked].localeCompare('check_diagnostics')==0){
                //alert('Подставим 1');
                $("#orders_hidden_repair_type-"+id).val(1);
                return true;
            }
            if(arrayInputChecked[inputChecked].localeCompare('check_repair')==0){
                //alert('Подставим 2');
                $("#orders_hidden_repair_type-"+id).val(2);
                return true;
            }
        }
        // 0-0 0 при нажатие на не пустой чекбокс
        if (!$(this).is(':checked') && !$("#"+arrayInputChecked[inputChecked]+'-'+id).is(':checked')){
            //alert('Подставим 0');
            $("#orders_hidden_repair_type-"+id).val(0);
            return true;
        }
    });
    
    //Обработчик ввода текста в input_clients_name
    $('.my_box_content').on('keyup', '.input_orders_brand_name', function(eventObject){
        var id = GetId($(this),1);
        var data={};
        if(eventObject.which != 27){
        console.log($("#input_orders_brand_name-"+id).val());
        data={  'SearchInputOrders[id_orders]':id,
                'SearchInputOrders[brand_name]':$("#input_orders_brand_name-"+id).val(),
                '_csrf-backend':$('input[name="_csrf-backend"]').val()
            };       
        console.log(data);
        
        $.ajax({
                url: '/yii-application/backend/web/orders/default/takenamebrands',
                type: 'POST',
                data: data,
                success: function(res){
                    console.log(res);
                    if(res[0]!=0){
                        $("#search_input_brand_name-"+id).remove();
                        $("#div_orders_brand_name-"+id).after(res['msg']);
                    }else{
                        $("#search_input_brand_name-"+id).remove();
                        return false;
                    }    
                },
                error: function(){
                    alert('По неизвестной причине сервер не ответил обратитесь к админу.');
                }
            });
        }else{
            $("#search_input_brand_name-"+id).remove();
            return false;
        }    
    });
    
    //Обработчик отслеживает получение фокуса input_clients_name
    $('.my_box_content').on('focusin', '.input_orders', function(e){
        var id_orders = GetId($(this),1);
        console.log($("#search_input_clients_name-"+id_orders));
        if($("#search_input_phone_number-"+id_orders).is("#search_input_phone_number-"+id_orders)){
            $("#search_input_phone_number-"+id_orders).remove();
        }
        if($("#search_input_clients_email-"+id_orders).is("#search_input_clients_email-"+id_orders)){
            $("#search_input_clients_email-"+id_orders).remove();
        }
        if($("#search_input_clients_name-"+id_orders).is("#search_input_clients_name-"+id_orders)){
            $("#search_input_clients_name-"+id_orders).remove();
        }
        if($("#search_input_brand_name-"+id_orders).is("#search_input_brand_name-"+id_orders)){
            $("#search_input_brand_name-"+id_orders).remove();
        }
        if($("#search_input_device_type-"+id_orders).is("#search_input_device_type-"+id_orders)){
            $("#search_input_device_type-"+id_orders).remove();
        }
        if($("#search_input_devices_model-"+id_orders).is("#search_input_devices_model-"+id_orders)){
            $("#search_input_devices_model-"+id_orders).remove();
        }
    });
    
    //Обработчик нажатия на option в подсказке input_clients_email в userbox
    $('.my_box_content').on('click', '.option_brand_name', function(){
        var id_orders = GetId($(this).parent(),1);
        var id_brand = GetId($(this),1);
        console.log(id_orders);
        console.log(id_brand);
        var data={};
        data={  'SearchBrendSubstitution[id_orders]':id_orders,
                'SearchBrendSubstitution[id_brand]':id_brand,
                '_csrf-backend':$('input[name="_csrf-backend"]').val()
            };       
        console.log(data);
        
        $.ajax({
            url: '/yii-application/backend/web/orders/default/takebrend',
            type: 'POST',
            data: data,
            success: function(res){
                console.log(res);                
                if(res[0]!=0){
                    console.log($("#div_orders_brand_name-"+id_orders+" p"));
                    $("#search_input_brand_name-"+id_orders).remove();
                    $("#div_orders_brand_name-"+id_orders+" p").remove();
                    $("#div_orders_brand_name-"+id_orders).append(res['msg'])
                }else{
                    var numberAlert = getRandomArbitary(1, 50);
                    var namePost = CreateErrorCards(res['msg'],id_orders,numberAlert);
                    setTimeout(postDelete, 3000,namePost);
                }
            },
            error: function(){
                alert('По неизвестной причине сервер не ответил обратитесь к админу.');
            }
        });
    });
    
    //Обработчик ввода текста в input_device_type_name
    $('.my_box_content').on('keyup', '.input_device_type_name', function(eventObject){
        var id = GetId($(this),1);
        console.log(id);
        var data={};
        if(eventObject.which != 27){
        console.log($("#input_orders_device_type-"+id).val());
        data={  'SearchInputOrders[id_orders]':id,
                'SearchInputOrders[device_type]':$("#input_orders_device_type-"+id).val(),
                '_csrf-backend':$('input[name="_csrf-backend"]').val()
            };       
        console.log(data);        
        $.ajax({
                url: '/yii-application/backend/web/orders/default/takedevicetype',
                type: 'POST',
                data: data,
                success: function(res){
                    console.log(res);
                    if(res[0]!=0){
                        $("#search_input_device_type-"+id).remove();
                        $("#div_orders_device_type_name-"+id).after(res['msg']);
                    }else{
                        $("#search_input_device_type-"+id).remove();
                        return false;
                    }
                },
                error: function(){
                    alert('По неизвестной причине сервер не ответил обратитесь к админу.');
                }
            });
        }else{
            $("#search_input_device_type-"+id).remove();
            return false;
        }   
    });
    
    //Обработчик нажатия на option в подсказке input_device_type_name в userbox
    $('.my_box_content').on('click', '.option_device_type', function(){
        var id_orders = GetId($(this).parent(),1);
        var id_device_type = GetId($(this),1);
        console.log(id_orders);
        console.log(id_device_type);
        var data={};
        data={  'SearchDeviceTypeSubstitution[id_orders]':id_orders,
                'SearchDeviceTypeSubstitution[id_device_type]':id_device_type,
                '_csrf-backend':$('input[name="_csrf-backend"]').val()
            };       
        console.log(data);
        $.ajax({
            url: '/yii-application/backend/web/orders/default/takedevicet',
            type: 'POST',
            data: data,
            success: function(res){
                console.log(res);
                if(res[0]!=0){
                    console.log($("#div_orders_device_type_name-"+id_orders+" p"));
                    $("#search_input_device_type-"+id_orders).remove();
                    $("#div_orders_device_type_name-"+id_orders+" p").remove();
                    $("#div_orders_device_type_name-"+id_orders).append(res['msg'])
                }else{
                    var numberAlert = getRandomArbitary(1, 50);
                    var namePost = CreateErrorCards(res['msg'],id_orders,numberAlert);
                    setTimeout(postDelete, 3000,namePost);
                }
            },
            error: function(){
                alert('По неизвестной причине сервер не ответил обратитесь к админу.');
            }
        });
    });
    
    //Обработчик ввода текста в input_device_type_name
    $('.my_box_content').on('keyup', '.input_orders_devices_model', function(eventObject){
        var id = GetId($(this),1);
        console.log(id);
        var data={};
        if(eventObject.which != 27){
        console.log($("#input_orders_device_type-"+id).val());
        data={  'SearchInputOrders[id_orders]':id,
                'SearchInputOrders[devices_model]':$("#input_orders_devices_model-"+id).val(),
                'SearchInputOrders[brands_id]':$("#orders_id_brands-"+id).val(),
                'SearchInputOrders[devices_type_id]':$("#orders_id_device_type-"+id).val(),
                '_csrf-backend':$('input[name="_csrf-backend"]').val()
            };       
        console.log(data);
        
        $.ajax({
                url: '/yii-application/backend/web/orders/default/takedevicemodel',
                type: 'POST',
                data: data,
                success: function(res){
                    console.log(res);
                    if(res[0]!=0){
                        $("#search_input_devices_model-"+id).remove();
                        $("#div_orders_devices_model-"+id).after(res['msg']);
                    }else{
                        $("#search_input_devices_model-"+id).remove();
                        return false;
                    }
                },
                error: function(){
                    alert('По неизвестной причине сервер не ответил обратитесь к админу.');
                }
            });
        }else{
            $("#search_input_devices_model-"+id).remove();
            return false;
        }   
    });
    
    //Обработчик нажатия на option в подсказке input_device_type_name в userbox
    $('.my_box_content').on('click', '.option_devices_model', function(){
        var id_orders = GetId($(this).parent(),1);
        var id_devices_model = GetId($(this),1);
        console.log(id_orders);
        console.log(id_devices_model);
        var data={};
        data={  'SearchDeviceSubstitution[id_orders]':id_orders,
                'SearchDeviceSubstitution[id_devices]':id_devices_model,
                '_csrf-backend':$('input[name="_csrf-backend"]').val()
            };       
        console.log(data);        
        $.ajax({
            url: '/yii-application/backend/web/orders/default/takedevices',
            type: 'POST',
            data: data,
            success: function(res){
                console.log(res);
                if(res[0]!=0){
                    console.log($("#div_orders_devices-"+id_orders+" div"));
                    $("#search_input_devices_model-"+id_orders).remove();
                    $("#div_orders_devices-"+id_orders+" div").remove();
                    $("#div_orders_devices-"+id_orders).append(res['msg'])
                }else{
                    var numberAlert = getRandomArbitary(1, 50);
                    var namePost = CreateErrorCards(res['msg'],id_orders,numberAlert);
                    setTimeout(postDelete, 3000,namePost);
                }
            },
            error: function(){
                alert('По неизвестной причине сервер не ответил обратитесь к админу.');
            }
        });
    });
   
    