function flyspeckmain() {
	var logindiv = document.createElement('div');
	logindiv.id = 'flyspeck_logindiv';
	try {
		insertAfter(logindiv, document.getElementById('flyspecktrigger'));
	}catch(err){

	}
	ajax({url:this.flyhome+'/index.php?event=displaylogin&fileName='+document.location.pathname, method: 'get', onSucess:hitch(this,'handleAuth')});
}

function authenticate(){
	var postBodyString = 'flyspeckUserName='+$('flyspeckUserName').value+'&flyspeckPassWord='+$('flyspeckPassWord').value+'&fileName='+document.location.pathname;
	ajax({url:this.flyhome+'/index.php?event=authenticate', postBody:postBodyString, method:'post', onSucess:hitch(this,'handleAuth')});
}

function logoutfly(){
	ajax({url:this.flyhome+'/index.php?event=logOut', postBody:'logout=true', method:'post', onSucess:refresh});
}

function refresh(){
	document.location.reload(true);
}

function handleAuth(req){
	eval("var j = ("+req.responseText+")");
	var box = document.getElementById('flyspeck_logindiv');
	box.innerHTML = '';
	var newdiv = document.createElement("div");
	newdiv.innerHTML = j.form;
	box.appendChild(newdiv);
	if (j.hasErrors === true){
		$('flyspeck_loginmenu').style.display = 'block';
	}
	if (j.isLoggedIn === true && j.hasCreds === true){
		this.processBody();
	}
}

function findFlyHome(url){
	var pos = url.lastIndexOf('/');
	var flyhome = url.substring(0, pos);
	return flyhome;
}

function processBody(){
	var b4renderhtml = document.body.innerHTML;
	document.body.innerHTML = '';
	var wholediv = document.createElement('div');
	wholediv.id = 'wholeDiv';
	document.body.insertBefore(wholediv, document.body.firstChild);

	var contentdiv = document.createElement('div');
	contentdiv.id = 'flycontentdiv';
	insertAfter(contentdiv, $('wholeDiv'));
	contentdiv.innerHTML = b4renderhtml;

	var flytoolbardiv = document.createElement('div');
	flytoolbardiv.id = 'flytoolbar';
	wholediv.appendChild(flytoolbardiv);

	var toolbardiv = document.createElement('div');
	toolbardiv.id = 'xToolbar';
	wholediv.appendChild(toolbardiv);

	var postBodyString = 'filename='+escape(this.filename);
    ajax({url:this.flyhome+'/index.php?event=processHeader', postBody:postBodyString, method:'post', onSucess:headLoaded});
	document.body.innerHTML = document.body.innerHTML.replace(/<!-- #BeginEdit "(.*)" (.*)-->/g, '<div class="flyzone" id="flyzone-$1" $2>').replace(/<!-- #EndEdit -->/g, '</div>');
	setTimeout('', 1000);
	var flyzones = getElementsByClass('flyzone',document.body,'div');
	for(var i=0; i<flyzones.length; i++){
	var id = flyzones[i].id;
	var flynode = $(id);
	var fck = new FCKeditor('flyzone-'+id);

		for(var p=0, len=flynode.attributes.length; p<len; p++){
		var node = flynode.attributes[p];
			if(node.nodeName == 'height' || node.nodeName == 'width'){
			var prop = node.nodeName.substr(0, 1).toUpperCase() + node.nodeName.substr(1);
			var value = node.nodeValue;
			fck[prop] = value;
			}
		}
		fck.BasePath = this.flyhome + "/includes/fckeditor/";
		fck.ToolbarSet = "Flyspeck";
		fck.Config.CustomConfigurationsPath = this.flyhome + "/includes/FlyspeckFckconfig.js";
		fck.Config.EditorAreaCSS = getAllSheets().join(',');
		fck.Value = flyzones[i].innerHTML;
		flyzones[i].innerHTML = fck.CreateHtml();
	}

	return;
}

function headLoaded(req){
	$('flytoolbar').innerHTML = req.responseText;
	$('fly_title').value = document.title;
	$('fly_meta_key').innerHTML = getMetaTagContent('keywords');
	$('fly_meta_desc').innerHTML = getMetaTagContent('description');
	JSFX_FloatDiv("wholeDiv", 0, 0).floatIt();
}

function getMetaTagContent(name){
var coll = document.getElementsByTagName("meta");
for (i=0;i<coll.length;i++) {
	if (coll[i].name == name){
		return (coll[i].content) ? coll[i].content : '';
	}
}
return '';
}

function bodyLoaded(req){
	$('contentdiv').innerHTML = req.responseText;
}

function saveContent(){
	var sandrs = [];
	for(var i=0; i<this.editorinstances.length; i++){
		var sandr = {};
		var oEditor = FCKeditorAPI.GetInstance(this.editorinstances[i]);
		var id = oEditor.Name;
		var editedHTML = oEditor.GetHTML();
		sandr.id = id;
		sandr.editedHTML = editedHTML;
		sandrs.push(sandr);
	}
	var postBodyString = '';
	for(var j=0; j<sandrs.length; j++){
		postBodyString += 'sandrs['+sandrs[j].id+']='+escape(sandrs[j].editedHTML)+'&';
	}
	if($('fly_title')){
	postBodyString += 'title=' + escape($('fly_title').value);
	}
	if ($('fly_meta_key')){
	postBodyString += '&meta_key=' + escape($('fly_meta_key').value);
	}
	if ($('fly_meta_desc')){
	postBodyString += '&meta_desc=' + escape($('fly_meta_desc').value);
	}
	postBodyString += '&fileName=' + document.location.pathname;
	ajax({url:this.flyhome+'/index.php?event=saveContent', postBody:postBodyString, onSucess:notifyResult});
}

function notifyResult(req){
	eval("var j = ("+req.responseText+")");
	try{
	$('flyspeck_logindiv').innerHTML = j.form;
	notifbefore = $('flyNotifications').innerHTML;
	var ihml = $('ajaxnotif').innerHTML;
	$('ajaxnotif').innerHTML = '';
	$('flyNotifications').innerHTML = ihml;
	if (j.hasErrors === true){
		$('flyspeck_loginmenu').style.display = 'block';
		$('ajaxnotif').style.display = 'block';
	}
	setTimeout("opacity('ajaxnotif', 100, 0, 1000);opacity('fly-ajaxnotice', 100, 0, 1000);$('flyNotifications').innerHTML = notifbefore" , 3500);
	} catch (err){
	}
}
function renderPreviewBody(req){
	previewwin = window.open('');
	previewwin.document.write(req.responseText);
	previewwin.document.close();
	return true;
    document.body.appendChild(contentdiv);
	insertAfter(logindiv, contentdiv);
	var css_sheets = getAllSheets();
	var css_post = '';
	for(var i=0; i<css_sheets.length; i++){
		if (!instring(css_sheets[i], "flyspeck_loginmenu_css")) {
			css_post += css_sheets[i];
		}
	}
	var postBodyString = 'filename='+escape(this.filename)+'&css='+escape(css_post);
}

function previewContent(){
$('wholeDiv').style.display = 'none';
$('flycontentdiv').style.margin = '0px';
$('flyspeck_loginmenu').style.display = 'none';
	var exitdiv = document.createElement('div');
	exitdiv.id = 'exitdiv';
	exitdiv.onmouseover = function(){$('exitpreview').style.width = '230px';$('exitpreview').style.height = '20px';$('returnmsg').innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;Return to Editing Mode'};
	exitdiv.onmouseout = function(){$('exitpreview').style.width = '';$('exitpreview').style.height = '';$('returnmsg').innerHTML = ''};
	exitdiv.innerHTML = '<a href="javascript:flyspeckGenerator.exitPreview()" id="exitpreview"><span id="returnmsg"></span></a>';
	document.body.insertBefore(exitdiv, document.body.firstChild);
JSFX_FloatDiv("exitdiv", 10, 10).floatIt();
	for(var i=0; i<this.editorinstances.length; i++){
		var oEditor = FCKeditorAPI.GetInstance(this.editorinstances[i]);
		var html = oEditor.GetHTML();
		var flyframe = $(this.editorinstances[i] + '___Frame');
		flyframe.style.display = 'none';
		var flyzoneid = this.editorinstances[i].replace('flyzone-', '');
		var contentdiv = document.createElement('div');
		contentdiv.className = 'tempt';
		contentdiv.innerHTML = html;
		$(flyzoneid).appendChild(contentdiv);
	}
	return;
}


function exitPreview(){
$('wholeDiv').style.display = '';
$('flycontentdiv').style.margin = '';
removeNode($('exitdiv'));
var tempts = getElementsByClass('tempt',document.body,'div');
 	for(var i=0; i<this.editorinstances.length; i++){
		removeNode(tempts[i]);
	}
	for(var i=0; i<this.editorinstances.length; i++){
		var flyframe = $(this.editorinstances[i] + '___Frame');
		flyframe.style.display = '';
		var flyzoneid = this.editorinstances[i].replace('flyzone-', '');
	}

}

function insertAfter(new_node, existing_node) {
// if the existing node has a following sibling, insert the current
// node before it.  otherwise appending it to the parent node
 // will correctly place it just after the existing node.
 if (existing_node.nextSibling) {
 // there is a next sibling.  insert before it using the mutual
 // parent's insertBefore() method.
 existing_node.parentNode.insertBefore(new_node, existing_node.nextSibling);
 } else {
 // there is no next sibling. append to the end of the parent's
 // node list.
 var e = existing_node.parentNode.appendChild(new_node);
 }
}

function removeNode(node){
    element = $(node);
    element.parentNode.removeChild(element);
    return element;
}

function getElementsByClass(searchClass,node,tag) {
	var classElements = [];
	if ( node == null ) {
		node = document;
	}
	if ( tag == null ){
		tag = '*';
	}
	var els = node.getElementsByTagName(tag);
	var elsLen = els.length;
	var pattern = new RegExp('(^|\\\\s)'+searchClass+'(\\\\s|$)');
	for (i = 0, j = 0; i < elsLen; i++) {
		if ( pattern.test(els[i].className) ) {
			classElements[j] = els[i];
			j++;
		}
	}
	return classElements;
}

function hitch(obj, meth) {
  return function() { return obj[meth].apply(obj, arguments); };
}

function FCKeditor_OnComplete( editorInstance ) {
	if (flyspeckGenerator.editorinstances == undefined){
		flyspeckGenerator.editorinstances = [];
		flyspeckGenerator.editorinstances.push(editorInstance.Name);
	} else {
		flyspeckGenerator.editorinstances.push(editorInstance.Name);
	}
}

var iBusy = 0;
//document.write("<div id='ajaxBusy' style='display:none; border:3px solid #000099; position:absolute; top:0; right:0; background-color:#0000FF; color:#FFFFFF; padding:6px; font-weight:bold;'>&nbsp;&nbsp;&nbsp;Loading . . .&nbsp;&nbsp;&nbsp;</div>");

function ajax(parameters) {
	var myObj = eval(parameters);
	if(!myObj.url){	alert('Missing URL');}
	if(!myObj.method){myObj.method="post";}
	if(!myObj.postBody){ myObj.postBody="y=y";}
	if(!myObj.fillDiv){ myObj.fillDiv="";}
	if(!myObj.onSucess){ myObj.onSucess=defaultSucess; }
	if(!myObj.onFailure){ myObj.onFailure=defaultFailure; }
	if(!myObj.showBusy){ myObj.showBusy=false; }
	if(!myObj.busyDiv){	myObj.busyDiv=""; }
	var req = createRequest();
	req.onreadystatechange = function() {returnFunction(req,parameters);};
	if(myObj.method == "get") {
		req.open("GET", myObj.url, true);
		req.send(null);
	} else {
		req.open("POST", myObj.url, true);
		req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
		req.setRequestHeader('Referer', window.document.location);
		req.send(myObj.postBody);
	}
	if(myObj.busyDiv != "") { $(myObj.busyDiv).style.display = 'block';	}
	if (myObj.showBusy === true) {
		iBusy++;
		$('ajaxBusy').style.display = 'block';
	}
}

function returnFunction(req,parameters) {
	var myObj = eval(parameters);
	if (req.readyState == 4) {
		if(myObj.busyDiv != "") {
			$(myObj.busyDiv).style.display = 'none';
			}
		if (myObj.showBusy === true) {
			iBusy--;
			if(iBusy < 1) {
				$('ajaxBusy').style.display = 'none';
			}
		}
		try {
			if (req.status == 200) {
				if(myObj.fillDiv != "") {
					$(myObj.fillDiv).innerHTML = req.responseText;
				} else {
					myObj.onSucess(req);
				}
			} else {
				myObj.onFailure(req);
			}
		} catch(err) {
		}
	}
}

function defaultSucess(req) {
	// Empty. There are times you don't want to notify the user of completion.
}

function defaultFailure(req) {
	// Empty. There are times you don't want to notify the user of completion.
}

function createRequest() {
	var request = null;
	try {request = new XMLHttpRequest();}
	catch (trymicrosoft) {
		try {request = new ActiveXObject("Msxml2.XMLHTTP");}
		catch (othermicrosoft) {
			try {request = new ActiveXObject("Microsoft.XMLHTTP");}
			catch (failed) {request = null;}
			}
		}
	if (request === null) {
	alert("Error creating request object!");
	} else {return request;}
}

function $() {
	var elements = [];
	for (var i = 0; i < arguments.length; i++) {
		var element = arguments[i];
		if (typeof element == 'string'){
			element = document.getElementById(element);
		}
		if (arguments.length == 1){
			return element;
		}
		elements.push(element);
	}
	return elements;
}

function openW(mypage,myname,w,h,features) {
	if(screen.width){
		var winl = (screen.width-w)/2;
		var wint = (screen.height-h)/2;
	}else{winl = 0;wint =0;}
		if (winl < 0) winl = 0;
		if (wint < 0) wint = 0;
	var settings = 'height=' + h + ',';
	settings += 'width=' + w + ',';
	settings += 'top=' + wint + ',';
	settings += 'left=' + winl + ',';
	settings += features;
	win = window.open(mypage,myname,settings);
	win.window.focus();
}

function switchMenu() {
	var theDiv = document.getElementById('flyspeck_loginmenu');
	if(theDiv.style.display == "none") {
		theDiv.style.display = "block";
	} else {
		theDiv.style.display = "none";
	}

}

function opacity(id, opacStart, opacEnd, millisec) {
    //speed for each frame
    var speed = Math.round(millisec / 100);
    var timer = 0;

    //determine the direction for the blending, if start and end are the same nothing happens
    if(opacStart > opacEnd) {
        for(i = opacStart; i >= opacEnd; i--) {
            setTimeout("changeOpac(" + i + ",'" + id + "')",(timer * speed));
            timer++;
        }
    } else if(opacStart < opacEnd) {
        for(i = opacStart; i <= opacEnd; i++){
            setTimeout("changeOpac(" + i + ",'" + id + "')",(timer * speed));
            timer++;
        }
    }
}

//change the opacity for different browsers
function changeOpac(opacity, id) {
    var object = document.getElementById(id).style;
    object.opacity = (opacity / 100);
    object.MozOpacity = (opacity / 100);
    object.KhtmlOpacity = (opacity / 100);
    object.filter = "alpha(opacity=" + opacity + ")";
}

function include_css(css_file) {
    var html_doc = document.getElementsByTagName('head')[0];
    css = document.createElement('link');
    css.setAttribute('rel', 'stylesheet');
    css.setAttribute('type', 'text/css');
    css.setAttribute('href', css_file);
	css.id = 'flyspeck-css';
    html_doc.appendChild(css);

    // alert state change
    css.onreadystatechange = function () {
        if (css.readyState == 'complete') {
           // alert('CSS onreadystatechange fired');
        }
    };
    css.onload = function () {
       // alert('CSS onload fired');
    };
    return false;
}


function include_js(file) {
    var html_doc = document.getElementsByTagName('head')[0];
    js = document.createElement('script');
    js.setAttribute('type', 'text/javascript');
    js.setAttribute('src', file);
    html_doc.appendChild(js);

    // alert state change
    js.onreadystatechange = function () {
        if (js.readyState == 'complete') {
            // safe to call a function
            // found in the new script
        }
    }
    return false;
}

 function instring (string, pattern) {
   return string.indexOf(pattern) > -1;
 }

function getAllSheets() {
  if( document.getElementsByTagName ) {
    //DOM browsers - get link and style tags
    var Lt = document.getElementsByTagName('link');
    var St = document.getElementsByTagName('style');
  } else { return []; }
  for( var x = 0, os = []; Lt[x]; x++ ) {
    //check for the rel attribute to see if it contains 'style'
    if( Lt[x].rel ) { var rel = Lt[x].rel;
    } else if( Lt[x].getAttribute ) { var rel = Lt[x].getAttribute('rel');
    } else { var rel = ''; }
    if( typeof( rel ) == 'string' && rel.toLowerCase().indexOf('style') + 1 ) {
if (Lt[x].getAttribute('media') == 'print') { continue; }
	   if (!instring(Lt[x].href, "http")){
	   	//prepend for IE.
		var href = location.protocol+"//"+location.hostname + findFlyHome(window.location.pathname) + "/" + Lt[x].href;
	   } else {
	   	var href = Lt[x].href;
	   }
      //fill os with linked stylesheets
      os[os.length] = href;
    }
  }
  //include all style tags too and return the array
  return os;
}

function fire(){
 flyspeckGenerator = new flyspeckGeneratorObj;
}



function addEvent(elm, evType, fn, useCapture) {
	if (elm.addEventListener) {
		elm.addEventListener(evType, fn, useCapture);
		return true;
	}
	else if (elm.attachEvent) {
		var r = elm.attachEvent('on' + evType, fn);
		return r;
	}
	else {
		elm['on' + evType] = fn;
	}
}

var flyspeckGeneratorObj = function() {
  this.editorinstances = [];
  this.filename=window.location.pathname;
  this.flyspeckmain=flyspeckmain;
  this.flyhome = findFlyHome($('flytrig').src);
  this.authenticate=authenticate;
  this.handleAuth = handleAuth;
  this.logoutfly=logoutfly;
  this.processBody=processBody;
  this.saveContent=saveContent;
  this.previewContent=previewContent;
  this.exitPreview=exitPreview;
  this.renderPreviewBody=renderPreviewBody;
  include_js(this.flyhome + '/includes/fckeditor/fckeditor.js');
  include_css(this.flyhome+'/includes/flyspeck_loginmenu_css.php');
  this.flyspeckmain();
};

function JSFX_FloatDiv(id, sx, sy)
{
	var el=document.getElementById(id);
	var px = document.layers ? "" : "px";
	window[id + "_obj"] = el;
	el.cx = el.sx = sx;el.cy = el.sy = sy;
	el.sP=function(x,y){this.style.left=x+px;this.style.top=y+px;};
	el.floatIt=function()
	{
		var pX, pY;
		pX = (this.sx >= 0) ? 0 : document.documentElement && document.documentElement.clientWidth ?
		document.documentElement.clientWidth : document.body.clientWidth;
		pY = document.documentElement && document.documentElement.scrollTop ?
		document.documentElement.scrollTop : document.body.scrollTop;
		if(this.sy<0)
		pY += document.documentElement && document.documentElement.clientHeight ?
		document.documentElement.clientHeight : document.body.clientHeight;
		this.cx += (pX + this.sx - this.cx)/8;this.cy += (pY + this.sy - this.cy)/8;
		this.sP(this.cx, this.cy);
		setTimeout(this.id + "_obj.floatIt()", 0);
	}
	return el;
}

addEvent(window,'load',fire,false);