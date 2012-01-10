$(startMailto);

function startMailto() {
	setupMailto();
	setupAnchorExternal();
}

function setupMailto() {
	// make e-mail contact clickable link
	$('span.rtl').each(
			function() {
				var email = $(this).html();
				$(this).html(
						'<a href="mailto:' + email.split('').reverse().join('')
								+ '" rel="nofollow">' + email + '</a>');
			});
}

function setupAnchorExternal() {
	// set external links to 'target=_blank'
	$('a[href^="http://"],a[href^="https://"]').attr("target", "_blank");
}
