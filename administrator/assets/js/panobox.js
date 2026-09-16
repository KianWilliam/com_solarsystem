/**
 * @copyright	Copyright (C) 2015 Cedric KEIFLIN alias ced1870
 * http://www.joomlakwp.fr
 * @license		GNU/GPL
 * @version		1.0.0 
 * */

KWPBox = window.KWPBox || {};

(function($) {
KWPBox.open = function(options) {
	
	var defaults = {
		id: '',
		handler: 'iframe',					// load external page or inline code : 'iframe' or 'inline'
		fullscreen: true,					// 
		size: {x: null, y: null},			// size of the box : {x: 800px, y: 500px}
		style: {padding: '0'},			// size of the box : {x: 800px, y: 500px}
		url: '',							// url or the external content
		content: '',						// html ID (without #) of the inline content
		closeText: '×',						// set the text for the close button
		headerHtml: '',						// add any code to the header
		footerHtml: '',						// ad any code to the footer
		onKWPBoxLoaded: function() { }		//this callbakwp is invoked when the transition effect ends
	}
	var options = $.extend(defaults, options);
	var modalclosebutton = options.closeText ? '<a class="kwpboxmodal-button" href="javascript:void(0);" onclick="KWPBox.close(this)">'+options.closeText+'</a>' : '';
	var i = $('.kwpboxmodal').length+1;
	// kwpboxmodal = $('#kwpboxmodal'+i);
	var boxid = options.id ? options.id : 'kwpboxmodal'+i;
	if ($('#'+boxid).length) $('#'+boxid).remove();
	if (options.handler == 'inline' && options.content && $('.kwpboxmodal #' + options.content).length) {
		$('.kwpboxmodal').each(function(j, box) {
			if ($(box).find('#' + options.content).length) {
				kwpboxmodal = $(box);
				// $(box).show();
			}
		});
	} else {
	//	if (! $('#kwpboxmodal').length) {
		var styles = '';
		if (options.size.x) styles += 'width:'+options.size.x+';';
		if (options.size.y) styles += 'height:'+(parseInt(options.size.y)+50)+'px;';
		if (options.size.x || options.size.y) options.fullscreen = false;
		if (! options.fullscreen) {
			styles += 'margin-left:-'+(parseInt(options.size.x)/2)+'px;';
			styles += 'margin-top:-'+((parseInt(options.size.y)+50)/2)+'px;';
			styles += 'left:50%;';
			styles += 'top:' + ($(window).scrollTop() + $(window).height()/2) + 'px';
		}

		if (styles) styles = 'style="' + styles + '"';
		var modalhtml = $(
			'<div id="'+boxid+'" data-index="'+i+'" class="kwpboxmodal '+(options.fullscreen?'fullscreen':'')+'" '+styles+' data-sizex="' + options.size.x + '" data-sizey="' + options.size.y + '">'
				+'<div class="kwpboxmodal-header"></div>'
				+'<div class="kwpboxmodal-body" style="padding:'+options.style.padding+';"></div>'
				+'<div class="kwpboxmodal-footer">'+modalclosebutton+'</div>'
			+'</div>');
		$(document.body).append(modalhtml);
		if (! $('.kwpboxmodal-back').length) $(document.body).append('<div class="kwpboxmodal-back" onclick="KWPBox.close()"/>');
//	}
		kwpboxmodal = $('#'+boxid);
		var kwpboxmodalbody = kwpboxmodal.find('.kwpboxmodal-body');
		kwpboxmodalbody.empty();
		kwpboxmodal.find('.kwpboxmodal-header').empty().append(options.headerHtml);
		kwpboxmodal.find('.kwpboxmodal-footer').empty().append(modalclosebutton).append(options.footerHtml);
		if (options.handler == 'inline') {
				if (options.content) {
					$('#kwpboxmodalwrapper'+i).remove();
					$('#' + options.content).after('<div id="kwpboxmodalwrapper'+i+'" />')
					kwpboxmodalbody.append($('#' + options.content).show());
				}
		} else {
			kwpboxmodalbody.append('<iframe class="kwpwait" src="'+options.url+'" width="100%" height="auto" />');
		}
	}
	// if (!options.fullscreen) kwpboxmodal.css('top', $(window).scrollTop()+10);
	KWPBox.resize();
	kwpboxmodal.show();
	$('.kwpboxmodal-back').show();
	options.onKWPBoxLoaded.call(this);
}

KWPBox.close = function(button, aftersaveiframe) {
	if(! aftersaveiframe) aftersaveiframe = false;
	if (button) {
		kwpboxmodal = $($(button).parents('.kwpboxmodal')[0]);
	} else {
		kwpboxmodal = $('.kwpboxmodal');
	}
	var i = kwpboxmodal.attr('data-index');
	kwpboxmodal.hide();
	$('.kwpboxmodal-back').hide();
	if ($('#kwpboxmodalwrapper'+i).length && !aftersaveiframe) {
		$('#kwpboxmodalwrapper'+i).before(kwpboxmodal.find('.kwpboxmodal-body').children().first().hide());
	}
	if (aftersaveiframe) {
		kwpboxmodal.find('iframe').load(function() {
			kwpboxmodal.remove();
		});
	} else {
		kwpboxmodal.remove();
	}
}

KWPBox.resize = function() {
	var kwpboxmodals = $('.kwpboxmodal');
	kwpboxmodals.each(function(i, kwpboxmodal) {
		kwpboxmodal = $(kwpboxmodal);
		if (!kwpboxmodal.length) return;

		var kwpboxmodalbody = kwpboxmodal.find('.kwpboxmodal-body');
		var h = kwpboxmodal.innerHeight() - kwpboxmodal.find('.kwpboxmodal-header').outerHeight() - kwpboxmodal.find('.kwpboxmodal-footer').outerHeight();
		kwpboxmodalbody.css('height', h);
		// switch to fullscreen if bigger than screen
		if ($(window).width() - kwpboxmodal.width() < 10) {
			if (!kwpboxmodal.hasClass('fullscreen')) {
				kwpboxmodal.addClass('fullscreen')
					.addClass('autofullscreen')
					.css('left', '')
					.css('top', '')
					.css('margin-left', '')
					.css('margin-top', '')
					.css('width', '')
					.css('height', '')
					.data('normalWidth', kwpboxmodal.width());
			} else if (kwpboxmodal.hasClass('autofullscreen')) {
				
	//			styles += 'margin-left:-'+(parseInt(options.size.x)/2)+'px;';
	//			styles += 'margin-top:-'+((parseInt(options.size.y)+50)/2)+'px;';
	//			styles += 'left:50%;';
	//			styles += 'top:' + ($(window).scrollTop() + $(window).height()/2) + 'px';
			}
		}
		if ($(window).width() > (parseInt(kwpboxmodal.attr('data-sizex')) + 10) && kwpboxmodal.hasClass('autofullscreen')) {
			console.log($(window).width());
			console.log(kwpboxmodal.attr('data-sizex'));
			var sizex = kwpboxmodal.attr('data-sizex');
			var sizey = kwpboxmodal.attr('data-sizey');
			kwpboxmodal.removeClass('fullscreen')
				.removeClass('autofullscreen')
				.css('left', '50%')
				.css('top', ($(window).scrollTop() + $(window).height()/2) + 'px')
				.css('margin-left', '-'+(parseInt(sizex)/2)+'px')
				.css('margin-top', '-'+((parseInt(sizey)+50)/2)+'px')
				.css('width', sizex)
				.css('height', sizey);
		}
	});
}

/* BC for SqueezeBox functions */
KWPBox.initialize = function() {
	// not used
}

KWPBox.assign = function (to, options) {
	var $options = options;
	$(to).click(function(e) {
		e.preventDefault();
		KWPBox.launch(this, $options);
	});
}

KWPBox.fromElement = function(from, options) {
	KWPBox.launch(from, options);
}

KWPBox.launch = function(from, options) {

	options.url = (($(from).length) ? ($(from).attr('href')) : from) || options.url || '';
	options.style = {padding: '10px'};

	if (options.parse !== false) options = KWPBox.parseOtions(from, options);

	KWPBox.open(options);
}

KWPBox.parseOtions = function(from, opts) {
	var toParse = $(from).attr(opts.parse);

	newOptions = (new Function('return ' + toParse))(); // used to convert the string to object
	opts = $.extend(opts, newOptions);
	return opts;
}

})(jQuery);

/* Bind the modal resizing on page resize */
jQuery(window).bind('resize',function(){
	KWPBox.resize();
});