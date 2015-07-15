$(function () {
	"use strict";

	$.nette.init();

	$('.dd').nestable({
		maxDepth: 3
	}).on('change', function (event) {
		var list = event.length ? event : $(event.target);
		var output = list.data('output');
		$.nette.ajax({
			url: list.data('ajax-handle'),
			type: 'post',
			data: {
				json: JSON.stringify(list.nestable('serialize'))
			}
		});
	});

	// generuje URL na zaklade zadavaneho titulku
	$('input[data-slug-to]').keyup(function () {
		var slugId = $(this).data('slug-to');
		var val = $(this).val();
		$('#' + slugId).val(make_url(val));
	});

	// přidává config dialog k odkazům s data-confirm atributem
	$('body').on('click', '[data-confirm]', function (e) {
		var question = $(this).data('confirm');
		if (!confirm(question)) {
			e.stopImmediatePropagation();
			e.preventDefault();
		}
	});

	// zbývající počet znaků
	$('[data-countdown-to]').keyup(function () {
		var countdownId = $(this).data('countdown-to');
		var countdownMax = $(this).data('countdown-max');
		var val = $(this).val().length;
		var remaining = countdownMax - val > 0 ? countdownMax - val : 0;
		$('#' + countdownId).html(remaining);
	});

	$(initialize);
	$(document).bind('ajaxSuccess', initialize);
});

function initialize() {

	$('[data-toggle="tooltip"]').tooltip({
		'delay': {show: 700, hide: 100}
	});

	$("#tipsNums").click(function () {
		$("#tipsContent").fadeToggle(500, function () {
		});
	});

	$(".exitTips").click(function (event) {
		event.preventDefault();
		$("#tipsContent").hide();
	});

	$('.dropdown-toggle').click(function () {
		$(this).next('.dropdown-menu').slideToggle(500);
	});

	$('.open-nav').click(function () {
		$('#content').toggleClass('closeMenu');
	});

}

var nodiac = { 'á': 'a', 'č': 'c', 'ď': 'd', 'é': 'e', 'ě': 'e', 'í': 'i', 'ň': 'n', 'ó': 'o', 'ř': 'r', 'š': 's', 'ť': 't', 'ú': 'u', 'ů': 'u', 'ý': 'y', 'ž': 'z' };
/** Vytvoření přátelského URL
 * @param string řetězec, ze kterého se má vytvořit URL
 * @return string řetězec obsahující pouze čísla, znaky bez diakritiky, podtržítko a pomlčku
 * @copyright Jakub Vrána, http://php.vrana.cz/
 */
function make_url(s) {
	s = s.toLowerCase();
	var s2 = '';
	for (var i = 0; i < s.length; i++) {
		s2 += (typeof nodiac[s.charAt(i)] != 'undefined' ? nodiac[s.charAt(i)] : s.charAt(i));
	}
	return s2.replace(/[^a-z0-9_]+/g, '-').replace(/^-|-$/g, '');
}