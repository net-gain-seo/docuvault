(function($) {

    var stickAt;
    var windowWidth;
    var isSticky = false;

    var nav        = $('#mainNav');
    var siteHeader = $("#flexHeader");

    function doResizeActions(sticky) {


        windowWidth = window.innerWidth;
        if(sticky) {
            stickAt  = $(siteHeader).innerHeight();
        }

        // Mobile or desktop nav
        if( windowWidth < 992 ) {
            $(nav).removeClass('main-nav').addClass('mobile-nav');
        } else {
            $(nav).addClass('main-nav').removeClass('mobile-nav');
        }

        // return true;

    }
    function halfResize() {
        var c6width = $('#refContainer').children('.col-6').width();
        if($(window).innerWidth() > 558) {
            $('.halfbg > .col-6:first-child > div').css({'width':(c6width+15)+'px','margin-left':'auto'});
        }
        else {
            $('.halfbg > .col-6:first-child > div').attr('style','');
        }
    }
    function halfmapResize() {
        var c6width = $('#refContainer').children('.col-6').width();
        if($(window).innerWidth() > 767) {
            $('.halfmap > .col-6:first-child > div').css({'width':(c6width+15)+'px','margin-left':'auto'});
        }
        else {
            $('.halfmap > .col-6:first-child > div').attr('style','');
        }
    }
    function greenblueResize() {
        var c6width = $('#refContainer').children('.col-6').width();
        $('.greenbluebg .col-6 > div').css({'width':(c6width+15)+'px'});
        $('.greenbluebg .col-6:first-child > div').css({'margin-left':'auto'});
    }
    function halfsliderResize() {
        var c6width = $('#refContainer').children('.col-6').width();
        $('.halfslider > .col-6:first-child > div').css({'width':(c6width+15)+'px','margin-left':'auto'});
    }

    $(document).ready(function() {

		console.log('test', dataLayer);
        doResizeActions(true);
        if($('.halfbg').length > 0) {
            halfResize();
        }
        if($('.greenbluebg').length > 0) {
            greenblueResize();
        }
        if($('.halfmap').length > 0) {
            halfmapResize();
        }
        if($(window).innerWidth() > 991) {
            if($('.halfslider').length > 0) {
                halfsliderResize();
            }
        }
        $('.quote-pop').on('click',function(e) {
            e.preventDefault();
            $('#popForm').modal('show');
        })

		$(document).on('mailsent.wpcf7', function (e) {
			$form=$(e.target);

            //console.log('contact form id: ',e.detail.contactFormId);

			if($form.attr('id').search('f898')!=-1){
				dataLayer.push({'form_submitted': 'quote'});
			}
			else if($form.attr('id').search('f855')!=-1){
				dataLayer.push({'form_submitted': 'consultation'});
			}
			else if($form.attr('id').search('f904')!=-1){
				dataLayer.push({'form_submitted': 'email'});
			}
			else if($form.attr('id').search('f906')!=-1){
				dataLayer.push({'form_submitted': 'contact'});
			}
			console.log(dataLayer);
			dataLayer.push({'event': 'formSubmissionSuccess'});
			console.log(dataLayer);

            if($form.attr('id').search('f904')!=-1){
    			window.location = 'https://docuvaultdv.com/blog-sign-up-thank-you/';
            }else{
                window.location = 'https://docuvaultdv.com/thank-you/';
            }
		});


    });

    // @todo set/check variable for peformance optimization
    $(window).on('resize', function() {
        doResizeActions(false); // don't recalculate sticky-header
        halfResize();
        halfmapResize();
        greenblueResize();
        if($(window).innerWidth() > 991) {
            halfsliderResize();
        }
    });


    $(document).on("scroll", function() {
        if ( $(document).scrollTop() >= stickAt ) {
            if(!isSticky) {
                $("body").addClass("sticky-header");
                isSticky = true;
            }
        } else {
            if(isSticky) {
                $("body").removeClass("sticky-header");
                isSticky = false;
            }
        }
    });

    $('#navToggle, #closeNav, #openNavOverlay').on('click', function() {
        // console.log($(this));
        // return false;
        if($(this).context.className != 'get-quote') {
            $(mainNav).toggleClass('open');
            $('#closeNav').toggleClass('open');
            $('body').toggleClass('no-scroll');
        } else {
            $(mainNav).removeClass('open');
            $('#closeNav').removeClass('open');
            $('body').removeClass('no-scroll');
        }
    });

    $('.accordion-title').on('click',function() {
        var openAccordion = $('.accordion-content.open');
        var openAccordionClosed = $(openAccordion).prev('.accordion-title').children('i').attr('data-closed');
        var openAccordionOpen = $(openAccordion).prev('.accordion-title').children('i').attr('data-open');
        var closed = $(this).children('i').attr('data-closed');
        var open = $(this).children('i').attr('data-open');

        if($('.accordion-content.open').length > 0) {
            if($(this).next('.accordion-content').hasClass('open')) {
                $(this).next('.accordion-content').slideToggle().removeClass('open');
                $(this).children('i').removeClass('fa-'+open).addClass('fa-'+closed);
            }
            else {
                $(openAccordion).slideToggle().removeClass('open');
                $(openAccordion).prev('h3').children('i').removeClass('fa-'+openAccordionOpen).addClass('fa-'+openAccordionClosed);
                $(this).next('.accordion-content').addClass('open').slideToggle();
                $(this).children('i').removeClass('fa-'+closed).addClass('fa-'+open);
            }
        }
        else {
            $(this).children('i').removeClass('fa-'+closed).addClass('fa-'+open);
            $(this).next('.accordion-content').addClass('open').slideToggle();
        }

        // $('html, body').animate({
        //     scrollTop: $(this).offset().top - 125
        // }, 125);
    });

    //$(".menu-item-has-children").click(function(){
    //  $(".sub-menu").addClass("displayblock");
    //    return false;

  //  })

    //$(".menu-item-has-children").dblclick(function(){
    //    return true;
    //});
    function setup_collapsible_submenus() {
        var $menu = $('#mainNav.mobile-nav'),
            top_level_link = '#mainNav.mobile-nav .menu-item-has-children > a';

        $menu.find('a').each(function() {
            $(this).off('click');

            if ( $(this).is(top_level_link) ) {
                $(this).attr('href', '#');
            }

            if ( ! $(this).siblings('.sub-menu').length ) {
                $(this).on('click', function(event) {
                    $(this).parents('.mobile_nav').trigger('click');
                });
            } else {
                $(this).on('click', function(event) {
                    event.preventDefault();
                    $(this).parent().toggleClass('visible');
                });
            }
        });
    }

    $(window).load(function() {
        setTimeout(function() {
            setup_collapsible_submenus();
        }, 700);
    });


})(jQuery);
