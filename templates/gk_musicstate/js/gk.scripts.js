/**
 * jQuery Cookie plugin
 *
 * Copyright (c) 2010 Klaus Hartl (stilbuero.de)
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 */
jQuery.noConflict();
jQuery.cookie = function (key, value, options) {

    // key and at least value given, set cookie...
    if (arguments.length > 1 && String(value) !== "[object Object]") {
        options = jQuery.extend({}, options);

        if (value === null || value === undefined) {
            options.expires = -1;
        }

        if (typeof options.expires === 'number') {
            var days = options.expires, t = options.expires = new Date();
            t.setDate(t.getDate() + days);
        }

        value = String(value);

        return (document.cookie = [
            encodeURIComponent(key), '=',
            options.raw ? value : encodeURIComponent(value),
            options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
            options.path ? '; path=' + options.path : '',
            options.domain ? '; domain=' + options.domain : '',
            options.secure ? '; secure' : ''
        ].join(''));
    }

    // key and possibly options given, get cookie...
    options = value || {};
    var result, decode = options.raw ? function (s) { return s; } : decodeURIComponent;
    return (result = new RegExp('(?:^|; )' + encodeURIComponent(key) + '=([^;]*)').exec(document.cookie)) ? decode(result[1]) : null;
};

// IE checker
function gkIsIE() {
  var myNav = navigator.userAgent.toLowerCase();
  return (myNav.indexOf('msie') != -1) ? parseInt(myNav.split('msie')[1]) : false;
}

var page_loaded = false;
// animations
var elementsToAnimate = [];
//
jQuery(window).load(function() {
	//
	page_loaded = true;

	if(jQuery(document.body).attr('data-smoothscroll') == '1') {
		// smooth anchor scrolling
		    if(
        !(
            jQuery('#gkMainbody').find('.subpage').length && 
            jQuery('#gkMainbody').find('.subpage').hasClass('edit')
        ) && !(
            jQuery('#modules-form').length
        )
    ) {
        jQuery('a[href*="#"]').on('click', function (e) {
            e.preventDefault();
            if(
                this.hash !== '' && 
                this.hash.indexOf('carousel') === -1 &&
                this.hash.indexOf('advancedSearch') === -1
            ) {
                var target = jQuery(this.hash);

                if(this.hash !== '' && this.href.replace(this.hash, '') == window.location.href.replace(window.location.hash, '')) {    
                    if(target.length && this.hash !== '#') {
                        jQuery('html, body').stop().animate({
                            'scrollTop': target.offset().top
                        }, 1000, 'swing', function () {
                            if(this.hash !== '#') {
                                window.location.hash = target.selector;
                            }
                        });
                    } else if(this.hash !== '' && this.href.replace(this.hash, '') !== '') {
                        window.location.href = this.href;
                    }
                } else if(this.hash !== '' && this.href.replace(this.hash, '') !== '') {
                    window.location.href = this.href;
                }
            }
        });
    }
	}
	// style area
	if(jQuery('#gkStyleArea').length > 0){
		jQuery('#gkStyleArea').find('a').each(function(i,element){
			
			jQuery(element).click(function(e){
	            e.preventDefault();
	            e.stopPropagation();
	            console.log('clicked');
				changeStyle(i+1);
			});
		});
	}
	// font-size switcher
	if(jQuery('#gkTools').length > 0 && jQuery('#gkMainbody').length > 0) {
		var current_fs = 100;
		
		jQuery('#gkMainbody').css('font-size', current_fs+"%");
		
		jQuery('#gkToolsInc').click(function(e){ 
			e.stopPropagation();
			e.preventDefault(); 
			if(current_fs < 150) {  
				jQuery('#gkMainbody').animate({ 'font-size': (current_fs + 10) + "%"}, 200); 
				current_fs += 10; 
			} 
		});
		jQuery('#gkToolsReset').click(function(e){ 
			e.stopPropagation();
			e.preventDefault(); 
			jQuery('#gkMainbody').animate({ 'font-size' : "100%"}, 200); 
			current_fs = 100; 
		});
		jQuery('#gkToolsDec').click(function(e){ 
			e.stopPropagation();
			e.preventDefault(); 
			if(current_fs > 70) { 
				jQuery('#gkMainbody').animate({ 'font-size': (current_fs - 10) + "%"}, 200); 
				current_fs -= 10; 
			} 
		});
	}
	// system message container fix
	if(jQuery('#system-message-container').length > 0){
		  jQuery('#system-message-container').each(function(i, element){
		  		(function() {
		  		     jQuery(element).fadeOut('slow');
		  		}).delay(5000);
	      });
	}
	// K2 font-size switcher fix
	if(jQuery('#fontIncrease').length > 0 && jQuery('.itemIntroText').length > 0) {
		jQuery('#fontIncrease').click(function() {
			jQuery('.itemIntroText').attr('class', 'itemIntroText largerFontSize');
		});
		
		jQuery('#fontDecrease').click( function() {
			jQuery('.itemIntroText').attr('class', 'itemIntroText smallerFontSize');
		});
	}
	// login popup
	if(jQuery('#gkPopupLogin').length > 0) {
		var popup_overlay = jQuery('#gkPopupOverlay');
		popup_overlay.css({'display': 'none', 'opacity' : 0});
		popup_overlay.fadeOut();
		
		jQuery('#gkPopupLogin').css({'display': 'block', 'opacity': 0, 'height' : 0});
		var opened_popup = null;
		var popup_login = null;
		var popup_login_h = null;
		var popup_login_fx = null;
		
		if(jQuery('#gkPopupLogin')) {

			popup_login = jQuery('#gkPopupLogin');
	        popup_login.css('display', 'block');
	        popup_login_h = popup_login.find('.gkPopupWrap').outerHeight();

	        jQuery('#gkLogin').click( function(e) {
	            e.preventDefault();
	            e.stopPropagation();
	            popup_overlay.css({'opacity' : 0.45});
	            popup_overlay.fadeIn('medium');
	            popup_login.css('display', 'block');
	            setTimeout(function() {
	                popup_login.animate({'opacity':1, 'height': popup_login_h},200, 'swing');
	                opened_popup = 'login';
	                popup_login.addClass('gk3Danim');
	            }, 450);

	            (function() {
	                if(jQuery('#modlgn-username').length > 0) {
	                    jQuery('#modlgn-username').focus();
	                }
	            }).delay(600);
	        });
		}
		
		popup_overlay.click( function() {
			if(opened_popup == 'login') {
                popup_overlay.fadeOut('medium');
                popup_login.removeClass('gk3Danim');
                setTimeout(function() {
                    popup_login.animate({
                        'opacity' : 0
                    },350, 'swing', function() {
                        popup_login.css('display', 'none');
                    });
                }, 100);

            }
		});
	}
	// section-nav
	if(jQuery('body').hasClass('section-nav')) {
		var sections = [];
		// put the main sections if exists
		jQuery(['gkHeaderMod', 'gkMainbody', 'gkBottom1', 'gkBottom2', 'gkBottom3', 'gkBottom4']).each(function(i, item) {
			if(jQuery('#'+item).length > 0) {
				sections.push(jQuery('#'+item));
				
				var number = i+1;
				var link = new jQuery('<a href="#" class="gkSectionNav" data-num="'+number+'"></a>');
				jQuery('#'+item).append(link);
			}
		});
		// put the last section
		sections.push(jQuery('#gkBottomSection'));
		// add events to the links
		jQuery('.gkSectionNav').each(function(i, link) {
			link = jQuery(link);
			link.click(function(e) {
				e.preventDefault();
				e.stopPropagation();
				
				jQuery('html, body').animate({
					scrollTop: sections[jQuery(link).attr('data-num')].offset().top - 80
				},500);
				
								
			});
		});
	}
	// grid animation
	jQuery('.gkGridGK5').each(function(i, grid) {
		jQuery(grid).addClass('active');
	});
});
//
jQuery(window).scroll(function() {
	// menu animation
	if(page_loaded && jQuery('body').hasClass('imageBg') && jQuery('#aside-menu').length == 0) {
		// if menu is not displayed now
		if(jQuery(window).scrollTop() > jQuery('#gkHeader').height() && !jQuery('#gkMenuWrap').hasClass('active')) {
			jQuery('#gkHeaderNav').appendTo(jQuery('#gkMenuWrap'));
			jQuery('#gkHeader').attr('class', 'gkNoMenu');
			jQuery('#gkHeader').find('div').eq(0).css('display', 'none');
			jQuery('#gkMenuWrap').attr('class', 'active');
		}
		//
		if(jQuery(window).scrollTop() == 0 && jQuery('#gkMenuWrap').hasClass('active')) {
			jQuery('#gkHeader').find('div').eq(0).css('display', 'block');
			jQuery('#gkHeader').find('div').eq(0).append(jQuery('#gkHeaderNav'));
			jQuery('#gkHeaderNav').prependTo(jQuery('#gkHeader > div').eq(0));
			jQuery('#gkHeader').attr('class', '');
			jQuery('#gkMenuWrap').attr('class', '');
		}
	}
});
//
function gkAddClass(element, cssclass, i) {
	var delay = jQuery(element).data('delay');

	if(!delay) {
		delay = (i !== false) ? i * 100 : 0;
	}

	setTimeout(function() {
		jQuery(element).addClass(cssclass);
	}, delay);
}
//
jQuery(document).ready(function() {

	if(!jQuery('#aside-menu').length > 0) {
		//
		var menuwrap = new jQuery('<div id="gkMenuWrap"></div>');
		//
		menuwrap.appendTo(jQuery('body'));
		
		//
		if(!jQuery('body').hasClass('imageBg')) {
			jQuery('#gkHeaderNav').appendTo(jQuery('#gkMenuWrap'));
			jQuery('#gkHeader').attr('class', 'gkNoMenu');
			jQuery('#gkHeader').find('div').eq(0).css('display', 'none');
			jQuery('#gkMenuWrap').attr('class', 'active');	
		}
	}
});

// Function to change styles
function changeStyle(style){
	var file1 = $GK_TMPL_URL+'/css/style'+style+'.css';
	var file2 = $GK_TMPL_URL+'/css/typography/typography.style'+style+'.css';
	jQuery('head').append('<link rel="stylesheet" href="'+file1+'" type="text/css" />');
	jQuery('head').append('<link rel="stylesheet" href="'+file2+'" type="text/css" />');
	
	for(var i = 1; i <= 6; i++) {
		jQuery(document.body).removeClass('style' + i);
	}
		
	jQuery(document.body).addClass('style' + style);
	
	jQuery.cookie('gk_musicstate_j30_style', style, { expires: 365, path: '/' });
}
