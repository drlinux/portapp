$(startAnalytics);

function startAnalytics() {
	//setupGoogleAnalytics("UA-xxxxxx-x");
	//setupPiwikAnalytics(1);
	//setupSitetrack(window.location.hostname);//window.location.hostname, window.location.host, document.domain
}

function setupGoogleAnalytics(code) {
	// google analytics tracking code - use jQuery getScript() to load tracking code after DOM load is complete
	var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
	jQuery.getScript(gaJsHost + "google-analytics.com/ga.js", function() {
		try {
			var pageTracker = _gat._getTracker(code);
			pageTracker._trackPageview();
		} catch (err) {
		}
	});
}

function setupPiwikAnalytics(code) {
	//var pkBaseURL = (("https:" == document.location.protocol) ? "https://localhost/piwik/" : "http://localhost/piwik/");
	var pkBaseURL = "assets/piwik/";
	jQuery.getScript(pkBaseURL + "piwik.js", function() {
		try {
			var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", code);
			piwikTracker.trackPageView();
			piwikTracker.enableLinkTracking();
		} catch (err) {
		}
	});
}


function setupSitetrack(siteDomain)
{
	//var casJsHost = (("https:" == document.location.protocol) ? "https://" : "http://");
	//jQuery.getScript(casJsHost + "localhost/casict/sitetrack.js", function() {
	var casJsHost = (("https:" == document.location.protocol) ? "https://www." : "http://www.");
	jQuery.getScript(casJsHost + "medyaproje.com/casict.com/sitetrack.js", function() {
		try {
			var siteTracker = CAS.getTracker(siteDomain, "7c4a8d09ca3762af61e59520943dc26494f8941b");
			siteTracker.trackPageview();
		} catch (err) {
		}
	});
}