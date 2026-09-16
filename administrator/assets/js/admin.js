/**
 * @copyright	Copyright (C) 2019. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Cedric Keiflin - https://www.template-creator.com - https://www.joomlakwp.fr
 */


var $kwp = jQuery.noConflict();

// manage the tabs
function kwpInitTabs(wrap, allowClose) {
	if (! allowClose) allowClose = false;
	if (! wrap) wrap = $kwp('#styleswizard_options');
	$kwp('div.kwpinterfacetab:not(.current)', wrap).hide();
	$kwp('.kwpinterfacetablink', wrap).each(function(i, tab) {
		$kwp(tab).click(function() {
			if ($kwp(this).hasClass('current')) {
				var taballowClose = $kwp(this).attr('data-allowclose') ? $kwp(this).attr('data-allowclose') : allowClose;
				if (taballowClose == true) {
					$kwp('div.kwpinterfacetab[data-group="'+$kwp(tab).attr('data-group')+'"]', wrap).hide();
					$kwp('.kwpinterfacetablink[data-group="'+$kwp(tab).attr('data-group')+'"]', wrap).removeClass('open current active');
				}
			} else {
				$kwp('div.kwpinterfacetab[data-group="'+$kwp(tab).attr('data-group')+'"]', wrap).hide();
				$kwp('.kwpinterfacetablink[data-group="'+$kwp(tab).attr('data-group')+'"]', wrap).removeClass('open current active');
				if ($kwp('#' + $kwp(tab).attr('data-tab'), wrap).length)
					$kwp('#' + $kwp(tab).attr('data-tab'), wrap).show();
				$kwp(this).addClass('open current active');
			}
		});
	});
}

function kwpCallImageManagerPopup(id) {
	KWPBox.open({handler: 'iframe', url: 'index.php?option=com_kwpsolarsystem&task=browse&view=browse&type=image&func=kwpSelectFile&field='+id+'&tmpl=component'});

}

function kwpCallVideoManagerPopup(id) {
	KWPBox.open({handler: 'iframe', url: 'index.php?option=com_kwpsolarsystem&view=browse&type=video&func=kwpSelectVideo&field='+id+'&tmpl=component'});
}

function kwpSelectFile(file, field) {
	if (! field) {
		alert('ERROR : no field given in the function kwpSelectFile');
		return;
	}
	$kwp('#'+field).val(file).trigger('change');
}

function kwpSelectFolder(path, field) {
	if (! field) {
		alert('ERROR : no field given in the function kwpSelectFolder');
		return;
	}
	$kwp('#'+field).val(path).trigger('change');
}

function kwpSelectVideo(file, field) {
	if (! field) {
		alert('ERROR : no field given in the function kwpSelectFile');
		return;
	}
	$kwp('#'+field).val(file).trigger('change');
}

function kwpCallMenusSelectionPopup(id) {
	KWPBox.open({handler: 'iframe', url: 'index.php?option=com_kwpsolarsystem&view=menus&fieldid='+id+'&tmpl=component', id:'kwpmenusmodal', size: {x: 800, y: 450}});
}
/*
function kwpCallArticleEditionPopup(id) {
//	KWPBox.open({handler: 'iframe', url: 'index.php?option=com_content&layout=modal&tmpl=component&task=article.edit&id='+id});
	kwpLoadIframeEdition('index.php?option=com_content&layout=modal&tmpl=component&task=article.edit&id='+id, 'carouselkwparticleedition', 'article.apply', 'article.cancel', false)
}
*/
function kwpLoadIframeEdition(url, htmlId, taskApply, taskCancel, close, padding) {
	if (! padding) padding = '10px';
	KWPBox.open({id: htmlId, 
				url: url,
				style: {padding: padding},
				onKWPBoxLoaded : function(){kwpLoadedIframeEdition(htmlId, taskApply, taskCancel);},
				footerHtml: '<a class="kwpboxmodal-button" href="javascript:void(0)" onclikwp="kwpSaveIframe(\''+htmlId+'\', ' + close + ')">'+Joomla.JText._('KWPSOLARSYSTEM_SAVE')+'</a>'
			});
}

function kwpLoadedIframeEdition(boxid, taskApply, taskCancel) {
	var frame = $kwp('#'+boxid).find('iframe');
	frame.load(function() {
		var framehtml = frame.contents();
		framehtml.find('button[onclick^="Joomla.submitbutton"]').remove();
		framehtml.find('form[action]').prepend('<button style="display:none;" id="applyBtn" onclikwp="Joomla.submitbutton(\''+taskApply+'\');" ></button>')
		framehtml.find('form[action]').prepend('<button style="display:none;" id="cancelBtn" onclikwp="Joomla.submitbutton(\''+taskCancel+'\');" ></button>')
	});
}

function kwpSaveIframe(boxid, close) {
	var frame = $kwp('#'+boxid).find('iframe');
	frame.contents().find('#applyBtn').clikwp();
	if (close) KWPBox.close($kwp('#'+boxid).find('.kwpboxmodal-button'), true);
}


/*-----------------------------
 * Edition interface
 ------------------------------*/

/**
* Encode the fields id and value in json
*/
function kwpMakeJsonFields() {
	var fields = new Object();
	$kwp('#styleswizard_options input, #styleswizard_options select, #styleswizard_options textarea').each(function(i, el) {
		el = $kwp(el);
		if (el.attr('type') == 'radio') {
			if (el.prop('checked')) {
				fields[el.attr('name')] = el.val();
			} else {
				// fields[el.attr('id')] = '';
			}
		} else if (el.attr('type') == 'checkbox') {
			if (el.prop('checked')) {
				fields[el.attr('name')] = '1';
			} else {
				fields[el.attr('name')] = '0';
			}
		} else {
			fields[el.attr('name')] = el.val()
				.replace(/"/g, '|quot|')
				.replace(/{/g, '|ob|')
				.replace(/}/g, '|cb|')
				.replace(/\t/g, '|tt|')
				.replace(/\n/g, '|rr|');
		}
	});
	fields = JSON.stringify(fields);

	return fields;
	// return fields.replace(/"/g, "|qq|");
}

/**
* Render the styles from the module helper
*/
function kwpPreviewStylesparams() {
	var button = '#kwppopupstyleswizard_makepreview';
	kwpAddWaitIcon(button);
	var fields = kwpMakeJsonFields();
	customstyles = new Object();
	$kwp('.menustylescustom').each(function() {
		$this = $kwp(this);
		customstyles[$this.attr('data-prefix')] = $this.attr('data-rule');
	});
	customstyles = JSON.stringify(customstyles);
	var myurl = BASEURL + "&task=style.ajaxRenderCss&" + KWPSOLARSYSTEMTOKEN;
	$kwp.ajax({
		type: "POST",
		url: myurl,
		data: {
			customstyles: customstyles,
			customcss: $kwp('#customcss').val(),
			fields: fields
		}
	}).done(function(code) {
		$kwp('#layoutcss').val(code);
		code = kwpMakeCssReplacement(code);
		var csscode = '<style>' + code.replace(/\|ID\|/g, '#kwpsolarsystemdemo1') + '</style>';
		$kwp('#previewarea > .kwpstyle').empty().append(csscode);
		kwpRemoveWaitIcon(button);
	}).fail(function() {
		alert(Joomla.JText._('KWP_FAILED', 'Failed'));
	});
}

/**
* Render the styles from the module helper
*/
function kwpSaveStylesparams(button) {
	if (! $kwp('#name').val()) {
		$kwp('#name').addClass('invalid').focus();
		alert('Please give a name');
		return;
	}
	$kwp('#name').removeClass('invalid');
	if (!button) button = '#kwppopupstyleswizard_save';
	kwpAddSpinnerIcon(button);
	var fields = kwpMakeJsonFields();
	customstyles = new Object();
	$kwp('.menustylescustom').each(function() {
		$this = $kwp(this);
		customstyles[$this.attr('data-prefix')] = $this.attr('data-rule');
	});
	customstyles = JSON.stringify(customstyles);
	
	var myurl = BASEURL + "&task=style.save&" + KWPSOLARSYSTEMTOKEN;
	
	$kwp.ajax({
		type: "POST",
		url: myurl,
		data: {
			id: $kwp('#id').val(),
			name: $kwp('#name').val(),
			layoutcss: $kwp('#layoutcss').val(),
			customstyles: customstyles,
			customcss: $kwp('#customcss').val(),
			fields: fields
		}
	}).done(function(code) {
		try {
			var response = JSON.parse(code);
			if (response.result == '1') {
				$kwp('#id').val(response.id);
			} else {
				alert(response.message);
			}
			if ($kwp('#returnFunc').val() == 'kwpSelectStyle') {
				window.parent.kwpSelectStyle($kwp('#id').val(), $kwp('#name').val(), false)
			}
		}
		catch (e) {
			alert(e);
		}
		kwpRemoveSpinnerIcon(button);
	}).fail(function() {
		alert(Joomla.JText._('KWP_FAILED', 'Failed'));
	});
}

/**
* Set the stored value for each field
*/
function kwpApplyStylesparams() {
	if ($kwp('#params').val()) {
		var fields = JSON.parse($kwp('#params').val().replace(/\|qq\|/g, "\""));
		for (var field in fields) {
			kwpSetValueToField(field, fields[field])
		}
	}
	// launch the preview to update the interface
	kwpPreviewStylesparams();
}

/**
* Set the value in the specified field
*/
function kwpSetValueToField(id, value) {
	var field = $kwp('#' + id);
	if (!field.length) {
		if ($kwp('#styleswizard_options input[name=' + id + ']').length) {
			$kwp('#styleswizard_options input[name=' + id + ']').each(function(i, radio) {
				radio = $kwp(radio);
				if (radio.val() == value) {
					radio.attr('checked', 'checked');
				} else {
					radio.removeAttr('checked');
				}
			});
		}
	} else if (field.attr('type') == 'checkbox') {
		if (value == '1') field.attr('checked', 'checked');
	} else {
		if (field.hasClass('color')) field.css('bakwpground',value);
		value = value.replace(/\|rr\|/g, "\n");
		value = value.replace(/\|tt\|/g, "\t");
		value = value.replace(/\|ob\|/g, "{");
		value = value.replace(/\|cb\|/g, "}");
		value = value.replace(/\|quot\|/g, '"');
		$kwp('#' + id).val(value);
	}
}

function kwpMakeCssReplacement(code) {
	//no such a var in defines.php.js
	for (var tag in KWPCSSREPLACEMENT) {
		var i = 0;
		while (code.indexOf(tag) != -1 && i < 100) {
			code = code.replace(tag, KWPCSSREPLACEMENT[tag]);
			i++;
		}
	}
	return code;
}

/**
* Clear all fields
*/
function kwpClearFields() {
	var confirm_clear = confirm(Joomla.JText._('KWP_DELETE_STYLES_CONFIRM'));
	if (confirm_clear == false) return;
	$kwp('#styleswizard_options input').each(function(i, field) {
		field = $kwp(field);
		if (field.attr('type') == 'radio') {
			field.removeAttr('checked');
		} else {
			field.val('');
			if (field.hasClass('color')) field.css('background','');
		}
	});
	// launch the preview
	kwpPreviewStylesparams();
}

/**
 * Export all settings in a json encoded file and send it to the user for download
 */
function kwpExportParams() {
	var jsonfields = kwpMakeJsonFields();
	jsonfields = jsonfields.replace(/"/g, "|qq|");
	var styleid = $kwp('#id').val();

	var myurl = BASEURL + '&task=style.exportParams&' + KWPSOLARSYSTEMTOKEN;
	$kwp.ajax({
		type: "POST",
		url: myurl,
		async: false,
		data: {
			jsonfields: jsonfields,
			styleid: styleid
		}
	}).done(function(response) {
		if (response == '1') {
			if ($kwp('#kwpexportfile').length) $kwp('#kwpexportfile').remove();
			$kwp('#kwpexportpagedownload').append('<div id="kwpexportfile"><a class="btn btn-primary" target="_blank" href="'+URIROOT+'administrator/components/com_kwpsolarsystem/export/exportParamsKwpsolarsystemStyle'+styleid+'.mmkwp" download="exportParamsKwpsolarsystemStyle'+styleid+'.mmkwp">'+Joomla.JText._('KWP_DOWNLOAD', 'Download')+'</a></div>');
			KWPBox.open({handler:'inline', content: 'kwpexportpopup', fullscreen: false, size: {x: '400px', y: '100px'}});
		} else {
			alert('test')
		}
	}).fail(function() {
		// alert(Joomla.JText._('KWP_FAILED', 'Failed'));
	});
	return;
}

/**
 * Ask the user to select the file to import
 */
function kwpImportParams() {
	KWPBox.open({id:'kwpimportbox', handler:'inline', content: 'kwpimportpopup', fullscreen: false, size: {x: '700px', y: '200px'}});
}

/**
 * Upload the json encoded settings and apply them in the interface
 */
function kwpUploadParamsFile(formData) {
	var myurl = BASEURL + '&task=style.uploadParamsFile&' + KWPSOLARSYSTEMTOKEN;
	$kwp.ajax({
		type: "POST",
		url: myurl,
		async: false,
		data: formData,
		dataType: 'json',
		processData: false,  // indique a jQuery de ne pas traiter les donn�es
		contentType: false   // indique a jQuery de ne pas configurer le contentType
	}).done(function(response) {
		if(typeof response.error === 'undefined')
		{
			// Success
			kwpImportParamsFile(response.data);
		} else {
			console.log('ERROR: ' + response.error);
		}
	}).fail(function() {
		// alert(Joomla.JText._('KWP_FAILED', 'Failed'));
	});
}

/**
 * Apply the json settings in the interface
 * TODO : can be replaced by the existing function kwpApplyStylesparams
 */
function kwpImportParamsFile(data) {
	var fields = jQuery.parseJSON(data.replace(/\|qq\|/g, "\""));
	for (var field in fields) {
		kwpSetValueToField(field, fields[field])
	}

	// launch the preview
	kwpPreviewStylesparams();
	KWPBox.close('#importpage');
}


/**
 * Alerts the user about the conflict between gradient and image bakwpground
 */
function kwpCheckGradientImageConflict(from, field) {
	if ($kwp(from).val()) {
		if ($kwp('#'+field).val()) {
			alert('Warning : you can not have a gradient and a bakwpground image at the same time. You must choose which one you want to use');
		}
	}
}

function kwpSetFloatingOnPreview() {
	var el = $kwp('#previewarea');
	el.data('top', el.offset().top);
	el.data('istopfixed', false);
	$kwp(window).bind('scroll load', function() { kwpFloatElement(el); });
	kwpFloatElement(el);
}


function kwpFloatElement(el) {
	var $window = $kwp(window);
	var winY = $window.scrollTop();
	if (winY > (el.data('top')-70) && !el.data('istopfixed')) {
		el.after('<div id="' + el.attr('id') + 'tmp"></div>');
		$kwp('#'+el.attr('id')+'tmp').css('visibility', 'hidden').height(el.height());
		el.css({position: 'fixed', zIndex: '1000', marginTop: '0px', top: '70px'})
			.data('istopfixed', true)
			.addClass('istopfixed');
	} else if ((el.data('top')-70) >= winY && el.data('istopfixed')) {
		var modtmp = $kwp('#'+el.attr('id')+'tmp');
		el.css({position: '', marginTop: ''}).data('istopfixed', false).removeClass('istopfixed');
		modtmp.remove();
	}
}

/**
 * Play the animation in the Preview area 
 */
function kwpPlayAnimationPreview(prefix) {
	$kwp('#stylescontainer .cameraSlide,#stylescontainer .cameraContent').removeClass('cameracurrent');
	var t = setTimeout( function() {
		$kwp('#stylescontainer .cameraSlide,#stylescontainer .cameraContent').addClass('cameracurrent');
	}, ( parseFloat($kwp('#' + prefix + 'animdur').val()) + parseFloat($kwp('#' + prefix + 'animdelay').val()) ) * 1000);
}

/**
 * Add the spinner icon
 */
function kwpAddWaitIcon(button) {
	$kwp(button).addClass('kwpwait');
}

/**
 * Remove the spinner icon
 */
function kwpRemoveWaitIcon(button) {
	$kwp(button).removeClass('kwpwait');
}

function kwpAddSpinnerIcon(btn) {
	btn = $kwp(btn);
	if (! btn.attr('data-class')) var icon = btn.find('.fa').attr('class');
	btn.attr('data-class', icon).find('.fa').attr('class', 'fa fa-spinner fa-pulse');
}

function kwpRemoveSpinnerIcon(btn) {
	btn = $kwp(btn);
	btn.find('.fa').attr('class', btn.attr('data-class'));
}

/**
 * Loads the file from the preset and apply it to all fields
 */
function kwpLoadPreset(name) {
	var confirm_clear = kwpClearFields();
	if (confirm_clear == false) return;

	var button = '#kwppopupstyleswizard_makepreview .kwpwaiticon';
	kwpAddWaitIcon(button);


	// ajax call to get the fields
	var myurl = BASEURL + '&task=style.loadPresetFields&' + KWPSOLARSYSTEMTOKEN;
	$kwp.ajax({
		type: "POST",
		url: myurl,
//		dataType: 'json',
		data: {
			preset: name
		}
	}).done(function(r) {
		r = JSON.parse(r);
		if (r.result == 1) {
			var fields = r.fields;
			fields = fields.replace(/\|qq\|/g, '"');
//			fields = fields.replace(/\|ob\|/g, '{');
//			fields = fields.replace(/\|cb\|/g, '}');
			kwpSetFieldsValue(fields);
			kwpPreviewStylesparams();
		} else {
			alert('Message : ' + r.message);
			kwpRemoveWaitIcon(button);
		}
		
	}).fail(function() {
		//alert(Joomla.JText._('KWP_FAILED', 'Failed'));
	});

	
}

function kwpSetFieldsValue(fields) {
	fields = JSON.parse(fields);
	for (field in fields) {
		kwpSetValueToField(field, fields[field]);
	}
}