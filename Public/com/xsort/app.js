$(document).ready(function(){
    $(".Regional").click(function(){
        if ($('.grade-eject').hasClass('grade-w-roll')) {
            $(".screening > ul > li > i").removeClass('glyphicon-menu-up').addClass('glyphicon-menu-down');
            $(this).children(".glyphicon").removeClass('glyphicon-menu-up').addClass('glyphicon-menu-down');
            $('.grade-eject').removeClass('grade-w-roll');
        } else {
            $(this).children(".glyphicon").removeClass('glyphicon-menu-down').addClass('glyphicon-menu-up');
            $('.grade-eject').addClass('grade-w-roll');
        }
    });

    $(".grade-w>li").click(function(){
        $(".grade-t")
            .css("left","33.48%")
    });

    $(".grade-t>li").click(function(){
        $(".grade-s")
            .css("left","66.96%")
    });

    $(".Brand").click(function(){
        if ($('.Category-eject').hasClass('grade-w-roll')) {
            $(".screening > ul > li > i").removeClass('glyphicon-menu-up').addClass('glyphicon-menu-down');
            $(this).children(".glyphicon").removeClass('glyphicon-menu-up').addClass('glyphicon-menu-down');
            $('.Category-eject').removeClass('grade-w-roll');
        } else {
            $(this).children(".glyphicon").removeClass('glyphicon-menu-down').addClass('glyphicon-menu-up');
            $('.Category-eject').addClass('grade-w-roll');
        }
    });

    $(".Category-w>li").click(function(){
        $(".Category-t")
            .css("left","33.48%")
    });

    $(".Category-t>li").click(function(){
        $(".Category-s")
            .css("left","66.96%")
    });

    $(".Sort").click(function(){
        if ($('.Sort-eject').hasClass('grade-w-roll')) {
            $(".screening > ul > li > i").removeClass('glyphicon-menu-up').addClass('glyphicon-menu-down');
            $(this).children(".glyphicon").removeClass('glyphicon-menu-up').addClass('glyphicon-menu-down');
            $('.Sort-eject').removeClass('grade-w-roll');
        } else {
            $(this).children(".glyphicon").removeClass('glyphicon-menu-down').addClass('glyphicon-menu-up');
            $('.Sort-eject').addClass('grade-w-roll');
        }
    });

    $(".Regional").click(function(){
        if ($('.Category-eject').hasClass('grade-w-roll')){
            $('.Category-eject').removeClass('grade-w-roll');
        };
    });

    $(".Regional").click(function(){
        if ($('.Sort-eject').hasClass('grade-w-roll')){
            $('.Sort-eject').removeClass('grade-w-roll');
        };
    });

    $(".Brand").click(function(){
        if ($('.Sort-eject').hasClass('grade-w-roll')){
            $('.Sort-eject').removeClass('grade-w-roll');
        };
    });

    $(".Brand").click(function(){
        if ($('.grade-eject').hasClass('grade-w-roll')){
            $('.grade-eject').removeClass('grade-w-roll');
        };
    });

    $(".Sort").click(function(){
        if ($('.Category-eject').hasClass('grade-w-roll')){
            $('.Category-eject').removeClass('grade-w-roll');
        };
    });

    $(".Sort").click(function(){
        if ($('.grade-eject').hasClass('grade-w-roll')){
            $('.grade-eject').removeClass('grade-w-roll');
        };

    });


});