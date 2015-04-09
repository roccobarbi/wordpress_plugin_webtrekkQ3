
function wt_scrollposition(conf) {
	if(conf.mode == "page" && conf.type == "after" && conf.requestCounter == 1) {
		var instance=this;var event=((this.wtTypeof(window.onbeforeunload))?"beforeunload":"unload");var de=document.documentElement;var scrollPosition=window.scrollY+window.innerHeight||self.scrollY+self.innerHeight||(de&&de.scrollTop+de.clientHeight)||document.body.scrollTop+document.body.clientHeight;var YMax=window.innerHeight+window.scrollMaxY||self.innerHeight+self.scrollMaxY||(de&&de.scrollHeight)||document.body.offsetHeight;var isScrollPositionSent=false;this.registerEvent(window,'scroll',function(){var Y=window.scrollY+window.innerHeight||self.scrollY+self.innerHeight||(de&&de.scrollTop+de.clientHeight)||document.body.scrollTop+document.body.clientHeight;if(Y>scrollPosition){scrollPosition=Y;}});this.registerEvent(window,event,function(){if(!isScrollPositionSent){isScrollPositionSent=true;scrollPosition=Math.round(scrollPosition/YMax*100);if(scrollPosition>100){scrollPosition=100;}for(;;){if(scrollPosition%5!=0){scrollPosition++;}else{break;}}instance.sendinfo({linkId:"wt_scoll_plugin",customClickParameter:{"540":""+scrollPosition}});}});
	}
};
