/**
 * zousu.com 2011
 * Controls Tab Clicks and activates the appropriate tab
 */
var activeContent = null;
var activeTab = null;
function show(tab, contentId){
	//hide the last one
	if(activeContent){
		activeTab.className = "";
		activeContent.className="content";
	}
	activeContent = document.getElementById(contentId);
	activeTab = tab;
	activeTab.className = "current";
	activeContent.className ="content current";
	return false;
}


window.onload = function() {  
  show(document.getElementById("tab-1"), "content-1");
};