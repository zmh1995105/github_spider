var zf = zf || {};

/* FUNCTIONS
--------------------------------------------------------------------------------------------------------------------------------------*/

/*********** PLACEHOLDER SUPPORT **********/

zf.placeholderSupport = function(){
	var i = document.createElement('input');
	return 'placeholder' in i;
};

/*********** EQUAL HEIGHT ELEMENTS **********/

zf.equalHeight = function(group){
	var tallest = 0;
	group.each(function() {
		var thisHeight = $(this).height();
		if(thisHeight > tallest) {
			tallest = thisHeight;
		}
	});
	group.height(tallest);
};

/*********** STICKY NAV **********/

zf.updateStickyNav = function($el){
	zf.$stickyNav.find('a[href="#'+$el.attr('id')+'"]').parent().addClass('current').siblings().removeClass('current');
};

/* INIT
--------------------------------------------------------------------------------------------------------------------------------------*/

zf.init = function(){
	$('body').addClass('js');
	zf.headerH = $('#nav').outerHeight();

	// Placeholder fallback
	if(!zf.placeholderSupport()){
		$('input[placeholder]').each(function(i, el){
			el.defaultValue = $(el).attr('placeholder');
			$(el).attr('value', el.defaultValue);
		}).focus(function(){
			if($(this).attr('value') == this.defaultValue) $(this).attr('value', '');
		}).blur(function(){
			if($.trim(this.value) == '') this.value = (this.defaultValue ? this.defaultValue : '');
		});
	}

	// Blank links (why not use target="_blank" in the html?!)
	$('a[rel=external]').click(function(){
		window.open($(this).attr('href'));
		return false;
	});

	// Waypoints
	zf.calculateWP();
	zf.$stickyNav = $('#nav');
	$('.waypoint').waypoint({
		offset: function(){
			return zf.wpOffset;
		},
		handler : function(direction){
			if(direction === 'down'){
				zf.updateStickyNav($(this));
			}else{
				if($(this).prev() !== 'undefined')
				zf.updateStickyNav($(this).prev());
			}
		}
	});

	$('#program').waypoint({
		offset: zf.headerH,
		handler : function(direction){
			if(direction === 'down'){
				zf.$stickyNav.find('#logo').fadeIn(300);
			}else{
				zf.$stickyNav.find('#logo').fadeOut(300);
			}
		}
	});

	// Smooth scroll
	$('.scroll-link, .scroll-links a, #menu a').click(function(){
		if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'')
        && location.hostname == this.hostname) {
            var $target = $(this.hash);
            $target = $target.length && $target || $('[name=' + this.hash.slice(1) +']');
            if ($target.length) {
                var targetOffset = $target.offset().top;
                $('html,body').animate({scrollTop: targetOffset -zf.headerH}, 500);
                return false;
            }
        }
    });

    // Backstretch
    $('[data-backstretch]').each(function(){
		$(this).backstretch($(this).data('backstretch'));
	});

	$('#program .bubule.tooltipHL, #program .bubule.tooltipHR').each(function() {
		var c = $(this).attr('class').split(' ')
		for (a in c) {
			if (c[a].substr(0,1) == 'r') {
				var time = $(this).parent().parent().find('td.first').html().split('h')
				var min = parseInt(time[1]) + parseInt(c[a].substr(1))
				var tooltip;
				if ($(this).hasClass('tooltipHL'))
					tooltip = '<div class="tooltip left" style="margin-top: -21px; margin-left: -76px"><div class="tooltip-inner">' + time[0] + 'h' + ((min < 10) ? '0' + min : min) + '</div><div class="tooltip-arrow"></div></div>'
				else
					tooltip = '<div class="tooltip right" style="margin-top: -21px; margin-left: 207px"><div class="tooltip-inner">' + time[0] + 'h' + ((min < 10) ? '0' + min : min) + '</div><div class="tooltip-arrow"></div></div>'
				$(this).prepend(tooltip)
			}
		}
	})
};

zf.calculateWP = function(){
	zf.wpOffset = Math.round($(window).height()/2);
}

/* DOM READY
--------------------------------------------------------------------------------------------------------------------------------------*/

$(document).ready(zf.init);
$(window).resize(zf.calculateWP);