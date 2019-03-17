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
                        "<input id='input_orders_clients_phone-"+id_orders+"-"+next+"' data-input-name = 'clients_phone' name='ClientsPhonesEdit[phone_number]["+next+"]'  form='form_orders-"+id_orders+"' class='form-control col-8 input_orders phone phone_input phone_input-"+id_orders+"' type='text' placeholder='*Введите номер телефона'>"+
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
                $(this).find("input").attr('name',("ClientsPhonesEdit[phone_number]["+(index+1)+"]"));
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
        var arrayFieldsChecked = ['clients_name-','clients_phone-','clients_email-','clients_address-','brand_name-','device_type_name-','devices_model-','serial_numbers_name-','malfunction-','appearance-','user_engener_id-']; 
        if(true/*formFieldCheck(id,arrayFieldsChecked)*/){
            alert("Проверка Проверка прошла успешно");
            var data = $('#form_orders-'+id).serialize();
            console.log(data);
            $.ajax({
                        url: '/yii-application/backend/web/orders/default/create',
                        type: 'POST',
                        data: data,
                        success: function(res){
                            console.log(res['msg']);
                            console.log(res['errors']);
                        },
                        error: function(){
                            alert('По неизвестной причине сервер не ответил обратитесь к админу.');
                        }
                    });
        }else{
            alert("Проверка Проверка прошла не успешно");
        }
    });
        
//Обработчик нажатия на option в подсказке clients_name в userbox для всех option
$('.my_box_content').on('click', '.input_orders_option', function(){
        var id_orders = GetId($(this).parent(),1);
        var id_input = GetId($(this),1);
        console.log("id_orders - "+id_orders);
        console.log("id_clients - "+id_input);
        var data=GetDataOption($(this),id_orders,id_input);
        console.log(data);
        SendToServerOption($(this),data,id_orders);
        
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
function getRandomArbitary(min, max){
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
                case "input_orders_device_type_name-":
                    if(empty($('#input_orders_'+val+id).val())){
                        countError++;
                        arrayError['device_type_name-'+id]='Заполните поле тип устройства';
                    }
                    break;
                case "input_orders_devices_model-":
                    if(empty($('#input_orders_'+val+id).val())){
                        countError++;
                        arrayError['devices_model-'+id]='Заполните поле модель устройсва';
                    }
                    break;
                case "input_orders_serial_numbers_name-":
                    if(empty($('#input_orders_'+val+id).val())){
                        countError++;
                        arrayError['serial_numbers_name-'+id]='Заполните поле серийный номер';
                    }
                    break;
                case "input_orders_malfunction-":
                    $(".malfunction_input-"+id).each(function(index){
                        if(empty($('#input_orders_'+val+id+"-"+(index+1)).val())){
                            countError++;
                            arrayError['malfunction-'+id+"-"+(index+1)]='Заполните поле заявленная неисправность';
                        }
                    });
                    break;
                case "input_orders_appearance-":
                    if(empty($('#input_orders_'+val+id).val())){
                        countError++;
                        arrayError['appearance-'+id]='Заполните поле внешний вид';
                    }
                    break;
                case "input_orders_user_engener_id-":
                    console.log("Проверка user_engener_id- -"+$('#input_orders_'+val+id).val());
                    if(empty($('#input_orders_'+val+id).val())){
                        countError++;
                        arrayError['user_engener_id-'+id]='Вы не выбрали инженера для ремонта';
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
        
//Обработчик отслеживает получение фокуса input_clients_name
$('.my_box_content').on('focusin', '.input_orders', function(){
        var id_orders = GetId($(this),1);
        console.log($("#search_input_clients_name-"+id_orders));
        if($("#search_input_clients_phone-"+id_orders).is("#search_input_clients_phone-"+id_orders)){
            $("#search_input_clients_phone-"+id_orders).remove();
        }
        if($("#search_input_clients_email-"+id_orders).is("#search_input_clients_email-"+id_orders)){
            $("#search_input_clients_email-"+id_orders).remove();
        }
        if($("#search_input_clients_name-"+id_orders).is("#search_input_clients_name-"+id_orders)){
            $("#search_input_clients_name-"+id_orders).remove();
        }
        if($("#search_input_name_brands-"+id_orders).is("#search_input_name_brands-"+id_orders)){
            $("#search_input_name_brands-"+id_orders).remove();
        }
        if($("#search_input_device_type-"+id_orders).is("#search_input_device_type-"+id_orders)){
            $("#search_input_device_type-"+id_orders).remove();
        }
        if($("#search_input_devices_model-"+id_orders).is("#search_input_devices_model-"+id_orders)){
            $("#search_input_devices_model-"+id_orders).remove();
        }
        if($("#search_input_serial_numbers_name-"+id_orders).is("#search_input_serial_numbers_name-"+id_orders)){
            $("#search_input_serial_numbers_name-"+id_orders).remove();
        }
        if($("#search_input_malfunction-"+id_orders).is("#search_input_malfunction-"+id_orders)){
            $("#search_input_malfunction-"+id_orders).remove();
        }
    });
        
$('.my_box_content').on('keyup', '.input_orders', function(eventObject){
    var inputName = $(this).attr('data-input-name');
    var notInput = ['clients_address','appearance','special_notes'];
    if(notInput.indexOf( inputName ) == -1){
        switch (eventObject.which){
            case 27:
                EscInputOrders($(this));
                break;
            case 8:
                DeleteLetterInput($(this));
            case 46:
                DeleteLetterInput($(this));
            default:
                var data={};
                data=GetDataKeyUP($(this)); 
                if(data){
                    console.log(data);
                    SendToServerSelected($(this),data);
                }    
                break;
        }
    }
});

//Функциия следить за действиями при удалении в input
function DeleteLetterInput(setInput){
    setInput = setInput.first();
    var id = GetId(setInput,1);
    var InputName = setInput.attr('data-input-name');
    switch (InputName){
    case 'clients_name':
        break;
    case 'clients_phone':
        break;
    case 'clients_email':
        break;
    case 'name_brands':
        $("#orders_id_brands-"+id).val(0);
        $("#orders_id_devices-"+id).val(0);
        $("#input_orders_devices_model-"+id).val('');
        break;
    case 'device_type_name':
        $("#orders_id_device_type-"+id).val(0);
        $("#orders_id_devices-"+id).val(0);
        $("#input_orders_devices_model-"+id).val('');
        break;
    case 'devices_model':
        $("#orders_id_brands-"+id).val(0);
        $("#orders_id_device_type-"+id).val(0);
        $("#input_orders_brand_name-"+id).val('');
        $("#input_orders_device_type_name-"+id).val('');
        break;
    case 'serial_numbers_name':
        $("#orders_hidden_serrial_nambers_id-"+id).val(0);
        break;
    case 'malfunction':
        var id_malfunction_card = GetId(setInput,2);  
        $("#orders_claimed_malfunction_id-"+id+"-"+id_malfunction_card).val(0);
        break;    
    }
}

//Функция формирует данные для отправки на сервер для формирования списка выбора
function GetDataKeyUP(setInput){
    setInput = setInput.first();
    var id = GetId(setInput,1);
    var InputName = setInput.attr('data-input-name');
    var data = {};
    switch (InputName){
    case 'clients_name':
        data={
            'SearchInputOrders[id_orders]':id,
            'SearchInputOrders[clients_name]':setInput.val(),
            '_csrf-backend':$('input[name="_csrf-backend"]').val()
        };
        return data;
        break;
    case 'clients_phone':
        data={  
            'SearchInputOrders[id_orders]':id,
            'SearchInputOrders[phone_number]':setInput.val(),
            '_csrf-backend':$('input[name="_csrf-backend"]').val()
            };
        return data;
        break;
    case 'clients_email':
        data={  
            'SearchInputOrders[id_orders]':id,
            'SearchInputOrders[clients_email]':setInput.val(),
            '_csrf-backend':$('input[name="_csrf-backend"]').val()
        };
        return data;
        break;
    case 'name_brands':
        data={  
            'SearchInputOrders[id_orders]':id,
            'SearchInputOrders[brand_name]':$("#input_orders_brand_name-"+id).val(),
            '_csrf-backend':$('input[name="_csrf-backend"]').val()
        };
        return data;
        break;
    case 'device_type_name':
        data={  
            'SearchInputOrders[id_orders]':id,
            'SearchInputOrders[device_type]':$("#input_orders_device_type_name-"+id).val(),
            '_csrf-backend':$('input[name="_csrf-backend"]').val()
        };
        return data;
        break;
    case 'devices_model':
        data={  
            'SearchInputOrders[id_orders]':id,
            'SearchInputOrders[devices_model]':$("#input_orders_devices_model-"+id).val(),
            'SearchInputOrders[brands_id]':$("#orders_id_brands-"+id).val(),
            'SearchInputOrders[devices_type_id]':$("#orders_id_device_type-"+id).val(),
            '_csrf-backend':$('input[name="_csrf-backend"]').val()
        };
        return data;
        break;
    case 'serial_numbers_name':
        data={  
            'SearchInputOrders[id_orders]':id,
            'SearchInputOrders[devise_id]':$("#orders_id_devices-"+id).val(),
            'SearchInputOrders[serial_numbers_name]':$("#input_serial_numbers_name-"+id).val(),
            '_csrf-backend':$('input[name="_csrf-backend"]').val()
        };
        return data;
        break;
    case 'malfunction':        
        var id_malfunction_card = GetId(setInput,2);
        var valHidden = Number($("#orders_claimed_malfunction_id-"+id+"-"+id_malfunction_card).val());
        if(valHidden==0){
            data={
                'SearchInputOrders[id_orders]':id,
                'SearchInputOrders[id_malfunction_card]':id_malfunction_card,
                'SearchInputOrders[claimed_malfunction_name]':setInput.val(),
                '_csrf-backend':$('input[name="_csrf-backend"]').val()
            }; 
            return data;
        }else{
            var a = $("#input_orders_malfunction-"+id+"-"+id_malfunction_card).attr('data-input');
            $("#input_orders_malfunction-"+id+"-"+id_malfunction_card).val(a);
            alert("В одно поле нельзя добавлять несколько заявленных неисправностей");
            return false;
        }   
        break;
    }
}
//Функция формирует данные для отправки на сервер для получения данных по  заказу
function GetDataOption(setInput,id_orders,id_input){
    setInput = setInput.first();
    var InputName = setInput.attr('data-input-name');
    var data = {};
    switch (InputName){
        case 'clients_name':
            data={  
                'SearchClientsSubstitution[id_orders]':id_orders,
                'SearchClientsSubstitution[id_clients]':id_input,
                '_csrf-backend':$('input[name="_csrf-backend"]').val()
            };
            return data;
            break;
        case 'name_brands':
            data={  
                'SearchBrendSubstitution[id_orders]':id_orders,
                'SearchBrendSubstitution[id_brand]':id_input,
                '_csrf-backend':$('input[name="_csrf-backend"]').val()
            };
            return data;
            break;
        case 'device_type_name':
            data={  
                'SearchDeviceTypeSubstitution[id_orders]':id_orders,
                'SearchDeviceTypeSubstitution[id_device_type]':id_input,
                '_csrf-backend':$('input[name="_csrf-backend"]').val()
            };
            return data;
            break;
        case 'devices_model':
            data={  
                'SearchDeviceSubstitution[id_orders]':id_orders,
                'SearchDeviceSubstitution[id_devices]':id_input,
                '_csrf-backend':$('input[name="_csrf-backend"]').val()
            };
            return data;
            break;
        case 'serial_numbers_name':
            data={  
                'SearchSerialNumbers[id_orders]':id_orders,
                'SearchSerialNumbers[id_serial_numbers]':id_input,
                '_csrf-backend':$('input[name="_csrf-backend"]').val()
            };
            return data;
            break;
        case 'malfunction':
            var id_malfunction_card = GetId(setInput,2);
            data={  
                'SearchСlaimedMalfunction[id_orders]':id_orders,
                'SearchСlaimedMalfunction[id_malfunction_card]':id_malfunction_card,
                'SearchСlaimedMalfunction[id_claimed_malfunction]':id_input,
                '_csrf-backend':$('input[name="_csrf-backend"]').val()
            };
            return data;
            break;    
    }
}
//Функция формирует действия при нажатия ESC в поле input
function EscInputOrders(setInput){
    setInput = setInput.first();
    var id = GetId(setInput,1);
    var InputName = setInput.attr('data-input-name');
    $("#search_input_"+InputName+"-"+id).remove();
    return false;
}
   
function SendToServerSelected(setInput,data){
    setInput = setInput.first();
    var id = GetId(setInput,1);
    var InputName = setInput.attr('data-input-name');
    var urlLast = '';
    switch (InputName){
        case 'clients_name':
            urlLast = 'takenameclient';   
            break;
        case 'clients_phone':
            var id_phone = GetId(setInput,2);
            urlLast = 'takephonenumber';   
            break;
        case 'clients_email':
            urlLast = 'takeemailclient';   
            break;
        case 'name_brands':
            urlLast = 'takenamebrands';   
            break;
        case 'device_type_name':
            urlLast = 'takedevicetype';   
            break;
        case 'devices_model':
            urlLast = 'takedevicemodel';   
            break;
        case 'serial_numbers_name':
            urlLast = 'takeserialnumbersname';   
            break;
        case 'malfunction':
            var id_malfunction = GetId(setInput,2);
            urlLast = 'takeclaimedmalfunctionname';   
            break;    
    }    
    $.ajax({
        url: '/yii-application/backend/web/orders/default/'+urlLast,
        type: 'POST',
        data: data,
        success: function(res){
            console.log(res);
            if(res[0]!=0){
                $("#search_input_"+InputName+"-"+id).remove();
                switch (InputName){
                    case 'clients_name':
                        $("#input_orders_"+InputName+"-"+id).after(res['msg']);
                        break;
                    case 'clients_phone':
                        $("#p_orders_"+InputName+"-"+id+"-"+id_phone).after(res['msg']); 
                        break;
                    case 'clients_email':
                        $("#input_orders_"+InputName+"-"+id).after(res['msg']); 
                        break;
                    case 'name_brands':
                        $("#div_orders_"+InputName+"-"+id).after(res['msg']); 
                        break;
                    case 'device_type_name':
                        $("#div_orders_"+InputName+"-"+id).after(res['msg']); 
                        break;
                    case 'devices_model':
                        $("#div_orders_"+InputName+"-"+id).after(res['msg']);
                        break;
                    case 'serial_numbers_name':
                        $("#div_orders_"+InputName+"-"+id).after(res['msg']);
                        break;
                    case 'malfunction':
                        $("#div_orders_"+InputName+"-"+id+"-"+id_malfunction).after(res['msg']);
                        break;    
                } 
            }else{
                $("#search_input_"+InputName+"-"+id).remove();
                return false;
            }    
        },
        error: function(){
            alert('По неизвестной причине сервер не ответил обратитесь к админу.');
        }
    });
}

function SendToServerOption(setInput,data,id_orders){
    setInput = setInput.first();
    var obg = setInput;
    var InputName = setInput.attr('data-input-name');
    var urlLast = '';
    switch (InputName){
        case 'clients_name':
            urlLast = 'takeclient';   
            break;
        case 'name_brands':
            urlLast = 'takebrend';   
            break;
        case 'device_type_name':
            urlLast = 'takedevicet';   
            break;
        case 'devices_model':
            urlLast = 'takedevices';   
            break;
        case 'serial_numbers_name':
            urlLast = 'takeserialnumbers';   
            break;
        case 'malfunction':
            urlLast = 'takeclaimedmalfunction';   
            break;    
    }
    $.ajax({
        url: '/yii-application/backend/web/orders/default/'+urlLast,
            type: 'POST',
            data: data,
            success: function(res){
                console.log(res);
                console.log(id_orders);
                if(res[0]!=0){
                    $("#search_input_"+InputName+"-"+id_orders).remove();
                    switch (InputName){
                        case 'clients_name':
                            $("#orders_clients_form-"+id_orders).remove();
                            $("#form_orders-"+id_orders).prepend(res['msg']);  
                            break;
                        case 'name_brands':
                            $("#div_orders_name_brands-"+id_orders+" p").remove();
                            $("#div_orders_name_brands-"+id_orders).append(res['msg']);   
                            break;
                        case 'device_type_name':
                            $("#div_orders_device_type_name-"+id_orders+" p").remove();
                            $("#div_orders_device_type_name-"+id_orders).append(res['msg']) ; 
                            break;
                        case 'devices_model':
                            $("#div_orders_devices-"+id_orders+" div").remove();
                            $("#div_orders_devices-"+id_orders).append(res['msg']); 
                            break;
                        case 'serial_numbers_name':
                            $("#div_orders_serrial_nambers_id-"+id_orders+" div").remove();
                            $("#orders_hidden_serrial_nambers_id-"+id_orders).remove();        
                            $("#div_orders_serrial_nambers_id-"+id_orders).append(res['msg']); 
                            break;
                        case 'malfunction':
                            $("#input_orders_malfunction-"+res['id_orders']+"-"+res['id_malfunction_card']).val(res['claimed_malfunction_name']);
                            $("#input_orders_malfunction-"+res['id_orders']+"-"+res['id_malfunction_card']).attr('data-input',res['claimed_malfunction_name']);
                            $("#orders_claimed_malfunction_id-"+res['id_orders']+"-"+res['id_malfunction_card']).val(res['id_claimed_malfunction']);
                            break;
                    }
                    
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
}

//Обработчик нажатия кнопки добавить еше одину заявленную неисправность
$('.my_box_content').on('click', '.add_another_malfunction', function(){
    alert("Заявленная неисправность");    
    var id_orders = GetId($(this),1);
    $("#search_input_malfunction-"+id_orders).remove();
    var indexMalfunction = $(this).attr('data-count-malfunction');
    addNewClaimedMalfunction(id_orders, indexMalfunction);
});

function addNewClaimedMalfunction(id_orders, indexMalfunction){
    console.log(id_orders);
    console.log(indexMalfunction);
    var next = Number(indexMalfunction) + 1;
    var buttondelete=""+
        "<a  id = 'delete_another_malfunction-"+id_orders+"-"+next+"' class='btn btn-dark delete_another_malfunction mx-1'   data-toggle='tooltip' data-placement='right' title='Удалить заявленную неисправность'>"+
            "<img id ='menu_navbar_top' class='' src='/yii-application/backend/web/m_orders/img/minus.svg' alt='Удалить заявленную неисправность'>"+
        "</a>";
    var buttondeleteFirst=""+
        "<a  id = 'delete_another_malfunction-"+id_orders+"-1' class='btn btn-dark delete_another_malfunction mx-1'   data-toggle='tooltip' data-placement='right' title='Удалить заявленную неисправность'>"+
            "<img id ='menu_navbar_top' class='' src='/yii-application/backend/web/m_orders/img/minus.svg' alt='Удалить заявленную неисправность'>"+
        "</a>";
    var input =""+
        "<div id = 'div_orders_malfunction-"+id_orders+"-"+next+"'class='div_orders_malfunction-"+id_orders+"'>"+        
            "<p id='p_orders_malfunction-"+id_orders+"-"+next+"' class='form-row my-2 orders_malfunction-"+id_orders+" orders_malfunction'>"+
                "<input id='input_orders_malfunction-"+id_orders+"-"+next+"' name='MalfunctionEdit[malfunction-"+next+"]' data-input = '' data-input-name = 'malfunction' value=''  form='' class='input_orders form-control col-8 malfunction_input malfunction_input-0' type='text' placeholder='Заявленная неисправность'>"+       
                "<p id = 'error_orders_malfunction-"+id_orders+"-"+next+"' class='text-danger my-2 mx-2 error_orders_malfunction error_orders_malfunction-"+next+"' style='display: none;'>Ошибка</p>"+                             
            "</p>"+
            "<input type='hidden' class='hidden_malfunction_input' id='orders_claimed_malfunction_id-"+id_orders+"-"+next+"' name='MalfunctionEdit[claimed_malfunction_id-"+next+"]' value='0'>"+
        "</div>";
    if(indexMalfunction == 1){
        $("#input_orders_malfunction-"+id_orders+"-"+indexMalfunction).after(buttondeleteFirst);        
    }
    $("#div_orders_malfunction-"+id_orders+"-"+indexMalfunction).after(input);
    $("#input_orders_malfunction-"+id_orders+"-"+next).after(buttondelete);
    $("#add_another_malfunction-"+id_orders).attr('data-count-malfunction',next);
}

//Обработчик нажатия кнопки удалить еше одину заявленную неисправность
$('.my_box_content').on('click', '.delete_another_malfunction', function(){
    alert("Удалить завленная неисправность");
    var id_orders = GetId($(this),1);
    var id_malfunction = GetId($(this),2);
    deleteInputClaimedMalfunction(id_orders,id_malfunction);
});

function deleteInputClaimedMalfunction(id_orders,id_malfunction){
    console.log(id_orders);
    console.log(id_malfunction);
    var count = $('.div_orders_malfunction-'+id_orders).length;
    console.log(count);
    if(count>1){
        $("#div_orders_malfunction-"+id_orders+"-"+id_malfunction).remove();
        $('.div_orders_malfunction-'+id_orders).each(function(index){
            console.log($(this));
            $(this).attr('id',("div_orders_malfunction-"+id_orders+"-"+(index+1)));
            $(this).find(".malfunction_input").attr('id',("input_orders_malfunction-"+id_orders+"-"+(index+1)));
            $(this).find(".malfunction_input").attr('name',("MalfunctionEdit[malfunction-"+(index+1)+"]"));
            $(this).find("a").attr('id',("delete_another_malfunction-"+id_orders+"-"+(index+1)));
            $(this).find(".error_orders_malfunction").attr('id',("error_orders_malfunction-"+id_orders+"-"+(index+1)));
            $(this).find(".orders_malfunction").attr('id',("p_orders_malfunction-"+id_orders+"-"+(index+1)));
            $(this).find(".hidden_malfunction_input").attr('id',("orders_claimed_malfunction_id-"+id_orders+"-"+(index+1)));
            $(this).find(".hidden_malfunction_input").attr('name',("MalfunctionEdit[claimed_malfunction_id-"+(index+1)+"]"));
        });
        $('#add_another_malfunction-'+id_orders).attr('data-count-malfunction',(count-1));
        if(count==2){
            $("#delete_another_malfunction-"+id_orders+"-1").remove();
        }
    }
}

//Обрабатуем нажатие на чекбокс срочно 
$('.my_content_bloc').on('click', '.check_urgency', function(){
    //alert("Вы нажали на чекбокс");
    var id = GetId($(this),1);
    console.log(id);
    if ($(this).is(':checked')){
        $("#orders_urgency-"+id).val(1);
    }else{
        $("#orders_urgency-"+id).val(0);
    }
});