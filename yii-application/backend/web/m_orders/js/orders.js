    //Обработчик нажатия кнопки редактировать в userbox
    $('.my_content_bloc').on('click', '.orders_edit_button', function(){
        var id = GetId($(this),1);
        if(GetStatusCard(id)){
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
            var employeename = $(StartSelector+id).text();
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
    function GetStatusCard(id){
        var status_card = Number($('#status_card').val());
        console.log(status_card);
        if(status_card == 0){
            return true;
        }else{
            var employeename = $('#status_card').attr('data-user-card');
            console.log(employeename);
            alert('Вы уже редактируете '+employeename);
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