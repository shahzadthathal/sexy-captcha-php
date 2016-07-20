/*
 * Sexy Captcha v.0.2
 * Designed and developed by: BWM Media (bwmmedia.com)
 */
(function($) {
	$.fn.sexyCaptcha = function(url,divID) {
		
		divID = typeof divID !== 'undefined' ? divID : 'captchaWrapper';
		//alert(url);
		urlOld=url;
		url=url+'&divID='+divID;
		//alert(url);
		this.each(function() {
			$(this).load(url, { action: 'refresh' }, function() {
				$('.draggable').draggable({ containment: 'parent', snap: '.target', snapMode: 'inner', snapTolerance: 35, revert: 'invalid', opacity: 0.75});
				$('.target').droppable({ accept: '.draggable', tolerance: 'intersect' });
	
				//On drop of draggable object
				$('.target').bind('drop', function(event, ui) {
					$('#'+divID).find('.captchaAnswer').val($(ui.draggable).attr('id'));
					$('#'+divID).find('.draggable').draggable('disable');
					$('#'+divID).find('.draggable').unbind('click');
					$('#'+divID).find('.targetWrapper').children('.target').hide();
	
					//Check captcha answer
					$.post(url, { action: 'verify', captcha: $(ui.draggable).attr('id') }, function(data) {
						if (data.status == "success") {
							$('#'+divID).find('.targetWrapper').addClass('captchaSuccess').hide().fadeIn('slow');
						} else {
							$('#'+divID).find('.targetWrapper').addClass('captchaFail').hide().fadeIn('slow');
						}
					}, 'json');
				});
				
				//On double-click of object
				$('.draggable').bind('click', function(event, ui) {
					$('#'+divID).find('.captchaAnswer').val($(this).attr('id'));
					$('#'+divID).find('.draggable').draggable('disable');
					$('#'+divID).find('.draggable').unbind('click');
					$('#'+divID).find('.targetWrapper').children('.target').hide();
					$(this).removeClass('draggable');
					$(this).addClass('target');
					$('#'+divID).find('.targetWrapper').html($(this));
					//$(this).hide();
	
					//Check captcha answer
					$.post(url, { action: 'verify', captcha: $(this).attr('id') }, function(data) {
						if (data.status == "success") {
							$('#'+divID).find('.targetWrapper').addClass('captchaSuccess').hide().fadeIn('slow');
						} else {
							$('#'+divID).find('.targetWrapper').addClass('captchaFail').hide().fadeIn('slow');
						}
					}, 'json');
				});
				
				//Redraw captcha
				$('.captchaRefresh').click(function() {
					$('#'+divID).sexyCaptcha(urlOld,divID);
					
					return false;
				});
			});
		});

		return this;
	};
})(jQuery);
