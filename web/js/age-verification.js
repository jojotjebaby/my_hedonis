/*!
 * Simple Age Verification (https://github.com/Herudea/age-verification))
 */

var modal_content,
modal_screen;

// Start Working ASAP.
$(document).ready(function() {
	av_legality_check();
});


av_legality_check = function() {
	if ($.cookie('is_legal') == "yes") {
		// legal!
		// Do nothing?
	} else {
		av_showmodal();

		// Make sure the prompt stays in the middle.
		$(window).on('resize', av_positionPrompt);
	}
};

av_showmodal = function() {
	modal_screen = $('<div id="modal_screen"></div>');
	modal_content = $('<div id="modal_content" style="display:none"></div>');
	var modal_content_wrapper = $('<div id="modal_content_wrapper" class="content_wrapper"></div>');
	var modal_regret_wrapper = $('<div id="modal_regret_wrapper" class="content_wrapper" style="display:none;"></div>');

	// Question Content
	var content_heading = $('<h2>Ben jij + 18 ?</h2>');
	var content_buttons = $('<nav><ul><li><a href="#nothing" class="av_btn av_no" rel="no"><img src="../img/age/1.png" style="height:80px;width:80px;"><h2 class="imgDescription"> -18 jaar</h2>Kid</a></li><li><a href="#nothing" class="av_btn av_go" rel="yes"><img src="../img/age/2.png" style="height:80px;width:80px;"><h2 class="imgDescription"> +18 jaar</h2>adult</a></li><li><a href="#nothing" class="av_btn av_go" rel="yes"><img src="../img/age/3.png" style="height:80px;width:80px;"><h2 class="imgDescription"> Beer Geek</h2>Beer Geek</a></li><li><a href="#nothing" class="av_btn av_no" rel="no"><img src="../img/age/4.png" style="height:80px;width:80px;"><h2 class="imgDescription"> Hond</h2>Hond</a></li></nav');
	var content_text = $('<p>Je moet minimum 18 jaar zijn om deze pagina te kunnen bekijken.</p>');

	// Regret Content
	var regret_heading = $('<h2>Sorry!</h2>');
	var regret_buttons = $('<nav><small>Ik heb op de verkeerde knop gedrukt ! </small> <ul><li><a href="#nothing" class="av_btn av_go" rel="yes">Ik ben oud genoeg!</a></li></ul></nav');
	var regret_text = $('<p>Je moet minimum 18 jaar zijn om deze pagina te kunnen bekijken.</p>');

	modal_content_wrapper.append(content_heading, content_buttons, content_text);
	modal_regret_wrapper.append(regret_heading, regret_text);
	modal_content.append(modal_content_wrapper, modal_regret_wrapper);

	// Append the prompt to the end of the document
	$('body').append(modal_screen, modal_content);

	// Center the box
	av_positionPrompt();

	modal_content.find('a.av_btn').on('click', av_setCookie);
};

av_setCookie = function(e) {
	e.preventDefault();

	var is_legal = $(e.currentTarget).attr('rel');

	$.cookie('is_legal', is_legal, {
		expires: 0.1,
		path: '/'
	});

	if (is_legal == "yes") {
		av_closeModal();
		$(window).off('resize');
	} else {
		av_showRegret();
	}
};

av_closeModal = function() {
	modal_content.fadeOut();
	modal_screen.fadeOut();
};

av_showRegret = function() {
	modal_screen.addClass('nope');
	modal_content.find('#modal_content_wrapper').hide();
	modal_content.find('#modal_regret_wrapper').show();
};

av_positionPrompt = function() {
	var top = ($(window).outerHeight() - $('#modal_content').outerHeight()) / 2;
	var left = ($(window).outerWidth() - $('#modal_content').outerWidth()) / 2;
	modal_content.css({
		'top': top,
		'left': left
	});

	if (modal_content.is(':hidden') && ($.cookie('is_legal') != "yes")) {
		modal_content.fadeIn('slow')
	}
};