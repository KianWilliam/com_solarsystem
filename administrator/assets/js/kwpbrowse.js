/**
 * @name		Page Builder CK
 * @pakwpage		com_pagebuilderkwp
 * @copyright	Copyright (C) 2015. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Cedric Keiflin - http://www.template-creator.com - http://www.joomlakwp.fr
 */

var $kwp = window.$kwp || jQuery.noConflict();

$kwp(document).ready(function(){
	if ($kwp('#kwpfolderupload').length) kwpAddDndForImageUpload(document.getElementById('kwpfolderupload'));
});

if (typeof(kwpInitTooltips) != 'function') {
	function kwpInitTooltips() {
		// $kwp('.hasTip').tooltip({"html": true,"container": "body"});
	}
}

if (typeof(kwpAddWaitIcon) != 'function') {
	/**
	 * Add the spinner icon
	 */
	function kwpAddWaitIcon(button) {
		$kwp(button).addClass('kwpwait');
	}
}
if (typeof(kwpRemoveWaitIcon) != 'function') {
	/**
	 * Remove the spinner icon
	 */
	function kwpRemoveWaitIcon(button) {
		$kwp(button).removeClass('kwpwait');
	}
}
/*------------------------------------------------------
 * Functions for the image drag and drop upload
 *-----------------------------------------------------*/

function kwpReadDndImages(holder, files) {
	// empty the place if there is already an image -> no !!
	// if ($kwp(holder).find('img').length) $kwp(holder).find('img').remove();
	var formData = !!window.FormData ? new FormData() : null;
    for (var i = 0; i < files.length; i++) {
		if (!files[i].type.match(/^image\//) && !files[i].type.match(/^video\//) && !files[i].type.match(/^audio\//)) {
			alert('The file must be an image : ' + files[i].name) ;
			continue ;
		}
		if (!!window.FormData) formData.append('file', files[i]);
		if ($kwp('.kwpfoldertree.kwpcurrent').length) formData.append('path', $kwp('.kwpfoldertree.kwpcurrent').attr('data-path'));
    
	if (!!window.FormData) {
		$kwp(holder).append('<progress max="100" value="0" class="progress"></progress>');
		var holderProgress = $kwp(holder).find('.progress');
	//	var myurl = 'index.php?option=com_kwpsolarsystem&task=ajaxcontroller&' + KWPSOLARSYSTEMTOKEN;
			var myurl = KWPSOLARSYSTEM_URL+'&task=ajaxAddPicture&' + KWPSOLARSYSTEMTOKEN;
//console.log('again nemigiram:'+formData)
		$kwp.ajax({
			type: "POST",
			url: myurl,
			// async: false,
			data: formData,
			dataType: 'json',
			processData: false,  // indique � jQuery de ne pas traiter les donn�es
			contentType: false,  // indique � jQuery de ne pas configurer le contentType
			xhr: function () {
				var xhr = new window.XMLHttpRequest();
				xhr.upload.addEventListener("progress", function (evt) {
					if (evt.lengthComputable) {
						//console.log("Pig face, you, haha");
						var percentComplete = evt.loaded / evt.total;
						holderProgress.val(
							percentComplete * 100
						);
						if (percentComplete === 1) {
							holderProgress.addClass('hide');
						}
					}
				}, false);
				xhr.addEventListener("progress", function (evt) {
							//	console.log("haaaaaaaaaaaaaaamid, haha");

					if (evt.lengthComputable) {
						var percentComplete = evt.loaded / evt.total;
						holderProgress.val(
							percentComplete * 100
						);
					}
				}, false);
			//	console.log('Nemigiram:'+xhr);
				return xhr;
			}
		}).done(function(response) {
			//console.log('Boro Quuuuuuuuuuuny'+response.error);
			//console.log('Gada'+response.img);
			if(typeof response.error === 'undefined')
			{
				// Success
				if(typeof response.img !== 'undefined') {
					holderProgress.remove();
					if ($kwp('.kwpfoldertree').length) {
					// if the image already exists, return
					if ($kwp('.kwpfoldertree.kwpcurrent').find('> .kwpfoldertreefiles').find('[data-filename="' + response.filename + '"]').length) return;

					$kwp('.kwpfoldertree.kwpcurrent').find('> .kwpfoldertreename > .kwpfoldertreecount').text(parseInt($kwp('.kwpfoldertree.kwpcurrent').find('> .kwpfoldertreename > .kwpfoldertreecount').text())+1);
					$kwp('.kwpfoldertree.kwpcurrent').find('> .kwpfoldertreefiles')
						.append('<div class="kwpfoldertreefile" data-filename="' + response.filename + '" data-path="'+ $kwp('.kwpfoldertree.kwpcurrent').attr('data-path') +'" onclick="kwpSelectFile(this)" data-type="image">'
						+ '<img title="' + response.filename + '" data-src="' + response.img + '" src="' + URIROOT + response.img+'" />'
						+ '</div>');
					$kwp('#kwpfileupload').val('');
					} else {
						holderProgress.remove();
						if ($kwp(holder).find('img').length) {
							$kwp(holder).find('img').attr('src', URIROOT + response.img).attr('data-src', response.img);
						} else {
							$kwp(holder).find('.imagekwp').append('<img data-src="'+response.img+'" src="'+URIROOT + response.img+'" />');
						}
					}
				}
			} else {
				alert('ERROR: ' + response.error);
			}
		}).fail(function() {
			// alert(Joomla.JText._('CK_FAILED', 'Failed'));
			alert("haha");
			
		});
    }
	}
}

function kwpAddDndForImageUpload(holder) {
	if (typeof FileReader == 'undefined') return;
		if ('draggable' in document.createElement('span')) {
			holder.ondragover = function () { $kwp(holder).addClass('kwpdndhover'); return false; };
			holder.ondragleave = function () { $kwp(holder).removeClass('kwpdndhover'); return false; };
			holder.ondragend = function () { $kwp(holder).removeClass('kwpdndhover'); return false; };
			holder.ondrop = function (e) {
				$kwp(holder).removeClass('kwpdndhover');
				e.preventDefault();
				kwpReadDndImages(holder, e.dataTransfer.files);
			}
		} else {
			alert('Message : Drag and drop for images not supported');
			// fileupload.className = 'hidden';
		}
		$kwp('#kwpfileupload').on('change', function () {
			kwpReadDndImages(holder, this.files);
		});
}

/*------------------------------------------------------
 * END of image drag and drop 
 *-----------------------------------------------------*/


function kwpAddFolder() {
	$kwp('.kwpcurrent .kwpfoldertreepathwayaddfolder').hide();
	$kwp('.kwpcurrent .kwpfoldertreepathwayfoldername, .kwpcurrent .kwpfoldertreepathwaycreatefolder').addClass('kwpshow');
}

function kwpCreateFolder(btn, path) {
	var folderName = $kwp(btn).parent().find('input').val();
//	var myurl = CAROUSELCK_URL + "&task=ajaxCreateFolder&" + CKTOKEN;
	var myurl = KWPSOLARSYSTEM_URL+'&task=ajaxCreateFolder&' + KWPSOLARSYSTEMTOKEN;


	$kwp.ajax({
		type: "POST",
		url: myurl,
		data: {
			path: path,
			name: folderName
		}
	}).done(function(code) {
		var result = JSON.parse(code);
		if (result.status == '1') {
			alert(result.message);
			var currentpath = $kwp('.kwpcurrent');
			var code = '';
			if (! currentpath.find('.kwpsubfolder').length) code += '<div class="kwpsubfolder">';
			
			code += '<div class="kwpfoldertree" data-level="' + (parseInt(currentpath.attr('data-level'))+1) + '" data-path="' + path + '/' + folderName + '">'
			+'<div class="kwpfoldertreetoggler" onclick="kwpToggleTreeSub(this)"></div>'
			+'<div class="kwpfoldertreename" onclick="kwpShowFiles(this)"><span class="icon-folder"></span>' + folderName + '<div class="kwpfoldertreecount">0</div>'
			+'</div>'
			+'<div class="kwpfoldertreefiles">'
				+'<div class="kwpfoldertreepathway kwpinterface">'
					+'<span>images</span><span class="kwpfoldertreepath">'+path+'</span><span class="kwpfoldertreepath">' + folderName + '</span>'
									+'<span class="kwpfoldertreepathwayactions">'
						+'<span class="kwpfoldertreepathwayaddfolder kwpbutton" onclick="kwpAddFolder()" style="display: none;">Add a subfolder</span>'
						+'<span class="kwpfoldertreepathwayfoldername kwpshow"><input type="text" class="kwpfoldertreepathwayaddfoldername"></span>'
						+'<span class="kwpfoldertreepathwaycreatefolder kwpbutton kwpshow" onclick="kwpCreateFolder(this, \'' + path + '/' + folderName + '\')">Create folder</span>'
					+'</span>'
								+'</div>'
					+'</div>'
				+'</div>';

			if (! currentpath.find('.kwpsubfolder').length) code += '</div>';
			if (! currentpath.find('.kwpsubfolder').length) {
				$kwp('.kwpcurrent').append(code);
			} else {
				$kwp('.kwpcurrent > .kwpsubfolder').append(code);
			}
		} else if (result.status == '2') {
			alert(result.message);
		} else {
			//alert(CKApi.Text._('CK_FAILED', 'Failed'));
			alert("Failed");
		}
	}).fail(function() {
		//alert(CKApi.Text._('CK_FAILED', 'Failed'));
			alert("Failed");

	});
}

function kwpLoadFiles(btn, type, folder) {
//	console.log('haaaaaaaaaaaaaaaaaamid'+folder+'-'+type);
	if ($kwp(btn).hasClass('kwpdone')) {
			//console.log('haaaaaaaaaaaaaaaaaamid, boro koooooooooooooooooony');

		kwpFocusFolder(btn);
		return;
	}

var myurl = KWPSOLARSYSTEM_URL + '&task=browse.getFiles&' + KWPSOLARSYSTEMTOKEN;
//	var myurl = URIBASE+'/components/com_kwpsolarsystem/src/?task=browse.getFiles&'+ KWPSOLARSYSTEMTOKEN;

		//var myurl = KWPSOLARSYSTEM_URL + '&type=component&component=kwpsolarsystem&task=BrowseController&method=getFiles&'+ KWPTOKEN;
		//index.php?option=com_ajax&type=component&component=kwpsolarsystem&method=getFiles

//	console.log('hamid:haha:'+myurl);
	
	$kwp.ajax({
	type: "POST",
	url: myurl,
	data: {
	folder: folder,
		type: type
		}
	}).done(function(result) {
		if (result) {
			$kwp(btn).find('+ .kwpfoldertreefiles').empty().append(result);
			$kwp(btn).addClass('kwpdone');
		}
		kwpFocusFolder(btn);
	}).fail(function() {
		alert('A problem occured when trying to create the module. Please retry.');
	});
	
/*	
	var ajaxRequest= $.post(myurl, [folder, type], function(data) {
  alert(data);
})
  .fail(function() {
    alert("error");
  })
  .always(function() {
    alert("finished");
});*/
}

function kwpFocusFolder(btn) {
	// set the current state on the folder
	var item = $kwp(btn).parent();
	$kwp('.kwpcurrent').not(btn).removeClass('kwpcurrent');
	if (item.hasClass('kwpcurrent')) {
		item.removeClass('kwpcurrent');
	} else {
		item.addClass('kwpcurrent')
	}
}