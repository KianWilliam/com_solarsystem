/**
 * @copyright	Copyright (C) 2012 Cedric KEIFLIN alias ced1870
 * https://www.joomlack.fr
 * Module Carousel KWP
 * @license		GNU/GPL
 * */

function kwpSelectFile(file, field) {
	if (! field) {
		alert('ERROR : no field given in the function kwpSelectFile');
		return;
	}
	$kwp('#'+field).val(file).trigger('change');
	kwpUpdateThumbnail(file, '#'+field);
}

// pour gestion editeur d'images, mais c'est fini pour toujour, haha
function kwpInsertMedia(text, editor) {
	var valeur = jQuery(text).attr('src');
	jQuery('#'+editor).val(valeur);
	kwpUpdateThumbnail(valeur, '#'+editor);
}

function kwpUpdateThumbnail(imgsrc, editor) {
	var slideimg = jQuery(editor).parent().parent().find('img');
	var testurl = 'http';
	if (imgsrc.toLowerCase().indexOf(testurl.toLowerCase()) != -1) {
		slideimg.attr('src', imgsrc);
	} else {
		//slideimg.attr('src', KWP.URIROOTABS + imgsrc);
	//	console.log("haha"+SITEROOT+imgsrc);
		slideimg.attr('src', URIROOT + imgsrc);

	}
}

function kwpAddSlide(slide) {
	if (! slide) slide = [];
	var imgname = slide['imgname'] || '';
	var imgcaption = slide['imgcaption'] || '';
	var imgthumb = slide['imgthumb'] || '';
	if (!imgthumb) {
		//imgthumb = KWPuri + 'components/com_kwpsolarsystem/assets/images/unknown.png';
				imgthumb = SITEROOT + 'components/com_kwpsolarsystem/assets/images/unknown.png';

	} else {
	//	imgthumb = KWPuri + imgname;
	//console.log(URIROOT);
				imgthumb = URIROOT + imgname;

	}
	var imglink = slide['imglink'] || '';
	var imgtarget = slide['imgtarget'] || '';
	var imgvideo = slide['imgvideo'] || '';
	var slideselect = slide['slideselect'] || '';
	//var imgalignment = slide['imgalignment'] || '';
	//var articleid = slide['slidearticleid'] || '';
	//var pagebuilderckid = slide['slidepagebuilderckid'] || '';
	//var imgtime = slide['imgtime'] || '';
	//var articlename = slide['slidearticlename'] || '';
	//var pagebuilderckname = slide['slidepagebuilderckname'] || '';
	var imgtitle = slide['imgtitle'] || '';
	var state = slide['state'] || '';
	//var startdate = slide['startdate'] || '';
	//var enddate = slide['enddate'] || '';
	//var texttype = slide['texttype'] || 'custom';

	imgcaption = imgcaption.replace(/\|dq\|/g, "&quot;");
	if (!imglink)
		imglink = '';
	if (!imgvideo)
		imgvideo = '';
	if (!imgtarget || imgtarget == 'default') {
		imgtarget = '';
		imgtargetoption = '<option value="default" selected="selected">' + Joomla.JText._('KWPDEFAULT_DEFAULT', 'default') + '</option><option value="_parent">' + Joomla.JText._('KWP_SAMEWINDOW', 'same window') + '</option><option value="_blank">' + Joomla.JText._('KWP_NEWWINDOW', 'new window') + '</option><option value="lightbox">' + Joomla.JText._('KWP_LIGHTBOX', 'in a Lightbox') + '</option>';
	} else {
		if (imgtarget == '_parent') {
			imgtargetoption = '<option value="default">' + Joomla.JText._('KWP_DEFAULT', 'default') + '</option><option value="_parent" selected="selected">' + Joomla.JText._('KWP_SAMEWINDOW', 'same window') + '</option><option value="_blank">' + Joomla.JText._('KWP_NEWWINDOW', 'new window') + '</option><option value="lightbox">' + Joomla.JText._('KWP_LIGHTBOX', 'in a Lightbox') + '</option>';
		} else if (imgtarget == 'lightbox') {
			imgtargetoption = '<option value="default">' + Joomla.JText._('KWP_DEFAULT', 'default') + '</option><option value="_parent">' + Joomla.JText._('KWP_SAMEWINDOW', 'same window') + '</option><option value="_blank">' + Joomla.JText._('KWP_NEWWINDOW', 'new window') + '</option><option value="lightbox" selected="selected">' + Joomla.JText._('KWP_LIGHTBOX', 'in a Lightbox') + '</option>';
		} else {
			imgtargetoption = '<option value="default">' + Joomla.JText._('KWP_DEFAULT', 'default') + '</option><option value="_parent">' + Joomla.JText._('KWP_SAMEWINDOW', 'same window') + '</option><option value="_blank" selected="selected">' + Joomla.JText._('KWP_NEWWINDOW', 'new window') + '</option><option value="lightbox">' + Joomla.JText._('KWP_LIGHTBOX', 'in a Lightbox') + '</option>';
		}
	}
	if (!slideselect) {
		slideselect = '';
		slideselectoption = '<option value="image" selected="selected">' + Joomla.JText._('KWP_IMAGE', 'Image') + '</option><option value="video">' + Joomla.JText._('KWP_VIDEO', 'Video') + '</option>';
	} else {
		if (slideselect == 'image') {
			slideselectoption = '<option value="image" selected="selected">' + Joomla.JText._('KWP_IMAGE', 'Image') + '</option><option value="video">' + Joomla.JText._('KWP_VIDEO', 'Video') + '</option>';
		} else {
			slideselectoption = '<option value="image">' + Joomla.JText._('KWP_IMAGE', 'Image') + '</option><option value="video" selected="selected">' + Joomla.JText._('KWP_VIDEO', 'Video') + '</option>';
		}
	}

	/*if (!imgalignment) {
		imgalignment = '';
		imgdataalignmentoption = '<option value="default" selected="selected">Default</option>'
				+ '<option value="topLeft">' + Joomla.JText._('KWP_TOPLEFT', 'top left') + '</option>'
				+ '<option value="topCenter">' + Joomla.JText._('KWP_TOPCENTER', 'top center') + '</option>'
				+ '<option value="topRight">' + Joomla.JText._('KWP_TOPRIGHT', 'top right') + '</option>'
				+ '<option value="centerLeft">' + Joomla.JText._('KWP_MIDDLELEFT', 'center left') + '</option>'
				+ '<option value="center">' + Joomla.JText._('KWP_CENTER', 'center') + '</option>'
				+ '<option value="centerRight">' + Joomla.JText._('KWP_MIDDLERIGHT', 'center right') + '</option>'
				+ '<option value="bottomLeft">' + Joomla.JText._('KWP_BOTTOMLEFT', 'bottom left') + '</option>'
				+ '<option value="bottomCenter">' + Joomla.JText._('KWP_BOTTOMCENTER', 'bottom center') + '</option>'
				+ '<option value="bottomRight">' + Joomla.JText._('KWP_BOTTOMRIGHT', 'bottom right') + '</option>';
	} else {
		if (imgalignment == 'topLeft') {
			imgdataalignmentoption = '<option value="default">Default</option>'
					+ '<option value="topLeft" selected="selected">' + Joomla.JText._('KWP_TOPLEFT', 'top left') + '</option>'
					+ '<option value="topCenter">' + Joomla.JText._('KWP_TOPCENTER', 'top center') + '</option>'
					+ '<option value="topRight">' + Joomla.JText._('KWP_TOPRIGHT', 'top right') + '</option>'
					+ '<option value="centerLeft">' + Joomla.JText._('KWP_MIDDLELEFT', 'center left') + '</option>'
					+ '<option value="center">' + Joomla.JText._('KWP_CENTER', 'center') + '</option>'
					+ '<option value="centerRight">' + Joomla.JText._('KWP_MIDDLERIGHT', 'center right') + '</option>'
					+ '<option value="bottomLeft">' + Joomla.JText._('KWP_BOTTOMLEFT', 'bottom left') + '</option>'
					+ '<option value="bottomCenter">' + Joomla.JText._('KWP_BOTTOMCENTER', 'bottom center') + '</option>'
					+ '<option value="bottomRight">' + Joomla.JText._('KWP_BOTTOMRIGHT', 'bottom right') + '</option>';
		} else if (imgalignment == 'topCenter') {
			imgdataalignmentoption = '<option value="default">Default</option>'
					+ '<option value="topLeft">' + Joomla.JText._('KWP_TOPLEFT', 'top left') + '</option>'
					+ '<option value="topCenter" selected="selected">' + Joomla.JText._('KWP_TOPCENTER', 'top center') + '</option>'
					+ '<option value="topRight">' + Joomla.JText._('KWP_TOPRIGHT', 'top right') + '</option>'
					+ '<option value="centerLeft">' + Joomla.JText._('KWP_MIDDLELEFT', 'center left') + '</option>'
					+ '<option value="center">' + Joomla.JText._('KWP_CENTER', 'center') + '</option>'
					+ '<option value="centerRight">' + Joomla.JText._('KWP_MIDDLERIGHT', 'center right') + '</option>'
					+ '<option value="bottomLeft">' + Joomla.JText._('KWP_BOTTOMLEFT', 'bottom left') + '</option>'
					+ '<option value="bottomCenter">' + Joomla.JText._('KWP_BOTTOMCENTER', 'bottom center') + '</option>'
					+ '<option value="bottomRight">' + Joomla.JText._('KWP_BOTTOMRIGHT', 'bottom right') + '</option>';
		} else if (imgalignment == 'topRight') {
			imgdataalignmentoption = '<option value="default">Default</option>'
					+ '<option value="topLeft">' + Joomla.JText._('KWP_TOPLEFT', 'top left') + '</option>'
					+ '<option value="topCenter">' + Joomla.JText._('KWP_TOPCENTER', 'top center') + '</option>'
					+ '<option value="topRight" selected="selected">' + Joomla.JText._('KWP_TOPRIGHT', 'top right') + '</option>'
					+ '<option value="centerLeft">' + Joomla.JText._('KWP_MIDDLELEFT', 'center left') + '</option>'
					+ '<option value="center">' + Joomla.JText._('KWP_CENTER', 'center') + '</option>'
					+ '<option value="centerRight">' + Joomla.JText._('KWP_MIDDLERIGHT', 'center right') + '</option>'
					+ '<option value="bottomLeft">' + Joomla.JText._('KWP_BOTTOMLEFT', 'bottom left') + '</option>'
					+ '<option value="bottomCenter">' + Joomla.JText._('KWP_BOTTOMCENTER', 'bottom center') + '</option>'
					+ '<option value="bottomRight">' + Joomla.JText._('KWP_BOTTOMRIGHT', 'bottom right') + '</option>';
		} else if (imgalignment == 'centerLeft') {
			imgdataalignmentoption = '<option value="default">Default</option>'
					+ '<option value="topLeft">' + Joomla.JText._('KWP_TOPLEFT', 'top left') + '</option>'
					+ '<option value="topCenter">' + Joomla.JText._('KWP_TOPCENTER', 'top center') + '</option>'
					+ '<option value="topRight">' + Joomla.JText._('KWP_TOPRIGHT', 'top right') + '</option>'
					+ '<option value="centerLeft" selected="selected">' + Joomla.JText._('KWP_MIDDLELEFT', 'center left') + '</option>'
					+ '<option value="center">' + Joomla.JText._('KWP_CENTER', 'center') + '</option>'
					+ '<option value="centerRight">' + Joomla.JText._('KWP_MIDDLERIGHT', 'center right') + '</option>'
					+ '<option value="bottomLeft">' + Joomla.JText._('KWP_BOTTOMLEFT', 'bottom left') + '</option>'
					+ '<option value="bottomCenter">' + Joomla.JText._('KWP_BOTTOMCENTER', 'bottom center') + '</option>'
					+ '<option value="bottomRight">' + Joomla.JText._('KWP_BOTTOMRIGHT', 'bottom right') + '</option>';
		} else if (imgalignment == 'center') {
			imgdataalignmentoption = '<option value="default">Default</option>'
					+ '<option value="topLeft">' + Joomla.JText._('KWP_TOPLEFT', 'top left') + '</option>'
					+ '<option value="topCenter">' + Joomla.JText._('KWP_TOPCENTER', 'top center') + '</option>'
					+ '<option value="topRight">' + Joomla.JText._('KWP_TOPRIGHT', 'top right') + '</option>'
					+ '<option value="centerLeft">' + Joomla.JText._('KWP_MIDDLELEFT', 'center left') + '</option>'
					+ '<option value="center" selected="selected">' + Joomla.JText._('KWP_CENTER', 'center') + '</option>'
					+ '<option value="centerRight">' + Joomla.JText._('KWP_MIDDLERIGHT', 'center right') + '</option>'
					+ '<option value="bottomLeft">' + Joomla.JText._('KWP_BOTTOMLEFT', 'bottom left') + '</option>'
					+ '<option value="bottomCenter">' + Joomla.JText._('KWP_BOTTOMCENTER', 'bottom center') + '</option>'
					+ '<option value="bottomRight">' + Joomla.JText._('KWP_BOTTOMRIGHT', 'bottom right') + '</option>';
		} else if (imgalignment == 'centerRight') {
			imgdataalignmentoption = '<option value="default">Default</option>'
					+ '<option value="topLeft">' + Joomla.JText._('KWP_TOPLEFT', 'top left') + '</option>'
					+ '<option value="topCenter">' + Joomla.JText._('KWP_TOPCENTER', 'top center') + '</option>'
					+ '<option value="topRight">' + Joomla.JText._('KWP_TOPRIGHT', 'top right') + '</option>'
					+ '<option value="centerLeft">' + Joomla.JText._('KWP_MIDDLELEFT', 'center left') + '</option>'
					+ '<option value="center">' + Joomla.JText._('KWP_CENTER', 'center') + '</option>'
					+ '<option value="centerRight" selected="selected">' + Joomla.JText._('KWP_MIDDLERIGHT', 'center right') + '</option>'
					+ '<option value="bottomLeft">' + Joomla.JText._('KWP_BOTTOMLEFT', 'bottom left') + '</option>'
					+ '<option value="bottomCenter">' + Joomla.JText._('KWP_BOTTOMCENTER', 'bottom center') + '</option>'
					+ '<option value="bottomRight">' + Joomla.JText._('KWP_BOTTOMRIGHT', 'bottom right') + '</option>';
		} else if (imgalignment == 'bottomLeft') {
			imgdataalignmentoption = '<option value="default">Default</option>'
					+ '<option value="topLeft">' + Joomla.JText._('KWP_TOPLEFT', 'top left') + '</option>'
					+ '<option value="topCenter">' + Joomla.JText._('KWP_TOPCENTER', 'top center') + '</option>'
					+ '<option value="topRight">' + Joomla.JText._('KWP_TOPRIGHT', 'top right') + '</option>'
					+ '<option value="centerLeft">' + Joomla.JText._('KWP_MIDDLELEFT', 'center left') + '</option>'
					+ '<option value="center">' + Joomla.JText._('KWP_CENTER', 'center') + '</option>'
					+ '<option value="centerRight">' + Joomla.JText._('KWP_MIDDLERIGHT', 'center right') + '</option>'
					+ '<option value="bottomLeft" selected="selected">' + Joomla.JText._('KWP_BOTTOMLEFT', 'bottom left') + '</option>'
					+ '<option value="bottomCenter">' + Joomla.JText._('KWP_BOTTOMCENTER', 'bottom center') + '</option>'
					+ '<option value="bottomRight">' + Joomla.JText._('KWP_BOTTOMRIGHT', 'bottom right') + '</option>';
		} else if (imgalignment == 'bottomCenter') {
			imgdataalignmentoption = '<option value="default">Default</option>'
					+ '<option value="topLeft">' + Joomla.JText._('KWP_TOPLEFT', 'top left') + '</option>'
					+ '<option value="topCenter">' + Joomla.JText._('KWP_TOPCENTER', 'top center') + '</option>'
					+ '<option value="topRight">' + Joomla.JText._('KWP_TOPRIGHT', 'top right') + '</option>'
					+ '<option value="centerLeft">' + Joomla.JText._('KWP_MIDDLELEFT', 'center left') + '</option>'
					+ '<option value="center">' + Joomla.JText._('KWP_CENTER', 'center') + '</option>'
					+ '<option value="centerRight">' + Joomla.JText._('KWP_MIDDLERIGHT', 'center right') + '</option>'
					+ '<option value="bottomLeft">' + Joomla.JText._('KWP_BOTTOMLEFT', 'bottom left') + '</option>'
					+ '<option value="bottomCenter" selected="selected">' + Joomla.JText._('KWP_BOTTOMCENTER', 'bottom center') + '</option>'
					+ '<option value="bottomRight">' + Joomla.JText._('KWP_BOTTOMRIGHT', 'bottom right') + '</option>';
		} else if (imgalignment == 'bottomRight') {
			imgdataalignmentoption = '<option value="default">Default</option>'
					+ '<option value="topLeft">' + Joomla.JText._('KWP_TOPLEFT', 'top left') + '</option>'
					+ '<option value="topCenter">' + Joomla.JText._('KWP_TOPCENTER', 'top center') + '</option>'
					+ '<option value="topRight">' + Joomla.JText._('KWP_TOPRIGHT', 'top right') + '</option>'
					+ '<option value="centerLeft">' + Joomla.JText._('KWP_MIDDLELEFT', 'center left') + '</option>'
					+ '<option value="center">' + Joomla.JText._('KWP_CENTER', 'center') + '</option>'
					+ '<option value="centerRight">' + Joomla.JText._('KWP_MIDDLERIGHT', 'center right') + '</option>'
					+ '<option value="bottomLeft">' + Joomla.JText._('KWP_BOTTOMLEFT', 'bottom left') + '</option>'
					+ '<option value="bottomCenter">' + Joomla.JText._('KWP_BOTTOMCENTER', 'bottom center') + '</option>'
					+ '<option value="bottomRight" selected="selected">' + Joomla.JText._('KWP_BOTTOMRIGHT', 'bottom right') + '</option>';
		} else {
			imgdataalignmentoption = '<option value="default" selected="selected">Default</option>'
					+ '<option value="topLeft">' + Joomla.JText._('KWP_TOPLEFT', 'top left') + '</option>'
					+ '<option value="topCenter">' + Joomla.JText._('KWP_TOPCENTER', 'top center') + '</option>'
					+ '<option value="topRight">' + Joomla.JText._('KWP_TOPRIGHT', 'top right') + '</option>'
					+ '<option value="centerLeft">' + Joomla.JText._('KWP_MIDDLELEFT', 'center left') + '</option>'
					+ '<option value="center">' + Joomla.JText._('KWP_CENTER', 'center') + '</option>'
					+ '<option value="centerRight">' + Joomla.JText._('KWP_MIDDLERIGHT', 'center right') + '</option>'
					+ '<option value="bottomLeft">' + Joomla.JText._('KWP_BOTTOMLEFT', 'bottom left') + '</option>'
					+ '<option value="bottomCenter">' + Joomla.JText._('KWP_BOTTOMCENTER', 'bottom center') + '</option>'
					+ '<option value="bottomRight">' + Joomla.JText._('KWP_BOTTOMRIGHT', 'bottom right') + '</option>';
		}
	}*/
	if (!state || state == '1') {
		state = '1';
		statetxt = 'ON';
	} else {
		state = '0';
		statetxt = 'OFF';
	}

	index = kwpCheckIndex(0);
	var kwpslide = jQuery('<li class="kwpslide" id="kwpslide' + index + '" />');

	kwpslide.html('<div class="kwpslidehandle"><div class="kwpslidenumber">' + index + '</div></div>'
			+ '<div class="kwpslidedelete kwptip" title="' + Joomla.JText._('KWP_REMOVE2', '') + '" onclick="javascript:kwpRemoveSlide(jQuery(this).parent());"><i class="fas fa-times"></i></a></div>'
			+ '<div class="kwpslidetoggle" data-state="' + state + '"><div class="kwpslidetoggler">' + statetxt + '</div></div>'
			+ '<div class="kwpslidecontainer">'
			+ '<div class="kwpsliderow"><div class="kwpslideimgcontainer">'
			+ '<img src="' + imgthumb + '" width="64" height="64" onclick="kwpCallImageManagerPopup(\'kwpslideimgname' + index + '\')"/></div>'

			+ '<div class="kwpslideimgnamewrap kwpbutton-group">'
				+ '<input name="kwpslideimgname' + index + '" id="kwpslideimgname' + index + '" class="kwpslideimgname" type="text" value="' + imgname + '" onchange="javascript:kwpUpdateThumbnail(this.value, this);" />'
				+ '<a class="kwpbutton kwptip" onclick="kwpCallImageManagerPopup(\'kwpslideimgname' + index + '\')" href="javascript:void(0)" title="' + Joomla.JText._('KWP_SELECTIMAGE', 'select image') + '"><i class="fas fa-edit"></i></a></div>'
			+ '</div>'

			+ '<div class="kwpsliderow2">'
			// + '<span class="kwpslidelabel">' + Joomla.JText._('KWP_USETOSHOW', 'Display') + '</span><select class="ckslideselect">' + slideselectoption + '</select>'
		//	+ '<span><i class="fas fa-hourglass-half kwptip" title="' + Joomla.JText._('KWP_SLIDETIME', 'enter a specific time value for this slide, else it will be the default time') + '" style="color: #555;font-size: 16px;padding: 5px;"></i><input name="kwpslideimgtime' + index + '" class="kwpslideimgtime" type="text" value="' + imgtime + '" style="width:25px;" /></span><span>ms</span>'
			+ '</div>'
			
			+ '<div class="kwpsliderow"><div id="kwpslideaccordion' + index + '">'
			+ '<span class="kwpbutton kwpslideaccordeonbutton kwpinterfacetablink" data-group="main" data-tab="tab_maintext">' + Joomla.JText._('KWP_TEXT', 'Perihelion & Aphilion') + '</span>'
			//+ '<span class="kwpbutton kwpslideaccordeonbutton kwpinterfacetablink" data-group="main" data-tab="tab_mainimage">' + Joomla.JText._('KWP_IMAGE', 'Image') + '</span>'
			+ '<span class="kwpbutton kwpslideaccordeonbutton kwpinterfacetablink" data-group="main" data-tab="tab_mainlink">' + Joomla.JText._('KWP_LINK', 'Image W-H') + '</span>'
			+ '<span class="kwpbutton kwpslideaccordeonbutton kwpinterfacetablink" data-group="main" data-tab="tab_mainvideo">' + Joomla.JText._('KWP_VIDEO', 'Video') + '</span>'
			//+ '<span class="kwpbutton kwpslideaccordeonbutton kwpinterfacetablink" data-group="main" data-tab="tab_maindates">' + Joomla.JText._('KWP_DATES', 'Dates') + '</span>'
			+ '<div style="clear:both;"></div>'

			+ '<div class="kwpslideaccordeoncontent kwpinterfacetab" data-group="main" id="tab_maintext">'
				//+ '<span class="kwpbutton kwpslideaccordeonbutton kwpinterfacetablink ' + (texttype == 'custom' ? 'active open' : '') + '" data-allowclose="false" data-group="text" data-tab="tab_textcustom" data-value="custom">' + Joomla.JText._('KWP_TEXT_CUSTOM', 'Custom text') + '</span>'
				//+ '<span class="kwpbutton kwpslideaccordeonbutton kwpinterfacetablink ' + (texttype == 'article' ? 'active open' : '') + '" data-allowclose="false" data-group="text" data-tab="tab_textarticle" data-value="article">' + Joomla.JText._('KWP_ARTICLE', 'Article') + '</span>'
//				+ '<span class="kwpbutton kwpslideaccordeonbutton kwpinterfacetablink ' + (texttype == 'pagebuilderck' ? 'active open' : '') + '" data-allowclose="false" data-group="text" data-tab="tab_textpagebuilderck" data-value="pagebuilderck">' + Joomla.JText._('KWP_PAGEBUILDERCK', 'Page Builder CK') + '</span>'
				//+ '<div style="clear:both;"></div>'
				//+ '<div class="kwpslideaccordeoncontent kwpinterfacetab ' + (texttype == 'custom' ? 'current' : '') + '" data-group="text" id="tab_textcustom">'
					+ '<div class="kwpsliderow"><span class="kwpslidelabel">' + Joomla.JText._('KWP_TITLE', 'Perihelion(Shortest Distance to Sun)') + '</span><input name="kwpslidetitletext' + index + '" class="kwpslidetitletext" type="integer" value="' + imgtitle + '" /></div>'
					+ '<div class="kwpsliderow"><span class="kwpslidelabel">' + Joomla.JText._('KWP_CAPTION', 'Aphilion(Longest Distance to Sun)') + '</span><input name="kwpslidecaptiontext' + index + '" class="kwpslidecaptiontext" type="integer" value="' + imgcaption + '" /></div>'
				+ '</div>'
				//+ '<div class="kwpslideaccordeoncontent kwpinterfacetab ' + (texttype == 'article' ? 'current' : '') + '" data-group="text" id="tab_textarticle">'
					//+ '<div class="kwpsliderow kwpbutton-group" id="kwpsliderowarticle' + index + '"><label class="kwpslidelabel">' + Joomla.JText._('KWP_ARTICLE_ID', 'Article ID') + '</label><input name="kwpslidearticleid' + index + '" class="kwpslidearticleid input-medium" id="kwpslidearticleid' + index + '" style="width:20px" type="text" value="' + articleid + '" disabled="disabled" /><input name="kwpslidearticlename' + index + '" class="kwpslidearticlename input-medium" id="kwpslidearticlename' + index + '" type="text" value="' + articlename + '" disabled="disabled" /><a id="kwpslidearticlebuttonSelect" class="kwpmodal kwpbutton kwptip" title="' + Joomla.JText._('KWP_SELECT', 'Clear') + '" href="index.php?option=com_content&amp;layout=modal&amp;view=articles&amp;tmpl=component&amp;function=jSelectArticle_kwpslidearticleid' + index + '&' + KWP.TOKEN + '" rel="{handler: \'iframe\', size: {x: 800, y: 450}}"><i class="fas fa-edit"></i></a><a class="kwpbutton" href="javascript:void(0)" onclick="document.getElementById(\'kwpslidearticleid' + index + '\').value=\'\';document.getElementById(\'kwpslidearticlename' + index + '\').value=\'\';document.getElementById(\'kwpslidearticlebuttonEdit' + index + '\').style.display=\'none\';">' + Joomla.JText._('KWP_CLEAR', 'Clear') + '</a>'
					//+ '<a id="kwpslidearticlebuttonEdit' + index + '" class="kwpbutton" href="javascript:void(0)" onclick="kwpCallArticleEditionPopup(document.getElementById(\'kwpslidearticleid' + index + '\').value)" ' + (articleid != '' ? '' : 'style="display:none;"') + '>'+Joomla.JText._('KWP_EDIT', 'Edit')+'</a>'
					//+'</div>'
				//+ '</div>'
//				+ '<div class="ckslideaccordeoncontent ckinterfacetab ' + (texttype == 'pagebuilderck' ? 'current' : '') + '" data-group="text" id="tab_textpagebuilderck">'
//					+ '<div class="kwpsliderow kwpbutton-group" id="kwpsliderowpage' + index + '">'
//						+ '<label class="kwpslidelabel">' + Joomla.JText._('KWP_PAGEBUILERCK_PAGE_ID', 'Page ID') + '</label>'
//						+ '<input name="ckslidepagebuilderckid' + index + '" class="ckslidepagebuilderckid input-medium" id="ckslidepagebuilderckid' + index + '" style="width:20px" type="text" value="' + pagebuilderckid + '" disabled="disabled" />'
//						+ '<input name="ckslidepagebuilderckname' + index + '" class="ckslidepagebuilderckname input-medium" id="ckslidepagebuilderckname' + index + '" type="text" value="' + pagebuilderckname + '" disabled="disabled" />'
//						+ '<a id="ckslidepagebuilderkwpbuttonSelect" class="ckmodal kwpbutton cktip" title="' + Joomla.JText._('KWP_SELECT', 'Clear') + '" href="index.php?option=com_content&amp;layout=modal&amp;view=articles&amp;tmpl=component&amp;function=jSelectArticle_ckslidearticleid' + index + '&' + KWP.TOKEN + '" rel="{handler: \'iframe\', size: {x: 800, y: 450}}"><i class="fas fa-edit"></i></a>'
//						+ '<a class="kwpbutton" href="javascript:void(0)" onclick="document.getElementById(\'ckslidearticleid' + index + '\').value=\'\';document.getElementById(\'ckslidearticlename' + index + '\').value=\'\';">' + Joomla.JText._('KWP_CLEAR', 'Clear') + '</a>'
//						+(pagebuilderckid != '' ? '<a id="ckslidepagebuilderkwpbuttonEdit" class="kwpbutton" href="javascript:void(0)" onclick="ckCallPagebuilderckEditionPopup('+pagebuilderckid+')">'+Joomla.JText._('KWP_EDIT', 'Edit')+'</a>' : '')
//					+'</div>'
//				+ '</div>'

			
			+ '</div>'
			
			
			//+ '<div class="kwpslideaccordeoncontent kwpinterfacetab" data-group="main" id="tab_mainimage">'
			//+ '<div class="kwpsliderow"><span class="kwpslidelabel">' + Joomla.JText._('KWP_ALIGNEMENT_LABEL', 'Image alignment') + '</span><select name="kwpslidedataalignmenttext' + index + '" class="kwpslidedataalignmenttext" >' + imgdataalignmentoption + '</select></div>'
			//+ '</div>'
			+ '<div class="kwpslideaccordeoncontent kwpinterfacetab" data-group="main" id="tab_mainlink">'
				
				+ '<div class="kwpsliderow">'
					+ '<div class="kwpbutton-group">'
					+ '<label class="kwpslidelabel">' + Joomla.JText._('','Width & Height of The Star or Planet Img') + '</label><input id="kwpslidelinktext' + index + '" name="kwpslidelinktext' + index + '" class="kwpslidelinktext" type="text" placeholder="eg. 93-93" value="' + imglink + '" />'
					+ '<a class="kwpbutton kwptip" onclick="kwpCallMenusSelectionPopup(\'kwpslidelinktext' + index + '\')" href="javascript:void(0)" title="' + Joomla.JText._('KWP_SELECT_LINK', 'select image') + '"><i class="fas fa-edit"></i></a>'
					+ '</div>'
				+ '</div>'
			+ '<div class="kwpsliderow"><span class="kwpslidelabel">' + Joomla.JText._('KWP_TARGET', 'Target') + '</span><select name="kwpslidetargettext' + index + '" class="kwpslidetargettext" >' + imgtargetoption + '</select></div>'
			+ '</div>'
			+ '<div class="kwpslideaccordeoncontent kwpinterfacetab" data-group="main" id="tab_mainvideo">'
			+ '<div class="kwpsliderow">'
			+ '<div class="kwpbutton-group">'
			+' <label class="kwpslidelabel">' + Joomla.JText._('KWP_VIDEOURL', 'Video url') + '</label><input id="kwpslidevideotext' + index + '" name="kwpslidevideotext' + index + '" class="kwpslidevideotext" type="text" value="' + imgvideo + '" /><a class="kwpbutton kwptip" title="' + Joomla.JText._('KWP_SELECT', 'Clear') + '" href="javascript:void(0)" onclick="kwpCallVideoManagerPopup(\'kwpslidevideotext' + index + '\')"><i class="fas fa-edit"></i></a></div>'
			+ '</div>'
			+ '</div>'
			//+ '<div class="kwpslideaccordeoncontent kwpinterfacetab" data-group="main" id="tab_maindates">'
			//+ '<div class="kwpsliderow"><span class="kwpslidelabel">' + Joomla.JText._('KWP_STARTDATE', 'Start date') + '</span><input name="kwpslidestartdate' + index + '" class="kwpslidestartdate kwpdatepicker" type="text" value="' + startdate + '" /></div>'
			//+ '<div class="kwpsliderow"><span class="kwpslidelabel">' + Joomla.JText._('KWP_ENDDATE', 'End date') + '</span><input name="kwpslideenddate' + index + '" class="kwpslideenddate kwpdatepicker" type="text" value="' + enddate + '" /></div>'
			//+ '</div>'
			+ '</div></div>'
			+ '</div><div style="clear:both;"></div>');

	jQuery('#kwpslideslist').append(kwpslide);
	
	/*script = document.createElement("script");
	script.setAttribute('type', 'text/javascript');
	script.text = "function jSelectArticle_kwpslidearticleid" + index + "(id, title, catid, object) {"
			+ "document.getElementById('kwpslidearticleid" + index + "').value = id;"
			+ "document.getElementById('kwpslidearticlename" + index + "').value = title;"
			+ "document.getElementById('kwpslidearticlebuttonEdit" + index + "').style.display = 'inline-block';"
			+ "KWPBox.close();"
			+ "}";*/

	//document.body.appendChild(script);

	kwpStoreSlides();
	kwpMakeSlidesSortable();

	KWPBox.assign(jQuery('#kwpslide' + index + ' a.kwpmodal'), {
		parse: 'rel'
	});
//	create_tabs_in_slide(jQuery('#ckslide' + index));
	kwpInitTabs(jQuery('#kwpslide' + index), true);
	//KWPApi.Tooltip(jQuery('#kwpslide' + index + ' .kwptip'));
	//jQuery('#kwpslide' + index + ' .kwpdatepicker').datepicker({"dateFormat": "d MM yy"});

	// add code to toggle the slide state
	jQuery('#kwpslide' + index + ' .kwpslidetoggle').click(function() {
		if (jQuery(this).attr('data-state') == '0') {
			jQuery(this).attr('data-state', '1');
			jQuery(this).find('.kwpslidetoggler').text('ON');
		} else {
			jQuery(this).attr('data-state', '0');
			jQuery(this).find('.kwpslidetoggler').text('OFF');
		}
	});
}

function kwpCheckIndex(i) {
	while (jQuery('#kwpslide' + i).length)
		i++;
	return i;
}


function kwpRemoveSlide(slide) {
	if (confirm(Joomla.JText._('KWP_REMOVE', 'Remove this slide') + ' ?')) {
		jQuery(slide).remove();
		kwpStoreSlides();
	}
	jQuery('.kwptooltip').remove();
}

function kwpStoreSlides() {
	var i = 0;
	var slides = new Array();
	jQuery('#kwpslideslist .kwpslide').each(function(i, el) {
		el = jQuery(el);
		slide = new Object();
		slide['imgname'] = el.find('.kwpslideimgname').val();
		slide['imgcaption'] = el.find('.kwpslidecaptiontext').val();
		slide['imgcaption'] = slide['imgcaption'].replace(/"/g, "|dq|");
		slide['imgtitle'] = el.find('.kwpslidetitletext').val();
		slide['imgtitle'] = slide['imgtitle'].replace(/"/g, "|dq|");
		slide['imgthumb'] = el.find('img').attr('src');
		slide['imglink'] = el.find('.kwpslidelinktext').val();
		slide['imglink'] = slide['imglink'].replace(/"/g, "|dq|");
		slide['imgtarget'] = el.find('.kwpslidetargettext').val();
		//slide['imgalignment'] = el.find('.kwpslidedataalignmenttext').val();
		slide['imgvideo'] = el.find('.kwpslidevideotext').val();
		 slide['slideselect'] = el.find('.kwpslideselect').val();
		//slide['slidearticleid'] = el.find('.kwpslidearticleid').val();
		//slide['slidepagebuilderckid'] = el.find('.kwpslidepagebuilderckid').val();
		//slide['slidearticlename'] = el.find('.kwpslidearticlename').val();
		//slide['slidepagebuilderckname'] = el.find('.kwpslidepagebuilderckname').val();
		//slide['imgtime'] = el.find('.kwpslideimgtime').val();
		slide['state'] = el.find('.kwpslidetoggle').attr('data-state');
		//slide['startdate'] = el.find('.kwpslidestartdate').val();
		//slide['enddate'] = el.find('.kwpslideenddate').val();
		//slide['texttype'] = el.find('.kwpbutton[data-group="text"].active').attr('data-value');
		slides[i] = slide;
		i++;
	});

	slides = JSON.stringify(slides);
	slides = slides.replace(/"/g, "|qq|");
	jQuery('#kwpslides').val(slides);

}

function kwpCallSlides() {
	var slides = jQuery.parseJSON(jQuery('#kwpslides').val().replace(/\|qq\|/g, "\""));
	if (slides.length) {
		jQuery(slides).each(function(i, slide) {
			kwpAddSlide(slide);
		});
	}
}


function kwpMakeSlidesSortable() {
	jQuery("#kwpslideslist").sortable({
//		placeholder: "ui-state-highlight",
		handle: ".kwpslidehandle",
		items: ".kwpslide",
		axis: "y",
		forcePlaceholderSize: true,
		forceHelperSize: true,
		dropOnEmpty: true,
		tolerance: "pointer",
		placeholder: "placeholder",
		connectWith: '',
		zIndex: 9999,
		update: function(event, ui) {
			kwpRenumberSlides();
		},
		sort: function(event, ui) {
			jQuery(ui.placeholder).height(jQuery(ui.helper).height());
		}
	});
}

function kwpRenumberSlides() {
	var index = 0;
	jQuery('.kwpslide').each(function(i, slide) {
		jQuery('.kwpslidenumber', jQuery(slide)).html(i);
		index++;
	});
}

function checkprihelions()
{
	console.log("Haaaahaaamid!");
	var arr = [];
	arr = jQuery('.kwpslidetitletext');
	console.log("sexual garbage u are:"+arr);
	/*
	for(var i=0; i<arr.length; i++)
	{
		for(var j=1; j<arr.length; j++)
		{
			if( (int) arr[i].attr('value')> (int) arr[j].attr('value'))
			{
				alert("Prihelions must be from small to large, in an Ascending order, change your datas!");
				return false;
			}
		}
	}*/
}
function checkaphilions()
{
     var arr = [];
	arr = jQuery('.kwpslidecaptiontext');
	return false;
	/*for(var i=0; i<arr.length; i++)
	{
		for(var j=1; j<arr.length; j++)
		{
			if( (int) arr[i].attr('value')> (int) arr[j].attr('value'))
			{
				alert("Aphelions must be from small to large, in an Ascending order, change your datas!");
				return false;
			}
		}
	}*/
}

jQuery(document).ready(function() {
	console.log("reeeeeeeeeeeeeeedam dar ...");
	
	jQuery('.kwpslidetitletext').on( 'mouseout', function(){
	
		//alert("zan");
		  
	});
		kwpCallSlides();

	var script = document.createElement("script");
	script.setAttribute('type', 'text/javascript');
	script.text = "var Kwpsolarsystem = {};"
			+ "Kwpsolarsystem.submitbutton = Joomla.submitbutton;"
			+ "Joomla.submitbutton = function(task){"
				+ "kwpStoreSlides();"
			+ "Kwpsolarsystem.submitbutton(task);"
			+ "};"
			+ "jInsertEditorText = function(text, editor) {kwpInsertMedia(text, editor)};";

	document.body.appendChild(script);
});
