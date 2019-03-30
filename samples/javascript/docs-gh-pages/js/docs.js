function spyScroller() {
	var id = null;
	$('#content-docs section').each(function() {
		if ($(this).offset().top < parseInt($('body').scrollTop() + 50))
			id = $(this).attr('id');
	});
	$('#menu-docs li').removeClass('active');
	if (id) {
		$('#menu-docs li a').each(function() {
			if ($(this).attr('href').split('/')[1] == id)
				$(this).parent().addClass('active');
		});
	}
}

var menu;

var DocsRouter = Backbone.Router.extend({
	routes: {
		":page": "docsPage",
		":page/:anchor": "docsPage",
		"*url": "init"
	},
	docsPage: function(page, anchor) {
		$.getJSON('./js/menu.json', function(menu) {
			$('#main-menu li:not(.wsh-link)').remove();
			for (key in menu) {
				$('#main-menu').append('<li><a href="#' + key + '">' + menu[key].title + '</a></li>')
			}

			$('#main-menu a[href="#' + page + '"]').parent().addClass('active');

			$('#menu-docs li').remove();
			for (key in menu[page].submenu) {
				$('#menu-docs').append('<li><a style="padding: 10px 20px" href="#' + page + '/' + key + '"><i class="icon-chevron-right" style="float: right"></i>' + menu[page].submenu[key] + '</a></li>')
			}

			$.get('./pages/' + page + '.html', {}, function(data) {
				$('#content-docs').html(data);
	            $('body').animate({
	                scrollTop: 0
	            },0);
				prettyPrint();
				$(window).scroll(spyScroller);
				$('#menu-docs li a').click(function() {
					var id = $(this).attr('href').split('/')[1];
					if ($('#' + id).length > 0) {
						$('body').animate({
							scrollTop: $('#' + id).offset().top
						}, 0, function() {
							spyScroller();
						})
					}
					$('#menu-docs li.active').removeClass('active');
					$(this).parent().addClass('active');
					return false;
				})

			})
		});
	},
	init: function() {
		this.docsPage("overview");
	}
});


$(document).ready(function() {
    var route = new DocsRouter();
    $('#docs-header').affix();
    $('#menu-docs').affix();
	
	Backbone.history.start({pushState: false});
})