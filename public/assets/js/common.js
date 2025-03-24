$(function (e) {
    $width = $(window).innerWidth(),
        wWidth = windowWidth();

    $(document).ready(function (e) {
        //btnTop();
        gnb();
        fileUpload();
        datepicker();
        popup();
        imgMap();
        colorPicker();

        resEvt();

    });

    // resize
    function resEvt() {
        conHeight();

        if (wWidth < 1025) {
        } else {
        }

        if(wWidth < 769){
            touchHelp();
        }else{
        }
    }

    $(window).resize(function (e) {
        $width = $(window).innerWidth(),
                wWidth = windowWidth();
        resEvt();
    });

    $(window).scroll(function(e){
        if($(this).scrollTop() > 200){
            $('.js-btn-top').addClass('on');
        }else{
            $('.js-btn-top').removeClass('on');
        }
    });
});

function Mobile() {
    return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
}

function windowWidth() {
    if ($(document).innerHeight() > $(window).innerHeight()) {
        if (Mobile()) {
            return $(window).innerWidth();
        } else {
            return $(window).innerWidth() + 17;
        }
    } else {
        return $(window).innerWidth();
    }
}

function conHeight(){
    $(document).ready(function(e){
        var conHeight = $(window).outerHeight();
        setTimeout(function(e){
            $('.wrap').css('min-height',conHeight);
        },100);
    });
}

function gnb() {
    $('.js-gnb > li > a').on('click',function(e){
        if($(this).next('ul').length){
            $(this).parent('li').stop().toggleClass('on');
            $(this).next('ul').stop().slideToggle();
            $('.js-gnb > li > a').not(this).parent('li').removeClass('on');
            $('.js-gnb > li > a').not(this).next('ul').stop().slideUp();
            return false;
        }
    });
    $('.btn-menu-open').on('click',function(e){
        $('.js-header').removeClass('on');
        if($(this).hasClass('active')){
            $(this).removeClass('active');
            $('#header, .contop, #container').removeClass('active');
            $('.js-gnb > li.on > ul').stop().show();
        }else{
            $(this).addClass('active');
            $('#header, .contop, #container').addClass('active');
            $('.js-gnb > li.on > ul').stop().hide();
        }
    });
    $('.js-header').on('mouseenter',function(e){
        if($(this).hasClass('active')){
            $(this).addClass('on');
            $('#header, .contop, #container').addClass('on');
            $('.js-gnb > li.on > ul').stop().show();
        }
    });
    $('.js-header').on('mouseleave',function(e){
        if($(this).hasClass('on')){
            $(this).removeClass('on');
            $('#header, .contop, #container').removeClass('on');
            $('.js-gnb > li.on > ul').stop().hide();
        }
    });
}

function btnTop(){
    $('.js-btn-top').on('click',function(e){
        $('html, body').stop().animate({'scrollTop':0},400);
        return false;
    });
}

function touchHelp(){
    $('.scroll-x').each(function(e){
        if($(this).height() < 180){
            $(this).addClass('small');
        }
        $(this).scroll(function(e){
            $(this).removeClass('touch-help');
        });
    });
}

function fileUpload(option=null){
    $('.file-upload').each(function(e){
        $(this).parent().find('.upload-name').attr('readonly','readonly');
        $(this).on('change',function(){
            var fileName = $(this).val();
            $(this).parent().find('.upload-name').val(fileName);
        });
    });
}

function datepicker(){
    if($('.datepicker').length){
        $('.datepicker').datepicker({
            dateFormat : "yy-mm-dd",
            dayNamesMin : ["월", "화", "수", "목", "금", "토", "일"],
            monthNamesShort : ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"],
            showMonthAfterYear: true,
            changeMonth : true,
            changeYear : true
        });
    }
}

function imgMap(){
    if($('img[usemap]').length){
        $('img[usemap]').each(function(e){
            $('img[usemap]').rwdImageMaps();
        });
    }
}

function popup(){
    $('.js-pop-open').on('click',function(e){
        var popCnt = $(this).attr('href');
        $('html, body').addClass('ovh');
        $('.popup-wrap'+popCnt+'').stop().fadeIn(200);
        $('.popup-wrap').scrollTop(0);
        return false;
    });
    $('.js-pop-close').on('click',function(e){
        $('html, body').removeClass('ovh');
        $(this).parents('.popup-wrap').stop().fadeOut(100);
        return false;
    });
    $('.popup-wrap#pop-privacy, .popup-wrap#pop-email').off().on('click', function (e){
        if ($('.popup-contents').has(e.target).length == 0){
            $('html, body').removeClass('ovh');
            $('.popup-wrap').stop().fadeOut(100);
        }
    });
}

function colorPicker(){
    $('.color-picker').each(function(e){
        $(this).on('input',function(e){
            var colorValue = 
            $(this).siblings('.color-value').text($(this).val().toUpperCase()).css('color',$(this).val());
        });
    });
}