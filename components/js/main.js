var $j = jQuery.noConflict();

$j(function() {
	var $_b = $j('html, body');
	var $_w = $j(window);
	var tableBreakpoint = 768;
	var templateTwo = $j('.template-two');
	var header = $j('.mod-header');
	var isMoving;
	var $dropMenu = $j('.drop-menu');

	header.on('click', 'a', function(e) {

		var currentTarget = $j(e.currentTarget);
		var $mod = $j(e.delegateTarget);
		var offset = $mod.outerHeight();

		if (currentTarget.is('.jump-link')) {
			e.preventDefault();			
			var top = $j(currentTarget.attr('href')).position().top;	

			$_b.animate({
				scrollTop: top - (offset + 20)
			}, '500', 'swing');

			if (currentTarget.parents('.second-nav').length) {
				currentTarget.parent().siblings().removeClass('active');
				currentTarget.parent().addClass('active');
			}
			return;				
		}

		// to trigger dropdown
		if(currentTarget.is('.dropdown')) {
			e.preventDefault();	
			toggleHeader.call($mod);

			return;
		}	
	});

	function toggleHeader() {
		$dropMenu.slideToggle(400);
		this.toggleClass("open");			
	}

	$j('form input').each(function() {
		$j(this).on('focusout', function(e) {
			var valid = false;
			
			if(e.currentTarget.value != '') {
				valid = true;
			}

			$j(e.currentTarget).toggleClass('valid', valid);
		})
	});

	var items = $j('.sub-menu li');
	var contentSections = $j('#top .content__section[id]');

	if (items.length) {
		$j('.site-header').addClass('site-header--extended');
	}

	$dropMenu.find('a').each(function() {
		var text = $j(this).text()
		
		if (text.length > 11) {
			
			$j(this).addClass('trunc');
			var newStr = text.substring(0, 10);
			newStr += "<span>";
			newStr += text.substring(10, text.length);
			newStr += "</span>";

			$j(this).html(newStr);
		}
	});

	$_w.on('scroll', function() {

		var top = $j(this).scrollTop();
		var padTop = parseInt($j('#top').css('padding-top'));

		if (top >= 1) {
			isMoving = true;
			if(header.is('.open')){
				toggleHeader.call(header);				
			}
		} else {
			isMoving = false;
		}

		header.toggleClass('sticky-header', isMoving);


		contentSections.each(function(e, i) {
			if (top >= ($j(i).position().top - padTop)) {
				items.removeClass('active');
				items.eq($j(i).index()).addClass('active');
			}
		})
	});
});