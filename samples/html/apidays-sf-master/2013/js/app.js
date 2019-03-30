/* Author: El mansouri */
jQuery(document).ready(function($) {
	var windowW 			= $(window).width();
	var windowH 			= $(window).height();
	var documentBody 	= (($.browser.chrome)||($.browser.safari)) ? document.body : document.documentElement;
	
	
	
	var docPosTop = $('.navigation').offset().top;

	var navigationHeight = $('.navigation').height();
	var navigation = $('.navigation');
	
	
	var updateSidebarMenu = function() {
		var curScrollPos = $(window).scrollTop();
		if (curScrollPos > docPosTop) {
			var max = (curScrollPos+navigationHeight);
			var docPosBottom = $('footer').offset().top;
			if (max < docPosBottom) {
				if (navigation.data('area') != 'middle') {
					navigation.fadeIn(100);
					navigation.data('area', 'middle');
				}
			} else {

				if (navigation.data('area') != 'below') {
					navigation.fadeOut(100);
					navigation.data('area', 'below');
				}
			}
		}
	};

	$(window).bind('scroll', function(data) {
		updateSidebarMenu();
	});
	
	// scroll nav
	$('#nav').onePageNav({
    changeHash: false,
    scrollSpeed: 700,
    filter: ':not(.external)',
		scrollOffset: 0,
		begin: function(){
			$('.navigation');
		},
		end: function(){
			$('.navigation');
		}
		
  });
  
});// fin domm ready