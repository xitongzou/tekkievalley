//	NOTES - ok to delete
//	AddSite= this will be the url to the social bookmarking site for adding bookmarks
//	AddUrlVar= variable for URL
//	AddTitleVar= variable for TITLE
//	AddNote= the notes or description of the page - we're using the title for this when it's used
//	AddReturn= so far, one site requires a return url to be passed
//	AddOtherVars= some social bookmarking sites require other variables and their values to be passed - if any exist, they'll be set to this var
//	AddToMethod	= [0=direct,1=popup]

var txtVersion = "0.1";
var addtoInterval = null;
var popupWin = '';

// Add To Bookmarks Layout Style
switch(addtoLayout){
	case 0:		// horizontal, 1 row
document.write('<div class="addToContent"><dl class="addTo"><dd><span title="Learn about Social Bookmarking" class="addToAbout" onclick');
document.write('="addto(0)">ADD TO:</span></dd><dd><span title="Add this page to Blink"  onclick="addto(1)"><img src="modules/bookmarks/AddTo_Blin');
document.write('k.gif" width="16" height="16" border="0" />Blink</span></dd><dd><span title="Add this page to Delicious" onclick="addto');
document.write('(2)"><img src="modules/bookmarks/AddTo_Delicious.gif" width="16" height="16" border="0" />Del.icio.us</span></dd><dd><span title="');
document.write('Add this page to Digg" onclick="addto(3)"><img src="modules/bookmarks/AddTo_Digg.gif" width="16" height="16" border="0" />Digg</spa');
document.write('n></dd><dd><span title="Add this page to Furl" onclick="addto(4)"><img src="modules/bookmarks/AddTo_Furl.gif" width="16" height="1');
document.write('6" border="0" />Furl</span></dd><dd><span title="Add this page to Google" onclick="addto(5)"><img src="modules/bookmarks/AddTo_Goo');
document.write('gle.gif" width="16" height="16" border="0" />Google</span></dd><dd><span title="Add this page to Simpy" onclick="addto(');
document.write('6)"><img src="modules/bookmarks/AddTo_Simpy.gif" width="16" height="16" border="0" />Simpy</span></dd><dd><span title="Add this pa');
document.write('ge to Spurl" onclick="addto(8)"><img src="modules/bookmarks/AddTo_Spurl.gif" width="16" height="16" border="0" />Spurl</span></dd>');
document.write('<dd><span title="Add this page to Yahoo! MyWeb" onclick="addto(7)"><img src="modules/bookmarks/AddTo_Yahoo.gif" width="16" height="');
document.write('16" border="0" />Y! MyWeb</span></dd></dl></div>');	
	break
	case 1:		// horizontal, 2 rows
document.write('<div class="addToContent"><div class="addTo2Row"><div class="addToHeader" onclick="addto(0)">ADD THIS TO YOUR SOCIAL BO');
document.write('OKMARKS</div><div class="addToFloat"><span title="Add this page to Blink"  onclick="addto(1)"><img src="modules/bookmarks/AddTo_Bl');
document.write('ink.gif" width="16" height="16" border="0" /> Blink</span><br /><span title="Add this page to Delicious" onclick="addto');
document.write('(2)"><img src="modules/bookmarks/AddTo_Delicious.gif" width="16" height="16" border="0" /> Del.icio.us</span></div><div class="add');
document.write('ToFloat"><span title="Add this page to Digg" onclick="addto(3)"><img src="modules/bookmarks/AddTo_Digg.gif" width="16" height="16" ');
document.write('border="0" /> Digg</span><br /><span title="Add this page to Furl" onclick="addto(4)"><img src="modules/bookmarks/AddTo_Furl.gif" ');
document.write('width="16" height="16" border="0" /> Furl</span></div><div class="addToFloat"><span title="Add this page to Google" onc');
document.write('lick="addto(5)"><img src="modules/bookmarks/AddTo_Google.gif" width="16" height="16" border="0" /> Google</span><br /><span title=');
document.write('"Add this page to Simpy" onclick="addto(6)"><img src="modules/bookmarks/AddTo_Simpy.gif" width="16" height="16" border="0" />Simpy<');
document.write('/span></div><div class="addToFloat"><span title="Add this page to Spurl" onclick="addto(8)"><img src="modules/bookmarks/AddTo_Spur');
document.write('l.gif" width="16" height="16" border="0" />Spurl</span><br /><span title="Add this page to Yahoo! MyWeb" onclick="addto');
document.write('(7)"><img src="modules/bookmarks/AddTo_Yahoo.gif" width="16" height="16" border="0" /> Y! MyWeb</span><br /></div></div></div>');
	break	
	case 2:		// vertical with icons
document.write('<div class="addToContent"><dl class="addToV"><dd><span title="Learn about Social Bookmarking" class="addToAbout" onclic');
document.write('k="addto(0)">ADD TO:</span></dd><dd><span title="Add this page to Blink"  onclick="addto(1)"><img src="modules/bookmarks/AddTo_Bli');
document.write('nk.gif" width="16" height="16" border="0" />Blink</span></dd><dd><span title="Add this page to Delicious" onclick="addt');
document.write('o(2)"><img src="modules/bookmarks/AddTo_Delicious.gif" width="16" height="16" border="0" />Del.icio.us</span></dd><dd><span title=');
document.write('"Add this page to Digg" onclick="addto(3)"><img src="modules/bookmarks/AddTo_Digg.gif" width="16" height="16" border="0" />Digg</sp');
document.write('an></dd><dd><span title="Add this page to Furl" onclick="addto(4)"><img src="modules/bookmarks/AddTo_Furl.gif" width="16" height="');
document.write('16" border="0" />Furl</span></dd><dd><span title="Add this page to Google" onclick="addto(5)"><img src="modules/bookmarks/AddTo_Go');
document.write('ogle.gif" width="16" height="16" border="0" />Google</span></dd><dd><span title="Add this page to Simpy" onclick="addto');
document.write('(6)"><img src="modules/bookmarks/AddTo_Simpy.gif" width="16" height="16" border="0" />Simpy</span></dd><dd><span title="Add this p');
document.write('age to Spurl" onclick="addto(8)"><img src="modules/bookmarks/AddTo_Spurl.gif" width="16" height="16" border="0" />Spurl</span></dd>');
document.write('<dd><span title="Add this page to Yahoo! MyWeb" onclick="addto(7)"><img src="modules/bookmarks/AddTo_Yahoo.gif" width="16" height=');
document.write('"16" border="0" />Y! MyWeb</span></dd></dl></div>');
	break	
	case 3:		// vertical no icons
document.write('<div class="addToContent"><dl class="addToVNoImg"><dd><span title="Learn about Social Bookmarking" class="addToAbout" o');
document.write('nclick="addto(0)">ADD TO:</span></dd><dd><span title="Add this page to Blink" onclick="addto(1)">Blink</span></dd><dd>');
document.write('<span title="Add this page to Delicious" onclick="addto(2)">Del.icio.us</span></dd><dd><span title="Add this page to Di');
document.write('gg" onclick="addto(3)">Digg</span></dd><dd><span title="Add this page to Furl" onclick="addto(4)">Furl</span></dd><dd>');
document.write('<span title="Add this page to Google" onclick="addto(5)">Google</span></dd><dd><span title="Add this page to Simpy" onc');
document.write('lick="addto(6)">Simpy</span></dd><dd><span title="Add this page to Spurl" onclick="addto(8)">Spurl</span></dd><dd><spa');
document.write('n title="Add this page to Yahoo! MyWeb" onclick="addto(7)">Y! MyWeb</span></dd></dl></div>');
	break		
	default:	
}
function addtoWin(addtoFullURL)
{
	if (!popupWin.closed && popupWin.location){
		popupWin.location.href = addtoFullURL;
		var addtoInterval = setInterval("closeAddTo();",1000);
	}
	else{
		popupWin = window.open(addtoFullURL,'addtoPopUp','width=770px,height=500px,status=0,location=0,resizable=1,scrollbars=1,left=0,top=100');
		var addtoInterval = setInterval("closeAddTo();",1000);
		if (!popupWin.opener) popupWin.opener = self;
	}
	if (window.focus) {popupWin.focus()}
	return false;
}
// closes the popupWin
function closeAddTo() {
	if (!popupWin.closed && popupWin.location){
		if (popupWin.location.href == AddURL)	//if it's the same url as what was bookmarked, close the win
		popupWin.close();
	}
	else {	//if it's closed - clear the timer
		clearInterval(addtoInterval)
		return true
	}
}
//main addto function - sets the variables for each Social Bookmarking site
function addto(addsite){
	switch(addsite){
		case 0:
			var AddSite = "http://www.clip-share.com/?";
			var AddUrlVar = "url";
			var AddTitleVar = "title";
			var AddNoteVar = "";
			var AddReturnVar = "";
			var AddOtherVars = "";	
			break	
		case 1:	//	Blink ID:1
			var AddSite = "http://www.blinklist.com/index.php?Action=Blink/addblink.php";
			var AddUrlVar = "url";
			var AddTitleVar = "title";
			var AddNoteVar = "description";
			var AddReturnVar = "";
			var AddOtherVars = "&Action=Blink/addblink.php";	
			break
		case 2:	//	Del.icio.us	ID:2 &v=3&noui=yes&jump=close
			var AddSite = "http://del.icio.us/post?";
			var AddUrlVar = "url";
			var AddTitleVar = "title";
			var AddNoteVar = "";
			var AddReturnVar = "";
			var AddOtherVars = "";		
			break
		case 3:	//	Digg ID:3
			var AddSite = "http://digg.com/submit?";
			var AddUrlVar = "url";
			var AddTitleVar =  "";
			var AddNoteVar =  "";
			var AddReturnVar =  "";
			var AddOtherVars = "&phase=2";
			break
		case 4:	//	Furl ID:4
			var AddSite = "http://www.furl.net/storeIt.jsp?";
			var AddUrlVar = "u";
			var AddTitleVar = "t";
			var AddNoteVar = "";
			var AddReturnVar = "";
			var AddOtherVars = "";	
			break
		case 5:	//	GOOGLE ID:5
			var AddSite = "http://fusion.google.com/add?";
			var AddUrlVar = "feedurl";
			var AddTitleVar = "";
			var AddNoteVar = "";
			var AddReturnVar = "";
			var AddOtherVars = "";
			break
		case 6:	//	Simpy ID:6
			var AddSite = "http://simpy.com/simpy/LinkAdd.do?";
			var AddUrlVar = "href";
			var AddTitleVar = "title";
			var AddNoteVar = "note";
			var AddReturnVar = "_doneURI";
			var AddOtherVars = "&v=6&src=bookmarklet";
			break
		case 7:	//	Yahoo ID: 7
			var AddSite = "http://myweb2.search.yahoo.com/myresults/bookmarklet?";
			var AddUrlVar = "u";
			var AddTitleVar = "t";
			var AddNoteVar = "";
			var AddReturnVar = "";
			var AddOtherVars = "&d=&ei=UTF-8";
			break
		case 8:	//	Spurl ID: 8 	d.selection?d.selection.createRange().text:d.getSelection()
			var AddSite = "http://www.spurl.net/spurl.php?";
			var AddUrlVar = "url";
			var AddTitleVar = "title";
			var AddNoteVar = "blocked";
			var AddReturnVar = "";
			var AddOtherVars = "&v=3";
			break			
		default:
	}
//	Build the URL
	var addtoFullURL = AddSite + AddUrlVar + "=" + AddURL + "&" + AddTitleVar + "=" + AddTitle + AddOtherVars ;
	if (AddNoteVar != "") 
		{var addtoFullURL = addtoFullURL + "&" + AddNoteVar + "=" + AddTitle;}
	if (AddReturnVar != "")
		{var addtoFullURL = addtoFullURL + "&" + AddReturnVar + "=" + AddURL;}
//	Checking AddToMethod, to see if it opens in new window or not
	switch(addtoMethod){
		case 0:	// 0=direct link
			self.location = addtoFullURL
			break
		case 1:	// 1=popup
			addtoWin(addtoFullURL);
			break
		default:	
		}
		return true;
}
//	checking across domains causes errors - this is to supress these
function handleError() {return true;}
window.onerror = handleError;