jQuery(window).load(function(){
    if(jQuery('.student_successs-carousel').length != 0){
        jQuery('.student_successs-carousel').each(function(){
            var offset = jQuery(this).attr('data-offset');
            var howmany = jQuery(this).attr('data-howmany');
            var timeout = jQuery(this).attr('data-timeout');

            function testAct(awidth, containerWidth, getWidth, carouselPop) {
                containerWidth = carouselPop.width();
                awidth = 0;
                getWidth = 0;
                var itemWidth = Math.round(containerWidth/howmany) - 1;

                carouselPop.children('.carousel-list').children('div').css('width', itemWidth+'px');

                carouselPop.children('.carousel-list').children('div').each(function(){
                    getWidth = jQuery(this).outerWidth();

                    awidth += getWidth;
                });

                if(awidth > containerWidth){
                    jQuery('#student_success-pr-nx-'+offset).show();
                    carouselPop.children('.carousel-list').css('width', awidth+'px');
                }else{
                    jQuery('#student_success-pr-nx-'+offset).hide();
                    carouselPop.children('.carousel-list').css('left', 0);
                }

                return {getWidth:getWidth, awidth:awidth, containerWidth:containerWidth}
            }

            function testvids() {
                var carouselPop = jQuery('#student_successs-'+offset);


                var awidth = 0;
                var containerWidth = 0;
                var getWidth = 0;

                getAllWidths = testAct(awidth, containerWidth, getWidth, carouselPop);
                getWidth = getAllWidths.getWidth;
                awidth = getAllWidths.awidth;
                containerWidth = getAllWidths.containerWidth;



                jQuery(window).resize(function(){
                    getAllWidths = testAct(awidth, containerWidth, getWidth, carouselPop);
                    getWidth = getAllWidths.getWidth;
                    awidth = getAllWidths.awidth;
                    containerWidth = getAllWidths.containerWidth;

                    var containerHeight = carouselPop.children('.carousel-list').outerHeight();
                    carouselPop.css('height', containerHeight+'px');
                });

                var containerHeight = carouselPop.children('.carousel-list').outerHeight();
                carouselPop.css('height', containerHeight+'px');

                jQuery('#student_success-pr-nx-'+offset).children('div').children('div').click(function(){
                    var handler = arguments.callee;
                    jQuery('#student_success-pr-nx-'+offset).children('div').children('div').off("click", handler);

                    var getclass = jQuery(this).parent('div').attr('class');
                    getclass = getclass.split('-');
                    getclass = getclass[1];

                    var getleft = carouselPop.children('.carousel-list').position().left;
                    var move = getleft - getWidth;

                    if(getclass == 'next'){
                        carouselPop.children('.carousel-list').animate({
                            left: move
                        }, Number(timeout), function(){
                            carouselPop.children('.carousel-list').children('div').first().appendTo(jQuery(this));
                            jQuery(this).css('left', 0);
                            jQuery('#student_success-pr-nx-'+offset).children('div').children('div').click(handler);
                        });
                    }

                    if(getclass == 'prev'){
                        carouselPop.children('.carousel-list').children('div').last().prependTo(carouselPop.children('.carousel-list'));
                        carouselPop.children('.carousel-list').css('left', move);

                        carouselPop.children('.carousel-list').animate({
                            left: 0
                        }, Number(timeout), function(){
                            jQuery('#student_success-pr-nx-'+offset).children('div').children('div').click(handler);
                        });
                    }
                });
            }

            testvids();
        });
    }
});
