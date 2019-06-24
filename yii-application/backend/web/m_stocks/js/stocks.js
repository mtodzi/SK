//Глобальные переменные
var countSendServer = 0;//Счетчик запросов который дал отрицательный результат в поиске подстановки
var dataKard = {};//пустой обьект с данными карточки

function GetDataCardOrders(id) {
    var data = {};
    data = {        
        'brand_name': $("#input_serialnambers_brand_name-" + id).val(),
        'id_brands': $("#serialnambers_id_brands-" + id).val(),
        'device_type_name': $("#input_serialnambers_device_type_name-" + id).val(),
        'id_device_type': $("#serialnambers_id_device_type-" + id).val(),
        'devices_model': $("#input_serialnambers_devices_model-" + id).val(),
        'id_devices': $("#serialnambers_id_devices-" + id).val(),
        'serial_numbers_name': $("#input_serialnambers_serial_numbers_name-" + id).val(),
        'id_serial_numbers': $("#serialnambers_id_serial_numbers-" + id).val(),
        'type_addition':$("input[name='type_addition']:checked").val(),
    };
    return data;
}

//Обработчик нажатия кнопки отмена в userbox
$('.index_stock_bloc').on('click', '.serialnambers_cancel_button', function () {
    console.log(dataKard);
    alert("Вы нажали кнопку отмена");        
    var id = GetId($(this), 1);
    var dataKard1 = GetDataCardOrders(id);
    var s1 = JSON.stringify(dataKard);
    var s2 = JSON.stringify(dataKard1);
    var arrayFieldsChecked = ['brand_name-', 'device_type_name-', 'devices_model-', 'serial_numbers_name-','equipment_stock-'];
    errorDeleteServerTreatment(arrayFieldsChecked, id);
    if (!(s1 == s2)) {
        settingCardData(dataKard, id);
        if (id == 0) {
            SetStatusCard(0, "");
            $('#Block_add_serialnumbers-0').hide();
            return false;
        } else {
            SetStatusCard(id, "#span_serialnumbers_id_serial_numbers-");
            $('#stock_card_button_edit_delete-' + id).show();
            $('#serialnumbers_content-' + id).show();
            $('#serialnambers_cancel_button_card_apply-' + id).hide();
            $('#serialnumbers_form-' + id).hide();
            return false;
        }
    } else {
        if (id == 0) {
            SetStatusCard(0, "");
            $('#Block_add_serialnumbers-0').hide();
            return false;
        } else {
            SetStatusCard(id, "#span_serialnumbers_id_serial_numbers-");
            $('#stock_card_button_edit_delete-' + id).show();
            $('#serialnumbers_content-' + id).show();
            $('#serialnambers_cancel_button_card_apply-' + id).hide();
            $('#serialnumbers_form-' + id).hide();
            return false;
        }
    }
});
//Установка данных в полях 
function settingCardData(data, id) {
    var htmlOne = ""+
            "<p id = 'p_serialnambers_serial_numbers_name-0-1' class='form-row my-2 input_serialnambers-0'>"+
                "<input id='input_serialnambers_serial_numbers_name-0'"+
                "name='SerialNumbersEdit[serial_numbers_name]' data-input-name = 'serial_numbers_name'  form='form_serialnambers_stock-0'"+
                "value='' class='form-control col-4 mx-2 input_serialnambers_serial_numbers_name input_serialnambers input_serialnambers-0' type='text'"+
                "placeholder='Серийный номер'>"+
                "<input id='serialnambers_id_serial_numbers-0' type='hidden' name='SerialNumbersEdit[id_serial_numbers]' value='0' form='form_serialnambers_stock-0'>"+
            "</p>"+    
            "";
    $("#input_serialnambers_brand_name-" + id).val(data.brand_name);
    $("#serialnambers_id_brands-" + id).val(data.id_brands);
    $("#input_serialnambers_device_type_name-" + id).val(data.device_type_name);
    $("#serialnambers_id_device_type-" + id).val(data.id_device_type);
    $("#input_serialnambers_devices_model-" + id).val(data.devices_model);
    $("#serialnambers_id_devices-" + id).val(data.id_devices);
    if($("input[name='type_addition']:checked").val()!='one' && id == 0){
        $("#p_add_another_serialnambers_serial_numbers_name-0").remove();
        $(".delete_another_serialnambers-0").remove();
        $(".input_serialnambers-0").remove();
        $("#p_type_addition").after(htmlOne);
        $("input[value='one']").prop('checked', true);
    }    
    $("#input_serialnambers_serial_numbers_name-" + id).val(data.serial_numbers_name);
    $("#serialnambers_id_serial_numbers-" + id).val(data.id_serial_numbers);    
}
//Кнопка подняться в верх
$(function() {
    // при нажатии на кнопку scrollup
    $('.scroll_to_up').click(function() {
    // переместиться в верхнюю часть страницы
    $("html, body").animate({
      scrollTop:0
    },500);
  })
});

// при прокрутке окна (window)
$(window).scroll(function() {
  // если пользователь прокрутил страницу более чем на 200px
  if ($(this).scrollTop()>200) {
    // то сделать кнопку scrollup видимой
    $('.scroll_to_up').fadeIn();
  }
  // иначе скрыть кнопку scrollup
  else {
    $('.scroll_to_up').fadeOut();
  }
});

//чтобы tooltip пропадал
$('[data-toggle="tooltip"]').on("click", function() {
    $(this).tooltip('hide');
    $(this).blur();
});



//Обработчик нажатия кнопки добавить склад
$('.my_heders_bloc').on('click', '#btn_create_new_stock', function(){
    $('#input_name_stock').val('');
    $('#input_id_stocks').val(0);
    $('#button_new_update_stocks').text('Добавить');
    $('#button_new_update_stocks').attr('data-position',0);
    formCleaningStock();
    $('#modal_create_new_stock').modal();
    return false;
});
    

//Обработчик нажатия кнопки редоктировать склад
$('.my_heders_bloc').on('click', '#btn_update_new_stock', function(){
    var select_stock = $("#select_stock option:selected").text();
    var id_select_stock = $("#select_stock").val();
    $('#input_name_stock').val(select_stock);
    $('#input_id_stocks').val(id_select_stock);
    $('#button_new_update_stocks').text('Изменить');
    $('#button_new_update_stocks').attr('data-position',1);
    formCleaningStock();
    $('#modal_create_new_stock').modal();
    return false;
});


//Обработчик нажатия кнопки добавить или сохранить склад
$('.modal-footer').on('click', '#button_new_update_stocks', function(){
    var position = Number($(this).attr('data-position'));
    console.log(position);
    switch (position){
        case 0:
            console.log("Сохраняем новый склад");
            createNewStock();
            break;
        case 1:
            console.log("Редактуруем склад");
            updateStock();
            break;
    }
    return false;
});

//функция для отправки на сервер данных для создания нового склада
function createNewStock(){
    if(formValidationStock()){
        console.log("Валидация пройденна");
        var data = $('#form_new_stock').serialize();
        console.log("Данные отправляемые на сервер - "+data);
        formCleaningStock();
        $.ajax({
            url: '/yii-application/backend/web/stock/stocks/createstock',
            type: 'POST',
            data: data,
            success: function(res){
                console.log("Данные пришедшие с сервера");
                console.log(res);
                if(res[0]==200){
                    $("#form_select_stock").remove();
                    $("#index_stock_bloc").remove();
                    $("#btn_stock_group_update").after(res['htmlStocks']);
                    $("#status_card").after(res['htmlSerialNamber']);
                    $('#modal_create_new_stock').modal('hide');
                }else{
                    var text = '';
                    if(res['modelErrors']==0){
                        text = res['msg'];
                    }else{
                        text = res['modelErrors']['name_stock'];
                    }
                    $("#error_name_stock").text(text);
                    $("#error_name_stock").show();
                }
                
            },
            error: function (jqXHR) {
                console.log("Ощибка с сервера"+jqXHR);
                alert(jqXHR.responseText);
            }
        });
    }else{
        console.log("Валидация не пройденна");
        return false;
    }    
}

//функция для отправки на сервер данных для редоктирования склада 
function updateStock(){
    if(formValidationStock()){
        console.log("Валидация пройденна");
        var data = $('#form_new_stock').serialize();
        console.log("Данные отправляемые на сервер - "+data);
        formCleaningStock();
        $.ajax({
            url: '/yii-application/backend/web/stock/stocks/updatestock',
            type: 'POST',
            data: data,
            success: function(res){
                console.log("Данные пришедшие с сервера");
                console.log(res);
                if(res[0]==200){
                    $('#select_option_stock-'+res['id_stocks']).text(res['name_stock']);
                    $('#modal_create_new_stock').modal('hide');
                }else{
                    var text = '';
                    if(res['modelErrors']==0){
                        text = res['msg'];
                    }else{
                        text = res['modelErrors']['name_stock'];
                    }
                    $("#error_name_stock").text(text);
                    $("#error_name_stock").show();
                }
                
            },
            error: function (jqXHR) {
                console.log("Ощибка с сервера"+jqXHR);
                alert(jqXHR.responseText);
            }
        });
    }else{
        console.log("Валидация не пройденна");
        return false;
    }        
}

//функция проверят формыу перед отправкой на сервер
function formValidationStock(){
    var name_stock = $('#input_name_stock').val();
    if(!empty(name_stock)){
        console.log("Переменная сушествует");
        if(name_stock.length<=255){
            console.log("Переменн НОРМАЛЬНОЙ ДЛИНЫ");
            return true;
        }else{
            console.log("Переменн не НОРМАЛЬНОЙ ДЛИНЫ");
            $("#error_name_stock").text("Длина названия не допустима");
            $("#error_name_stock").show();
            return false;
        }
    }else{
        console.log("Переменная не сушествует");
        $("#error_name_stock").text("Необходимо заполнить название склада");
        $("#error_name_stock").show();
        return false;
    }
}

//Функция очишает ошибки формы дабавления и редактирования
function formCleaningStock(){
    $("#error_name_stock").text("");
    $("#error_name_stock").hide();
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


//Обработчик нажатия кнопки добавить продукт на склад
$('.my_heders_bloc').on('click', '#add_new_serialNambers_in_stock', function(){
    alert("Вы пытаетесь добавить продукт на склад");
    if(GetStatusCard()){
        SetStatusCard(0,"");
        $('#Block_add_serialnumbers-0').show();
        $(window).scrollTop(0);
        $(this).tooltip('hide');
        $(this).blur();
        dataKard = GetDataCardOrders(0);
        console.log(dataKard);
        return false;
    }else{
        $(this).tooltip('hide');
        $(this).blur();
        return false;
    }
});

//Обработчик нажатия кнопки редактировать продукта на складе
$('.index_stock_bloc').on('click', '.serialnambers_edit_button', function () {
    var id = GetId($(this), 1);
    if (GetStatusCard()) {
        dataKard = GetDataCardOrders(id);
        console.log(dataKard);
        SetStatusCard(id, "#span_serialnumbers_id_serial_numbers-");
        $('#stock_card_button_edit_delete-' + id).hide();
        $('#serialnumbers_content-' + id).hide();
        $('#serialnambers_cancel_button_card_apply-' + id).show();
        $('#serialnumbers_form-' + id).show();
        return false;
    } else {
        return false;
    }

});


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
            var employeename = "Вы добавляете новый продукт на склад";
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
//Обработчик нажатия клавиш в input
$('.index_stock_bloc').on('keyup', '.input_serialnambers', function (eventObject) {
    //alert("я работаю");
    var inputName = $(this).attr('data-input-name');
    var notInput = ['clients_address', 'appearance', 'special_notes'];//массив в котором храняться поля которые не нужно отслеживать
    if (notInput.indexOf(inputName) == -1) {
        var x = eventObject.which;
        switch (true) {
            case (x == 9):
                break;
            case (x == 13):
                break;
            case (x >= 16 && x<=20):
                break;
            case (x >= 112 && x<=123):
                break;    
            case (x == 27):
                //EscInputOrders($(this));
                break;
            case (x == 8):
                DeleteLetterInput($(this));
                break;
            case (x == 46):
                DeleteLetterInput($(this));
                break;
            default:
                var data = {};
                data = GetDataKeyUP($(this));
                if (data) {
                    console.log(data);
                    SendToServerSelected($(this), data);
                }
                break;
        }
    }
});

//Обработчик нажатия на option в подсказке clients_name в userbox для всех option
$('.index_stock_bloc').on('click', '.input_serial_numbers_option', function () {
    var id_serial_numbers = GetId($(this).parent(), 1);
    var id_input = GetId($(this), 1);
    var data_input_name =  $(this).attr('data-input-name');    
    var id_input_val = $("#option_"+data_input_name+"-"+id_input).val();
    var name_input_val = $("#option_"+data_input_name+"-"+id_input).text();
    console.log("id_serial_numbers - " + id_serial_numbers);
    console.log("id_input - " + id_input);
    console.log("id_input_val - " + id_input_val);
    console.log("name_input_val - " + name_input_val);
    switch (data_input_name){
        case 'name_brands':
            $('#input_serialnambers_brand_name-'+id_serial_numbers).val(name_input_val);
            $('#serialnambers_id_brands-'+id_serial_numbers).val(id_input_val);
            $("#search_input_name_brands-" + id_serial_numbers).remove();
            break;
        case 'device_type_name':
            $('#input_serialnambers_device_type_name-'+id_serial_numbers).val(name_input_val);
            $('#serialnambers_id_device_type-'+id_serial_numbers).val(id_input_val);
            $("#search_input_device_type_name-" + id_serial_numbers).remove();
            break;
        case 'devices_model':
            console.log('data_input_name - '+data_input_name);
            var id_brands = $(this).attr('data-id_brands');
            console.log("id_brands - "+id_brands);
            var brand_name = $(this).attr('data-brand_name');
            console.log("brand_name - "+brand_name);
            var id_device_type = $(this).attr('data-id_device_type');
            console.log("id_device_type - "+id_device_type);
            var device_type_name = $(this).attr('data-device_type_name');
            console.log("device_type_name - "+device_type_name);
            $('#input_serialnambers_brand_name-'+id_serial_numbers).val(brand_name);
            $('#serialnambers_id_brands-'+id_serial_numbers).val(id_brands);
            $('#input_serialnambers_device_type_name-'+id_serial_numbers).val(device_type_name);
            $('#serialnambers_id_device_type-'+id_serial_numbers).val(id_device_type);
            $('#input_serialnambers_devices_model-'+id_serial_numbers).val(name_input_val);
            $('#serialnambers_id_devices-'+id_serial_numbers).val(id_input_val);
            $("#search_input_devices_model-" + id_serial_numbers).remove();
            break;
        case 'serial_numbers_name':
            var checked = $("input[name='type_addition']:checked").val();
            console.log(checked);
            var textSelectorName = "#input_serialnambers_serial_numbers_name-" + id_serial_numbers;
            var textSelectorId = '#serialnambers_id_serial_numbers-'+id_serial_numbers;
            var textSelectorSerche = "#search_input_serial_numbers_name-" + id_serial_numbers;
            if(checked=='some'){
                var idInput = GetId($(this).parent(), 2);
                var textSelectorName = "#input_serialnambers_serial_numbers_name-" +id_serial_numbers+"-"+idInput;
                var textSelectorId = '#serialnambers_id_serial_numbers-'+id_serial_numbers+"-"+idInput;
                var textSelectorSerche = "#search_input_serial_numbers_name-" +id_serial_numbers+"-"+idInput;
            }
            var id_brands = $(this).attr('data-id_brands');
            console.log("id_brands - "+id_brands);
            var brand_name = $(this).attr('data-brand_name');
            console.log("brand_name - "+brand_name);
            var id_device_type = $(this).attr('data-id_device_type');
            console.log("id_device_type - "+id_device_type);
            var device_type_name = $(this).attr('data-device_type_name');
            console.log("device_type_name - "+device_type_name);
            var id_devices = $(this).attr('data-id_devices');
            console.log("id_devices - "+id_devices);
            var devices_model = $(this).attr('data-devices_model');
            console.log("devices_model - "+devices_model);
            $(textSelectorName).val(name_input_val);
            $(textSelectorId).val(id_input_val);
            if(checked=='one'){
                $("#input_equipment_stock_serial_number_id-"+id_serial_numbers).val(id_input_val);
            }    
            $('#input_serialnambers_brand_name-'+id_serial_numbers).val(brand_name);
            $('#serialnambers_id_brands-'+id_serial_numbers).val(id_brands);
            $('#input_serialnambers_device_type_name-'+id_serial_numbers).val(device_type_name);
            $('#serialnambers_id_device_type-'+id_serial_numbers).val(id_device_type);
            $('#input_serialnambers_devices_model-'+id_serial_numbers).val(devices_model);
            $('#serialnambers_id_devices-'+id_serial_numbers).val(id_devices);
            $(textSelectorSerche).remove();
            break;    
    }
    
    return false;
});

//Функция формирует данные для отправки на сервер для формирования списка выбора
function GetDataKeyUP(setInput) {
    setInput = setInput.first();
    var id = GetId(setInput, 1);
    var InputName = setInput.attr('data-input-name');
    var data = {};
    switch (InputName) {       
        case 'name_brands':
            data = {
                'data-input-name':'name_brands',
                'SearchInput[id_serial_numbers]': id,
                'SearchInput[brand_name]': $("#input_serialnambers_brand_name-" + id).val(),
                '_csrf-backend': $('input[name="_csrf-backend"]').val()
            };
            return data;
            break;
        case 'device_type_name':
            data = {
                'data-input-name':'device_type_name',
                'SearchInput[id_serial_numbers]': id,
                'SearchInput[device_type]': $("#input_serialnambers_device_type_name-" + id).val(),
                '_csrf-backend': $('input[name="_csrf-backend"]').val()
            };
            return data;
            break;
        case 'devices_model':
            data = {
                'data-input-name':'devices_model',
                'SearchInput[id_serial_numbers]': id,
                'SearchInput[devices_model]': $("#input_serialnambers_devices_model-" + id).val(),
                'SearchInput[brands_id]': $("#serialnambers_id_brands-" + id).val(),
                'SearchInput[devices_type_id]': $("#serialnambers_id_device_type-" + id).val(),
                '_csrf-backend': $('input[name="_csrf-backend"]').val()
            };
            return data;
            break;
        case 'serial_numbers_name':
            var checked = $("input[name='type_addition']:checked").val()
            console.log(checked);
            var textSelector = "#input_serialnambers_serial_numbers_name-" + id;
            type_addition = 0;
            if(checked=='some'){
                var indexInput = GetId(setInput, 2);
                textSelector = "#input_serialnambers_serial_numbers_name-" +id+"-"+indexInput;
                type_addition = indexInput;
            }
            data = {
                'type_addition':type_addition,
                'data-input-name':'serial_numbers_name',
                'SearchInput[id_serial_numbers]': id,
                'SearchInput[serial_numbers_name]': $(textSelector).val(),
                'SearchInput[brands_id]': $("#serialnambers_id_brands-" + id).val(),
                'SearchInput[devices_type_id]': $("#serialnambers_id_device_type-" + id).val(),
                'SearchInput[devise_id]': $("#serialnambers_id_devices-" + id).val(),
                '_csrf-backend': $('input[name="_csrf-backend"]').val()
            };
            return data;
            break;
    }
}

//Функция отправляет данные на сервер и обрабатывает ответ
function SendToServerSelected(setInput, data) {
    setInput = setInput.first();
    var id = GetId(setInput, 1);
    var InputName = setInput.attr('data-input-name');
    console.log(countSendServer);
    if(countSendServer == 0){
        $.ajax({
            url: '/yii-application/backend/web/stock/stocks/taketxtinput',
            type: 'POST',
            data: data,
            success: function (res) {
                console.log(res);
                if (res[0] != 0) {
                    var checked = $("input[name='type_addition']:checked").val()
                    console.log(checked);
                    textSelector = "#search_input_" + InputName + "-" + id;
                    if(checked=='some'){
                        var indexInput = GetId(setInput, 2);
                        textSelector = "#search_input_serial_numbers_name-" + id+"-"+indexInput;
                    }
                    $(textSelector).remove();
                    switch (InputName) {
                        case 'name_brands':
                            $("#div_serialnambers_" + InputName + "-" + id).after(res['msg']);
                            break;
                        case 'device_type_name':
                            $("#div_serialnambers_" + InputName + "-" + id).after(res['msg']);
                            break;
                        case 'devices_model':
                            $("#div_serialnambers_" + InputName + "-" + id).after(res['msg']);
                            break;
                        case 'serial_numbers_name':
                            var checked = $("input[name='type_addition']:checked").val()
                            console.log(checked);
                            var textSelector = "#div_serialnambers_" + InputName + "-" + id;
                            if(checked=='some'){
                                var indexInput = GetId(setInput, 2);
                                textSelector = "#p_serialnambers_serial_numbers_name-" +id+"-"+indexInput;
                            }
                            $(textSelector).after(res['msg']);
                            break;
                    }
                } else {
                    countSendServer++;
                    $("#search_input_" + InputName + "-" + id).remove();
                    return false;
                }
            },
            error: function (jqXHR) {
                console.log(jqXHR);
                alert(jqXHR.responseText);
            }
    });}else{
        return false;
    }
}

//Функциия следить за действиями при удалении в input
function DeleteLetterInput(setInput) {
    setInput = setInput.first();
    var id = GetId(setInput, 1);
    var InputName = setInput.attr('data-input-name');
    switch (InputName) {
        case 'name_brands':
            countSendServer = 0;
            if(id==0){
                $("#serialnambers_id_brands-" + id).val(0);
            }    
            $("#search_input_" + InputName + "-" + id).remove();
            break;
        case 'device_type_name':
            countSendServer = 0;
            if(id==0){
                $("#serialnambers_id_device_type-" + id).val(0);
            }    
            $("#search_input_" + InputName + "-" + id).remove();
            break;
        case 'devices_model':
            countSendServer = 0;
            if(id==0){
                $("#serialnambers_id_devices-" + id).val(0);
            }    
            $("#search_input_" + InputName + "-" + id).remove();
            break;
        case 'serial_numbers_name':
            countSendServer = 0;
            if(id==0){
                $("#serialnambers_id_serial_numbers-" + id).val(0);
                $("#input_equipment_stock_serial_number_id-" + id).val(0);
            }    
            $("#search_input_" + InputName + "-" + id).remove();
            break;
    }
}

//Обработчик отслеживает получение фокуса 
$('.index_stock_bloc').on('focusin', '.input_serialnambers', function () {
    var id_serialnambers = GetId($(this), 1);
    console.log($("search_input_device_type-" + id_serialnambers));
    if ($("#search_input_name_brands-" + id_serialnambers).is("#search_input_name_brands-" + id_serialnambers)) {
        $("#search_input_name_brands-" + id_serialnambers).remove();
    }
    if ($("#search_input_device_type_name-" + id_serialnambers).is("#search_input_device_type_name-" + id_serialnambers)) {
        $("#search_input_device_type_name-" + id_serialnambers).remove();
    }
    if ($("#search_input_devices_model-" + id_serialnambers).is("#search_input_devices_model-" + id_serialnambers)) {
        $("#search_input_devices_model-" + id_serialnambers).remove();
    }
    var checked = $("input[name='type_addition']:checked").val()
    console.log(checked);
    textSelector = "#search_input_serial_numbers_name-" + id_serialnambers;
    if(checked=='some'){
        var indexInput = GetId($(this), 2);
        textSelector = "#search_input_serial_numbers_name-" + id_serialnambers+"-"+indexInput;
    }
    if ($(textSelector).is(textSelector)) {
        $(textSelector).remove();
    }
});

//Обработчик отслеживает получение фокуса 
$('.index_stock_bloc').on('change', "input[type='radio']", function () {
    alert("вы сменили");
    console.log($(this));
    var check = $(this).val();
    var htmlOne = ""+
            "<p id = 'p_serialnambers_serial_numbers_name-0-1' class='form-row my-2 p_input_serialnambers-0'>"+
                "<input id='input_serialnambers_serial_numbers_name-0'"+
                "name='SerialNumbersEdit[serial_numbers_name]' data-input-name = 'serial_numbers_name'  form='form_serialnambers_stock-0'"+
                "value='' class='form-control col-4 mx-2 input_serialnambers_serial_numbers_name input_serialnambers input_serialnambers-0' type='text'"+
                "placeholder='Серийный номер'>"+
                "<input id='serialnambers_id_serial_numbers-0' type='hidden' name='SerialNumbersEdit[id_serial_numbers]' value='0' form='form_serialnambers_stock-0'>"+
            "</p>"+    
            "";
    var htmlRange = ""+
            "<p id = 'p_serialnambers_serial_numbers_name-0-1' class='form-row my-2 input_serialnambers-0'>"+
                "<input id='input_serialnambers_serial_numbers_name-0'"+
                "name='SerialNumbersEdit[serial_numbers_name]' data-input-name = 'serial_numbers_name'  form='form_serialnambers_stock-0'"+
                "value='' class='form-control col-4 mx-2 input_serialnambers_serial_numbers_common_body_range input_serialnambers' type='text'"+
                "placeholder='Общая часть'>  "+
                "<input id='input_serialnambers_serial_numbers_start_range-0'"+
                "name='SerialNumbersEdit[serial_numbers_start_range]' data-input-name = 'serial_numbers_start_range'  form='form_serialnambers_stock-0'"+
                "value='' class='form-control col-2 mx-2 input_serialnambers_serial_numbers_start_range input_serialnambers' type='text'"+
                "placeholder='начало'> - "+
                "<input id='input_serialnambers_serial_numbers_end_range-0'"+
                "name='SerialNumbersEdit[serial_numbers_end_range]' data-input-name = 'serial_numbers_end_range'  form='form_serialnambers_stock-0'"+
                "value='' class='form-control col-2 mx-2 input_serialnambers_serial_numbers_end_range input_serialnambers' type='text'"+
                "placeholder='конец'>"+
            "</p>"+
            "";
    var htmlSome = ""+
            "<p id = 'p_serialnambers_serial_numbers_name-0-1' class='form-row my-2 p_input_serialnambers-0'>"+
                "<input id='input_serialnambers_serial_numbers_name-0-1'"+
                "name='SerialNumbersEdit[serial_numbers_name_array][1]' data-input-name = 'serial_numbers_name'  form='form_serialnambers_stock-0'"+
                "value='' class='form-control col-4 mx-2 input_serialnambers_serial_numbers_name-0 input_serialnambers_serial_numbers_name input_serialnambers input_check_serialnambers-0  input_serialnambers-0' type='text'"+
                "placeholder='Серийный номер'>"+
                "<input id='serialnambers_id_serial_numbers-0-1' class = 'input_serialnambers_id_serial_numbers' type='hidden' name='SerialNumbersEdit[id_serial_numbers_array][1]' value='0' form='form_serialnambers_stock-0'>"+
            "</p>"+
            "<p id = 'p_add_another_serialnambers_serial_numbers_name-0' class='form-row my-2'>"+
                "<a id ='add_another_serial_numbers_name-0' class='btn btn-dark add_another_serial_numbers_name mx-1' data-count-serial_numbers_name='1' data-toggle='tooltip' data-placement='right' title='Добавить еще один серийный номер'>"+
                    "<img id ='menu_navbar_top' class='' src='/yii-application/backend/web/m_stocks/img/add.svg' alt='Добавить еще один серийный номер'>"+
                "</a>"+
            "</p>"+
            "";
    switch (check){
        case 'one':
            alert("Вы выбрали one");
            $("#p_add_another_serialnambers_serial_numbers_name-0").remove();
            $(".delete_another_serialnambers-0").remove();
            $(".input_serialnambers-0").remove();
            $("#p_type_addition").after(htmlOne);
            break;
        case 'range':
            alert("Вы выбрали range");
            $("#p_add_another_serialnambers_serial_numbers_name-0").remove();
            $(".delete_another_serialnambers-0").remove();
            $(".input_serialnambers-0").remove();
            $("#p_type_addition").after(htmlRange);
            break;
        case 'some':
            alert("Вы выбрали some");
            $(".input_serialnambers-0").remove();
            $("#p_type_addition").after(htmlSome);
            $("#add_another_serial_numbers_name-0").tooltip('enable');
            break;
    }
    
});

//Обработчик нажатия кнопки добавить еше один серийный номер
$('.index_stock_bloc').on('click', '.add_another_serial_numbers_name', function () {
    var id_serialnambers = GetId($(this), 1);
    var count_serialnambers = Number($(this).attr('data-count-serial_numbers_name'));
    $("#search_input_serial_numbers_name-" + id_serialnambers).remove();
    console.log('id_serialnambers: ' + id_serialnambers + " count_serialnambers: " + count_serialnambers);
    addInputSerialNambers(id_serialnambers, count_serialnambers);
    $(this).tooltip('update');
    $(this).tooltip('hide');
    $(this).blur();
    return false;
});

//Функция добавляет поле серийного номера в карточке добавить продукт на склад
function addInputSerialNambers(id, count_serialNambers, value = "") {
    var count = $('.input_serialnambers-0').length;
    console.log("Число добовляемых серийных номеров - " + count);
    var next = Number(count_serialNambers) + 1;
    var buttondelete = "" +
            "<a  id = 'delete_another_serialnambers-" + id + "-" + next + "' class='btn btn-dark delete_another_serialnambers delete_another_serialnambers-" + id + " mx-1'  data-count-serialnambers='" + next + "' data-toggle='tooltip' data-placement='right' title='Удалить серийный номер'>" +
            "<img id ='menu_navbar_top' class='' src='/yii-application/backend/web/m_orders/img/minus.svg' alt='Удалить серийный номер'>" +
            "</a>";
    var buttondeleteFirst = "" +
            "<a  id = 'delete_another_serialnambers-" + id + "-1' class='btn btn-dark delete_another_serialnambers delete_another_serialnambers-" + id + " mx-1'  data-count-serialnambers='" + next + "' data-toggle='tooltip' data-placement='right' title='Удалить серийный номер '>" +
            "<img id ='menu_navbar_top' class='' src='/yii-application/backend/web/m_orders/img/minus.svg' alt='Удалить серийный номер'>" +
            "</a>";
    var input = '' +
            "<p id = 'p_serialnambers_serial_numbers_name-0-"+next+"' class='form-row my-2 p_input_serialnambers-0'>"+
                "<input id='input_serialnambers_serial_numbers_name-0-"+next+"'"+
                "name='SerialNumbersEdit[serial_numbers_name_array]["+next+"]' data-input-name = 'serial_numbers_name'  form='form_serialnambers_stock-0'"+
                "value='' class='form-control col-4 mx-2 input_serialnambers_serial_numbers_name-0 input_serialnambers_serial_numbers_name input_serialnambers input_check_serialnambers-0 input_serialnambers-0' type='text'"+
                "placeholder='Серийный номер'>"+
                "<input id='serialnambers_id_serial_numbers-0-"+next+"' class = 'input_serialnambers_id_serial_numbers' type='hidden' name='SerialNumbersEdit[id_serial_numbers_array]["+next+"]' value='0' form='form_serialnambers_stock-0'>"+
            "</p>";
 
        //$("#search_input_phone_number-" + id_orders).remove();
        $('#add_another_serial_numbers_name-' + id).attr('data-count-serial_numbers_name', next);
        $('#delete_another_serialnambers-' + id).attr('data-count-serialnambers', next);
        $("#p_serialnambers_serial_numbers_name-" + id + "-" + count_serialNambers).after(input);
        $(("#input_serialnambers_serial_numbers_name-" + id + "-" + next)).after(buttondelete);
        $('[data-toggle="tooltip"]').tooltip();
        if (count_serialNambers == 1) {
            $(("#input_serialnambers_serial_numbers_name-" + id + "-1")).after(buttondeleteFirst);
            $('[data-toggle="tooltip"]').tooltip();
        }
        console.log(count_serialNambers);
        console.log(input);
        return true;

}

//Обработчик нажатия кнопки Удалить еше один серийный номер
$('.index_stock_bloc').on('click', '.delete_another_serialnambers', function () {
    var id_serialnumbers = GetId($(this), 1);
    var id_delete = GetId($(this), 2);
    console.log("id_delete - "+id_delete+" id_serialnumbers - "+id_serialnumbers);
    var count_serialnambers = Number($(this).attr('data-count-serialnambers'));
    console.log('id_serialnumbers-' + id_serialnumbers + " id_delete-" + id_delete);
    $(this).tooltip('update');
    $(this).tooltip('hide');
    $(this).blur();
    deleteInputPhone(id_serialnumbers, id_delete, count_serialnambers);
    return false;
});

//Функция хоть и имеет в название телефон удаляет вот она поле ввода серийного номера 
function deleteInputPhone(id, id_delete, count_serialnambers) {
    var count = $('.input_serialnambers_serial_numbers_name-' + id).length;
    console.log(count);
    //$("#search_input_phone_number-" + id_orders).remove();
    if (count > 1) {
        $("#p_serialnambers_serial_numbers_name-" + id + "-" + id_delete).remove();
        console.log( $('.p_input_serialnambers-' + id));
        $('.p_input_serialnambers-' + id).each(function (index) {
            console.log($(this));
            $(this).attr('id', ("p_serialnambers_serial_numbers_name-" + id + "-" + (index + 1)));
            $(this).find(".input_serialnambers_serial_numbers_name").attr('id', ("input_serialnambers_serial_numbers_name-" + id + "-" + (index + 1)));
            $(this).find(".input_serialnambers_serial_numbers_name").attr('name', ("SerialNumbersEdit[serial_numbers_name_array][" + (index + 1) + "]"));
            $(this).find(".input_serialnambers_id_serial_numbers").attr('id', ("input_serialnambers_serial_numbers_name-" + id + "-" + (index + 1)));
            $(this).find(".input_serialnambers_id_serial_numbers").attr('name', ("SerialNumbersEdit[id_serial_numbers_array][" + (index + 1) + "]"));
            $(this).find("a").attr('id', ("delete_another_serialnambers-" + id + "-" + (index + 1)));
            console.log(index + " - Счетчик изменяемых параметров");
        });
        $('#add_another_serial_numbers_name-' + id).attr('data-count-serial_numbers_name', (count - 1));
        if (count == 2) {
            $("#delete_another_serialnambers-" + id + "-1").remove();
        }
    }

}

//Обработчик нажатия кнопки Применить в userbox
$('.index_stock_bloc').on('click', '.serialnambers_apply_button', function () {
    console.log(dataKard);
    //alert("Вы нажали кнопку пременить");        
    var id = GetId($(this), 1);
    var dataKard1 = GetDataCardOrders(id);
    var s1 = JSON.stringify(dataKard);
    var s2 = JSON.stringify(dataKard1);
    console.log("сравнение двух обьектов:" + (s1 == s2));
    if (!(s1 == s2)) {
        var arrayFieldsChecked = ['brand_name-', 'device_type_name-', 'devices_model-', 'serial_numbers_name-','equipment_stock-'];
        errorDeleteServerTreatment(arrayFieldsChecked, id);
        var EndRequest = '';
        if(id == 0){
            EndRequest = 'addserialnambersinstock';
        }else{
            EndRequest = 'updateserialnamber';
        }
        if (true/*formFieldCheck(id, arrayFieldsChecked)*/) {
            alert("Проверка Проверка прошла успешно");            
            var data = $('#form_serialnambers_stock-' + id).serialize();
            console.log(data);
            $.ajax({
                url: '/yii-application/backend/web/stock/stocks/'+EndRequest,
                type: 'POST',
                data: data,
                success: function (res) {
                    console.log(res);
                    if(id == 0){
                        if (Number(res[0]) == 0) {
                            console.log(res['msg']);
                            console.log(res['errorsBrandsEdit']);
                            console.log(res['errorsDeviceTypeEdit']);
                            console.log(res['errorsDevicesEdit']);
                            console.log(res['errorsSerialNumbersEdit']);
                            console.log(processingErrorsServer(res, id));
                            var arr = processingErrorsServer(res, id); 
                            errorServerTreatment(arr,id);
                        } else {
                            console.log(res);
                            if (res['txt'] == 0) {
                                alert(res['msg']);
                            } else {                            
                                settingCardData(dataKard, id);
                                $('#Block_add_serialnumbers-0').hide();
                                $('.empty').remove();
                                switch (res['msg']){
                                    case 'one':
                                        $("#w0").prepend("<div class='' data-key='[]' >" + res['txt'] + "</div>");
                                        break;
                                    case 'range':
                                        $("#w0").prepend(res['txt']);
                                        console.log("Ошибки с серийными номерами по складам -" + res['textError']);
                                        if(Number(res['textError'])!=0){
                                            alert(res['textError']);
                                        }    
                                        break;
                                }
                                //$("#w0").prepend("<div class='' data-key='[]' >" + res['txt'] + "</div>");
                                SetStatusCard(0, "");
                                return false;                            
                            }
                        }
                    }else{
                        if (Number(res[0]) == 0) {
                            console.log(res['msg']);
                            console.log(res['errorsBrandsEdit']);
                            console.log(res['errorsDeviceTypeEdit']);
                            console.log(res['errorsDevicesEdit']);
                            console.log(res['errorsSerialNumbersEdit']);
                            console.log(processingErrorsServer(res, id));
                            var arr = processingErrorsServer(res, id); 
                            errorServerTreatment(arr,id);
                        } else {
                            
                        }                        
                        
                    }
                },
                error: function (jqXHR) {
                    console.log(jqXHR);
                    alert(jqXHR.responseText);
                }
            });
        } else {
            alert("Проверка прошла не успешно");
        }
    } else {
        if (id == 0) {
            SetStatusCard(0, "");
            $('#Block_add_serialnumbers-0').hide();
            return false;
        } else {
            SetStatusCard(id, "#span_serialnumbers_id_serial_numbers-");
            $('#stock_card_button_edit_delete-' + id).show();
            $('#serialnumbers_content-' + id).show();
            $('#serialnambers_cancel_button_card_apply-' + id).hide();
            $('#serialnumbers_form-' + id).hide();
            return false;
        }
    }
});

/**
 * Функция проверяет поля редактируемого пользователя
 * */
function formFieldCheck(id, arrayFieldsChecked) {
    var arrayError = {};
    var countError = 0;
    $.each(arrayFieldsChecked, function (i, val) {
        console.log(i + " - " + val);
        switch ("input_serialnambers_" + val) {
            case "input_serialnambers_brand_name-":
                if (empty($('#input_serialnambers_' + val + id).val())) {
                    countError++;
                    arrayError['brand_name-' + id] = 'Заполните поле Бренд';
                }
                break;
            case "input_serialnambers_device_type_name-":
                if (empty($('#input_serialnambers_' + val + id).val())) {
                    countError++;
                    arrayError['device_type_name-' + id] = 'Заполните поле тип устройства';
                }
                break;
            case "input_serialnambers_devices_model-":
                if (empty($('#input_serialnambers_' + val + id).val())) {
                    countError++;
                    arrayError['devices_model-' + id] = 'Заполните поле модель устройсва';
                }
                break;
            case "input_serialnambers_serial_numbers_name-":
                var checked = $("input[name='type_addition']:checked").val();
                switch (checked){
                    case 'one':
                        if (empty($('#input_serialnambers_' + val + id).val())) {
                            countError++;
                            arrayError['serial_numbers_name-' + id] = 'Заполните поле серийный номер';
                        }
                        break;
                    case 'range':
                        console.log("Значение serialNambers"+arrayError.hasOwnProperty('serial_numbers_name-' + id));
                        if (empty($('#input_serialnambers_' + val + id).val())) {
                            countError++;
                            if(!arrayError.hasOwnProperty('serial_numbers_name-' + id)){
                                arrayError['serial_numbers_name-' + id] = 'Заполните поле общею часть серийных номеров ';
                            }else{
                                arrayError['serial_numbers_name-' + id] = arrayError['serial_numbers_name-' + id] + 'Заполните поле общею часть серийных номеров ';
                            }    
                        }
                        if (empty($('#input_serialnambers_serial_numbers_start_range-' + id).val())) {
                            countError++;
                            if(!arrayError.hasOwnProperty('serial_numbers_name-' + id)){
                                arrayError['serial_numbers_name-' + id] = 'Заполните начало диапазона  ';
                            }else{
                                arrayError['serial_numbers_name-' + id] = arrayError['serial_numbers_name-' + id] + 'Заполните начало диапазона ';
                            }    
                        }
                        if (empty($('#input_serialnambers_serial_numbers_end_range-' + id).val())) {
                            countError++;
                            if(!arrayError.hasOwnProperty('serial_numbers_name-' + id)){
                                arrayError['serial_numbers_name-' + id] = 'Заполните конец диапазона ';
                            }else{
                                arrayError['serial_numbers_name-' + id] = arrayError['serial_numbers_name-' + id] + 'Заполните конец диапазона ';
                            }    
                        }//isNaN(str).
                        if (isNaN($('#input_serialnambers_serial_numbers_start_range-' + id).val())) {
                            countError++;
                            if(!arrayError.hasOwnProperty('serial_numbers_name-' + id)){
                                arrayError['serial_numbers_name-' + id] = 'Начало диапазона не число введите число ';
                            }else{
                                arrayError['serial_numbers_name-' + id] = arrayError['serial_numbers_name-' + id] + 'Начало диапазона не число введите число ';
                            }    
                        }
                        if (isNaN($('#input_serialnambers_serial_numbers_end_range-' + id).val())) {
                            countError++;
                            if(!arrayError.hasOwnProperty('serial_numbers_name-' + id)){
                                arrayError['serial_numbers_name-' + id] = 'Конец диапазона не число введите число ';
                            }else{
                                arrayError['serial_numbers_name-' + id] = arrayError['serial_numbers_name-' + id] + 'Конец диапазона не число введите число ';
                            }    
                        }
                        break;
                    case 'some':
                        var countErrorSerial = 0;
                        var countErrorComparison = 0;
                        var temporarily = [];
                        console.log($('.input_check_serialnambers-' + id));
                        $('.input_check_serialnambers-' + id).each(function (index) {
                            console.log("Счетчик серийных номеров - "+(index+1));
                            if (empty($('#input_serialnambers_' + val+id+'-'+(index+1)).val())){
                                countErrorSerial++;
                            }else{
                                if(!empty($('#input_serialnambers_' + val+id+'-'+(index+1)).val())){
                                    temporarily.push($('#input_serialnambers_' + val+id+'-'+(index+1)).val());
                                }    
                            }
                        });
                        console.log(temporarily);
                        if(countErrorSerial!=0){
                            countError++;
                            arrayError['serial_numbers_name-' + id] = 'Одно или более полей серийных номеров не заполнено';
                        }else{
                            for (var i = 0; i < temporarily.length; i++) {
                                if(countErrorComparison>0){
                                    arrayError['serial_numbers_name-' + id] = 'Одно или более полей серийных номеров совпадают';
                                    break;
                                }
                                for (var j = 0; j < temporarily.length; j++) {
                                    console.log("Сравнение - "+temporarily[i]+"-"+temporarily[j]+":"+temporarily[i].localeCompare(temporarily[j]));
                                    if(temporarily[i].localeCompare(temporarily[j])==0 && i!=j){
                                        countError++;
                                        arrayError['serial_numbers_name-' + id] = 'Одно или более полей серийных номеров совпадают';
                                        countErrorComparison++;
                                        break;
                                    }
                                }
                            }
                        }
                        break;
                }
                break;
        }
    });
    if (countError == 0) {
        return true
    } else {
        errorServerTreatment(arrayError);
        return false
    }

}

//Функция обработки полученных ошибок с сервера
function errorServerTreatment(arrayError) {
    console.log('Начало функции errorServerTreatment');
    //перебирает поля с данными, присланные с сервера
    $.each(arrayError, function (index, value) {
        console.log('1Индекс: ' + index.toString() + '; Значение: ' + value.toString());
        $('#error_serialnambers_' + index.toString()).text(value.toString());//Добавляем текст ошибки
        $('#error_serialnambers_' + index.toString()).show();//Блок ошибки показываем пользователю
        console.log($('#error_serialnambers_' + index.toString()));
        $('#input_serialnambers_' + index.toString()).addClass('is-invalid');//Окрашиваем поле где ошибка в красный
        console.log($('#input_serialnambers_' + index.toString()));
    });
    return false;
}

function processingErrorsServer(res, id) {
    var arrayError = {};

    if (!empty(res['errorsBrandsEdit'])) {
        $.each(res['errorsBrandsEdit'], function (index, value) {
            console.log('errorsBrandsEdit Индекс: ' + index.toString() + '; Значение: ' + value.toString());
            arrayError[index.toString() + '-' + id] = value.toString();
        });
    }
    if (!empty(res['errorsDeviceTypeEdit'])) {
        $.each(res['errorsDeviceTypeEdit'], function (index, value) {
            console.log('errorsDeviceTypeEdit Индекс: ' + index.toString() + '; Значение: ' + value.toString());
            arrayError[index.toString() + '-' + id] = value.toString();
        });
    }
    if (!empty(res['errorsDevicesEdit'])) {
        $.each(res['errorsDevicesEdit'], function (index, value) {
            console.log('errorsDevicesEdit Индекс: ' + index.toString() + '; Значение: ' + value.toString());
            arrayError[index.toString() + '-' + id] = value.toString();
        });
    }
    if (!empty(res['errorsSerialNumbersEdit'])) {
        $.each(res['errorsSerialNumbersEdit'], function (index, value) {
            console.log('errorsSerialNumbersEdit Индекс: ' + index.toString() + '; Значение: ' + value.toString());
            if(!arrayError.hasOwnProperty('serial_numbers_name-'+id)){
                arrayError['serial_numbers_name-' + id] = value.toString()+' ';
            }else{
                arrayError['serial_numbers_name-' + id] = arrayError['serial_numbers_name-' + id] + value.toString()+' ';
            }    
        });
    }
       
    if (!empty(res['errorsEquipmentStockEdit'])) {
        $.each(res['errorsEquipmentStockEdit'], function (index, value) {
            console.log('errorsEquipmentStockEdit Индекс: ' + index.toString() + '; Значение: ' + value.toString());
            if(!arrayError.hasOwnProperty('equipment_stock-'+id)){
                arrayError['equipment_stock-' + id] = value.toString()+' ';
            }else{
                arrayError['equipment_stock-' + id] = arrayError['equipment_stock-' + id] + value.toString()+' ';
            }    
        });
    }
    return arrayError;
}

//Функция очишает все ошибки в карточке
function errorDeleteServerTreatment(arrayError, id) {

    $.each(arrayError, function (index, value) {
        console.log("Номер итерации" - index);
        $('#error_serialnambers_' + value.toString() + '' + id).text('');
        $('#error_serialnambers_' + value.toString() + id).hide();//Блок ошибки показываем пользователю
        console.log("Номер карточки - "+id);
        $('#input_serialnambers_' + value.toString() + id).removeClass('is-invalid');
        console.log($('#error_serialnambers_' + value.toString() + '' + id));
        /*
        if (value.toString().localeCompare("clients_phone-") == 0) {
            console.log("Блок телефонов" + $('.error_orders_phone-' + id));
            $('.error_orders_phone-' + id).each(function (index) {
                console.log("Ошибка :" + this);
                $(this).text('');
                $(this).hide();
                $(this).removeClass('is-invalid');
            });
            console.log("Конец блока");
        } else {
            if (value.toString().localeCompare("malfunction-") == 0) {
                console.log("Блок телефонов" + $('.error_orders_phone-' + id));
                $('.error_orders_malfunction-' + id).each(function (index) {
                    console.log("Ошибка :" + this.id);
                    $(this).text('');
                    $(this).hide();
                    $(this).removeClass('is-invalid');
                });
                console.log("Конец блока");
            } else {
                $('#error_orders_' + value.toString() + '' + id).text('');
                $('#error_orders_' + value.toString() + id).hide();//Блок ошибки показываем пользователю
                console.log(id);
                $('#input_orders_' + value.toString() + id).removeClass('is-invalid');
                console.log($('#error_orders_' + value.toString() + '' + id));
            }
        }
        */
    });
}