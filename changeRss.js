function changeRss(rss) {

	var url = window.location.href;
	var i = url.indexOf("?");
	if (i != -1) {
		url = url.substr(0,i);
	}
	window.location.replace(url + "?tag=" + rss);
}
