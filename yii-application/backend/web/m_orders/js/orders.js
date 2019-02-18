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
    });
    //Функция добавляет поле телефона для заполнения не больше трех полей одному клиенту
    function addInputPhone(id_orders,count_phone){
        if(count_phone<=2){
            var next = count_phone+1;
            var buttondelete=""+
                    "<a  id = 'delete_another_phone-0' class='btn btn-dark delete_another_phone mx-1' href='#' data-count-phone='"+next+"' data-toggle='tooltip' data-placement='left' title='Удалить телефон'>"+
                        "<img id ='menu_navbar_top' class='' src='/yii-application/backend/web/img/add.svg' alt='Удалить телефон'>"+
                    "</a>";
            var input =''+
                    "<p id='p_orders_clients_phone-"+id_orders+"-"+next+"' class='form-row my-2'>"+
                        "<img class='my_icon mx-1 my-2' src='/yii-application/backend/web/img/smartphone-call.svg'>"+
                        "<input id='input_orders_clients_phone-"+id_orders+"-"+next+"' name='ClientsPhonesEdit[phone_number-"+next+"]'  form='' class='form-control col-10 phone' type='text' placeholder='*Введите номер телефона'>"+
                        "<p id = 'error_orders_phone-"+id_orders+"-"+next+"' class='text-danger my-2 mx-2' style='display: none;'>Ошибка</p>"+
                    "</p>";
            $('#add_another_phone-'+id_orders).attr('data-count-phone',next);
            $('#delete_another_phone-'+id_orders).attr('data-count-phone',next);
            $("#p_orders_clients_phone-"+id_orders+"-"+count_phone).after(input);            
            $(".phone").mask("8(999)-999-99-99");
            if(count_phone==1){
                $("#add_another_phone-"+id_orders).before(buttondelete);
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
    //Обработчик нажатия кнопки добавить еше один телефон
    $('.my_box_content').on('click', '.delete_another_phone', function(){
        var id_orders = GetId($(this),1);
        var count_phone = Number($(this).attr('data-count-phone'));
        console.log('id_orders-'+id_orders+" count_phone-"+count_phone);
        $(this).tooltip('update');
        $(this).tooltip('hide');
        $(this).blur();
        deleteInputPhone(id_orders,count_phone);        
    });
    function deleteInputPhone(id_orders,count_phone){
        var next = count_phone-1
        if(count_phone>1 && count_phone<=3){
            $("#p_orders_clients_phone-"+id_orders+"-"+count_phone).remove();
            $('#delete_another_phone-'+id_orders).attr('data-count-phone',next);
            $('#add_another_phone-'+id_orders).attr('data-count-phone',next);
            if(count_phone==2){
                //$("#delete_another_phone-"+id_orders).tooltip('disable');
                $("#delete_another_phone-"+id_orders).remove();
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
        }else{
            return false;
        }
       
    });
    //Обработчик нажатия кнопки Применить в userbox
    $('.my_content_bloc').on('click', '.orders_apply_button', function(){
        //alert("Вы нажали кнопку пременить");
        var id = GetId($(this),1);
        var arrayFieldsChecked = ['clients_name-']; 
        if(formFieldCheck(id,arrayFieldsChecked)){
            alert("Проверка Проверка прошла успешно");
        }else{
            alert("Проверка Проверка прошла не успешно");
        }
    });
    //Обработчик ввода текста в input_clients_name
    $('.my_content_bloc').on('keyup', '.input_clients_name', function(eventObject){
        var id = GetId($(this),1);
        var data={};
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
                    }    
                },
                error: function(){
                    alert('По неизвестной причине сервер не ответил обратитесь к админу.');
                }
            });
    });
    
     //Обработчик нажатия на option в подсказке clients_name в userbox
    $('.my_content_bloc').on('click', '.option_clients_name', function(){
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
                        arrayError['clients_name-']='Заполните ФИО клиента';
                    }    

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
    function errorServerTreatment(arrayError,id){
        //перебирает поля с данными, присланные с сервера
        $.each(arrayError,function(index,value){
            console.log('Индекс: ' + index.toString() + '; Значение: ' + value.toString());
            $('#error_orders_'+index.toString()+id).text(value.toString());//Добавляем текст ошибки
            $('#error_orders_'+index.toString()+id).show();//Блок ошибки показываем пользователю
            console.log($('#error_orders_'+index.toString()+id));
            $('#input_orders_'+index.toString()+id).addClass('is-invalid');//Окрашиваем поле где ошибка в красный
            console.log($('#input_orders_'+index.toString()+id));
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
  })
})
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
