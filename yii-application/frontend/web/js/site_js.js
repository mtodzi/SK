/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//меню после прокрутки Affix
$(document).ready(function() {

    var toggleAffix = function(affixElement, scrollElement, wrapper) {
  
        var height = affixElement.outerHeight(),
        top = wrapper.offset().top;
    
        if (scrollElement.scrollTop() >= top){
            wrapper.height(height);
            affixElement.addClass("affix");
            affixElement.addClass("navbar-dark");
        $('.img_nav').show(); 
        $('.img_home').hide(); 
        }
        else {
            affixElement.removeClass("affix");
            affixElement.removeClass("navbar-dark");
            wrapper.height('auto');
        $('.img_nav').hide(); 
        $('.img_home').show();
        }
      
    };
  

    $('[data-toggle="affix"]').each(function() {
    var ele = $(this),
        wrapper = $('<div></div>');
    ele.before(wrapper);
    $(window).on('scroll resize', function() {
        toggleAffix(ele, $(this), wrapper);
    });
    // инициализация
    toggleAffix(ele, $(window), wrapper);
    });
});

//разворачивание текста в p за span по клику
$(function() {
    $('.letter_red').on('click', function() {
        $(this).next().toggle(1000);
    });
});

//предотвращение перехода по ссылке для проверки
//$( "a" ).click(function( event ) {
  //event.preventDefault();
    /*console.log(event.type);*/
//});

//выбор цвета обводки карточки
/*$(".card-body").mouseleave(function() { console.log(this);
    var currentColor = window.getComputedStyle(this).getPropertyValue('color').replace(/rgb\((.+)\)/g, '$1').split(', ').map(function(e){return parseInt(e);});
    var nextColor = getRandomColor();
    var currentStep = 0;
    var steps = 0.5;
    currentStep++;
    var color = 'rgb( ' + currentColor.map(function(e,i){
    return Math.floor(e + (nextColor[i] - e) * currentStep / steps);
    }).join(', ') + ')';
    $(this).css('color', color);
    this.style.backgroundColor = 'rgb( ' + currentColor.map(function(e,i){
    return Math.floor(e - (nextColor[i] - e) * currentStep / steps);
    }).join(', ') + ')';
    if (currentStep == steps) {
        currentStep = 0;
        currentColor = nextColor;
        nextColor = getRandomColor();
    }
})*/

// функция рандомизации цвета
/*function getRandomColor() {
  var color = [];
  while (color.length < 3) color.push(Math.floor(Math.random() * 255));
  return color;
}*/