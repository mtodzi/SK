var dataKard = {};
$(".phone").mask("8(999)-999-99-99");
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

//Обработчик нажатия кнопки добавить новый клиент
$('.my_heders_bloc').on('click', '#add_new_clients', function(){
    alert ("Вы нажали кнопку дабавить клиента");
        if(GetStatusCard()){
            SetStatusCard(0,"");
            $('#Block_add_clients-0').show();
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
                var employeename = "Вы добавляете нового клиента";
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
//Функция собирает данные открытой карточки передаеться id клиента открываемогокарты    
function GetDataCardOrders(id){
    var data={};
    data = {
        'id_clients':$("#input_id_clients-"+id).val(),
        'clients_name':$("#input_clients_name-"+id).val(),        
        'clients_email':$("#input_clients_email-"+id).val(),
        'clients_address':$("#input_clients_address-"+id).val(),
        'phone_number':{},        
    };
    $(".phone_input-"+id).each(function(index){
        console.log($(this));
        data['phone_number'][(index+1)] = $(this).val(); 
    });
    return data;
}

//Обработчик нажатия кнопки добавить еше один телефон
$('.my_box_content').on('click', '.add_another_phone', function(){
        var id_clients = GetId($(this),1);
        var count_phone = Number($(this).attr('data-count-phone'));
        console.log('id_clients-'+id_clients+" count_phone-"+count_phone);
        addInputPhone(id_clients,count_phone);
        $(this).tooltip('update');
        $(this).tooltip('hide');
        $(this).blur();
        return false;
});

//Функция добавляет поле телефона для заполнения не больше трех полей одному клиенту
function addInputPhone(id_clients,count_phone,value = ""){
        var count = $('.phone_input-'+id_clients).length;
        console.log("Число телефонов - "+count_phone);
        var next = Number(count_phone)+1;
        var buttondelete=""+
                "<a  id = 'delete_another_phone-"+id_clients+"-"+next+"' class='btn btn-dark delete_another_phone delete_another_phone-"+id_clients+" mx-1'  data-count-phone='"+next+"' data-toggle='tooltip' data-placement='right' title='Удалить телефон'>"+
                    "<img id ='menu_navbar_top' class='' src='/yii-application/backend/web/m_orders/img/minus.svg' alt='Удалить телефон'>"+
                "</a>";
        var buttondeleteFirst=""+
                "<a  id = 'delete_another_phone-"+id_clients+"-1' class='btn btn-dark delete_another_phone delete_another_phone-"+id_clients+" mx-1'  data-count-phone='"+next+"' data-toggle='tooltip' data-placement='right' title='Удалить телефон'>"+
                    "<img id ='menu_navbar_top' class='' src='/yii-application/backend/web/m_orders/img/minus.svg' alt='Удалить телефон'>"+
                "</a>";
        var input =''+
                "<div id = 'div_clients_phone-"+id_clients+"-"+next+"' class='div_orders_phone-"+id_clients+"'>"+     
                    "<p id='p_clients_phone-"+id_clients+"-"+next+"' class='form-row my-2 orders_phone-"+id_clients+" clients_phone'>"+
                        "<img class='my_icon mx-1 my-2' src='/yii-application/backend/web/img/smartphone-call.svg'>"+
                        "<input id='input_clients_phone-"+id_clients+"-"+next+"' data-input-name = 'clients_phone' value = '"+value+"' name='ClientsPhonesEdit[phone_number]["+next+"]'  form='form_clients-"+id_clients+"' class='form-control col-8 input_clients phone phone_input phone_input-"+id_clients+"' type='text' placeholder='*Введите номер телефона'>"+
                        "<p id = 'error_clients_phone-"+id_clients+"-"+next+"' class='text-danger my-2 mx-2 error_clients_phone error_clients_phone-"+id_clients+"' style='display: none;'>Ошибка</p>"+
                    "</p>"+
                "</div>";
        
        if(count<=2 && count!=0){            
            $("#search_input_phone_number-"+id_clients).remove();
            $('#add_another_phone-'+id_clients).attr('data-count-phone',next);
            $('#delete_another_phone-'+id_clients).attr('data-count-phone',next);
            $("#div_clients_phone-"+id_clients+"-"+count_phone).after(input); 
            $(("#input_clients_phone-"+id_clients+"-"+next)).after(buttondelete);
            $('[data-toggle="tooltip"]').tooltip();
            $(".phone").mask("8(999)-999-99-99");
            if(count_phone==1){
                $(("#input_clients_phone-"+id_clients+"-1")).after(buttondeleteFirst);
                $('[data-toggle="tooltip"]').tooltip();
            }    
            console.log(count_phone);
            console.log(input);
            return true;
        }else{
            if(count == 0){
                $("#search_input_phone_number-"+id_clients).remove();
                $('#add_another_phone-'+id_clients).attr('data-count-phone',next);            
                $("#p_add_another_phone-"+id_clients).before(input); 
                $('[data-toggle="tooltip"]').tooltip();
                $(".phone").mask("8(999)-999-99-99");
                console.log("Попытка добавить");
            }else{
                alert("Больше трех телефонов клиенту добавлять нельзя");
                return true;
            }            
        }    
    }
    
//Обработчик нажатия кнопки Удалить еше один телефон
$('.my_content_bloc').on('click', '.delete_another_phone', function(){
        var id_clients = GetId($(this),1);
        var id_delete = GetId($(this),2);
        var count_phone = Number($(this).attr('data-count-phone'));
        console.log('id_clients-'+id_clients+" id_delete-"+id_delete);
        $(this).tooltip('update');
        $(this).tooltip('hide');
        $(this).blur();
        deleteInputPhone(id_clients,id_delete,count_phone);
        return false;
    });
    
//Функция инпут телефона 
function deleteInputPhone(id_clients,id_delete,count_phone){
        var count = $('.phone_input-'+id_clients).length;
        console.log(count);
        $("#search_input_phone_number-"+id_clients).remove();
        if(count>1){
            $("#div_clients_phone-"+id_clients+"-"+id_delete).remove();
            $('.div_clients_phone-'+id_clients).each(function(index){
                console.log($(this));
                $(this).attr('id',("div_clients_phone-"+id_clients+"-"+(index+1)));
                $(this).find("input").attr('id',("input_clients_phone-"+id_clients+"-"+(index+1)));
                $(this).find("input").attr('name',("ClientsPhonesEdit[phone_number]["+(index+1)+"]"));
                $(this).find("a").attr('id',("delete_another_phone-"+id_clients+"-"+(index+1)));
                $(this).find("p .error_clients_phone").attr('id',("error_clients_phone-"+id_clients+"-"+(index+1)));
                $(this).find("p .clients_phone").attr('id',("p_clients_phone-"+id_clients+"-"+(index+1)));
                console.log( index + ": ");
            });
            $('#add_another_phone-'+id_clients).attr('data-count-phone',(count-1));
            if(count==2){
                $("#delete_another_phone-"+id_clients+"-1").remove();
            }
        }
        
    }