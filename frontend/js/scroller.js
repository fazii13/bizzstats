var elements = 10; //div blocks to be scrollable
var step_height = 2000; var steps = 21;
var OSName="Unknown OS";
if (navigator.appVersion.indexOf("Win")!=-1) OSName="Windows";
if (navigator.appVersion.indexOf("Mac")!=-1) OSName="MacOS";
if (navigator.appVersion.indexOf("X11")!=-1) OSName="UNIX";
if (navigator.appVersion.indexOf("Linux")!=-1) OSName="Linux";
//if (navigator.appName == 'Microsoft Internet Explorer') step_height = 1000;
if (OSName == "Windows"&&(navigator.userAgent.indexOf("Chrome")==-1)) step_height = 700;
else if (OSName == "Windows"&&navigator.userAgent.indexOf("Chrome")!=-1) step_height = 700;
var scrollheight = step_height*steps; //page scroll height by pixels

function setObject(){
	//console.log(document.getElementById("wrapper").offsetTop, $("#wrapper").css("top"));
	var obj = new Array();
	obj[0] = {id:"#wrapper",			move:"topmargin",	top:document.getElementById("wrapper").offsetTop}
	obj[1] = {id:"#about-block",		move:"left",		top:document.getElementById("about-block").offsetTop}	//3 blocks inside
	obj[2] = {id:"#sector-block",		move:"left",		top:document.getElementById("sector-block").offsetTop}	//2 blocks inside
	obj[3] = {id:"#products",			move:"topmargin", 	top:document.getElementById("products").offsetTop}
	obj[4] = {id:"#products section",	move:"top", 		top:document.getElementById("products").offsetTop}
	obj[5] = {id:"#clients",			move:"topmargin",	top:document.getElementById("clients").offsetTop}
	obj[6] = {id:"#our-team",			move:"topmargin",	top:document.getElementById("our-team").offsetTop}
	obj[7] = {id:"#contacts",			move:"topmargin",	top:document.getElementById("contacts").offsetTop}
	obj[8] = {id:"#slider section",		move:"topmargin",	top:document.getElementById("our-team").offsetTop}
	obj[9]= {id:"#map",					move:"topmargin",	top:document.getElementById("map").offsetTop}
	obj[10] = {id:".main-nav",			move:"topmargin",	top:0}
	
	if ($("#wrapper").css("top") != "auto") {obj[0].top -= Math.round($("#wrapper").css("top").substring(0,$("#wrapper").css("top").length-2));}
	for (var i=1;i<obj.length-1;i++) if (obj[i].top) {obj[i].top += obj[0].top;}
	obj[0].top += $("#spotlight").height();
	return obj;
}

//function log(str){ (str != null ? console.log(str) : console.log("undefined string"))} //short console log method

function animateThis(el, move){
	if (el.move == "left") $(el.id).stop().animate({scrollLeft:move},{queue: false, easing: 'easeOutExpo', duration: 1000});
	else if (el.move == "top") {$(el.id).stop().animate({scrollTop:move},{queue: false, easing: 'easeOutExpo', duration: 1000});}
	else if (el.move == "topmargin") $(el.id).stop().animate({top:-1*move},{queue: false, easing: 'easeOutExpo', duration: 1000});
}

function calcHeight(obj){
	return parseInt($(obj[1].id).height()) + parseInt($(obj[2].id).height()) + parseInt($(obj[3].id).height()) + 
	parseInt($("#clients").height())+parseInt($("#our-team").height())+
	parseInt($("#map").height())+parseInt($("#attention").height())+parseInt($("footer").height())+90+parseInt($(window).height());
}
function calcBottom(){
	return parseInt($("#clients").height())+parseInt($("#our-team").height())+
	parseInt($("#map").height())+parseInt($("#attention").height())+parseInt($("footer").height())+90+parseInt($(window).height());
}

function scrollNoIndex(scroll){
	$("#wrapper").animate({top:-1*scroll},{queue: false, easing: 'easeOutExpo', duration: 1000}); return false;
}

function scrollDivs(scroll, obj){
	var w = $(window).width();
	var h = $(window).height();
	var btm_height = $("#map").height()+$("#attention").height()+$("#contacts").height()+parseInt($("#contacts").css("padding-top"))*2;
	var perc = 0; var step = step_height;//5000*n;
	function getPerc(i) {perc=((scroll-step*i)/step)*100;}
	function scrollStep(i){getPerc(i); return ((scroll>=(step*i))&&(scroll<(step*(i+1))));}
	function MoveTop(i,perc) {return obj[i].top+$(obj[i].id).height()/100*perc;} //all visible at the top
	function endMoveTop(i) {return obj[i].top+$(obj[i].id).height();} //all visible at the top
	function Move(i,perc) {return obj[i].top+$(obj[i].id).height()/100*perc-h;}//only visible at the bottom
	function endMove(i) {return obj[i].top+$(obj[i].id).height()-h;}//only visible at the bottom
	
	if		(scrollStep(0))	{animateThis(obj[0], obj[0].top/100*perc);animateThis(obj[1],0);animateThis(obj[10], h/100*perc);} //all animations on top
	else if (scrollStep(1)) {animateThis(obj[0], obj[0].top);animateThis(obj[10], h);} //end banner/news to top animation
	else if (scrollStep(2)) {animateThis(obj[1], (w/100)*perc);animateThis(obj[0], obj[0].top);} //about us scroll to competence
	else if (scrollStep(3)) {animateThis(obj[1], w);animateThis(obj[0], obj[0].top);}//end animation to competence
	else if (scrollStep(4)) {animateThis(obj[1], ((w/100)*perc+w));}//animation to experience
	else if (scrollStep(5)) {animateThis(obj[1], (w*2));animateThis(obj[0], obj[0].top);} //end animation to experience
	else if (scrollStep(6)) {animateThis(obj[0], MoveTop(1, perc));}//objtop(obj[2]));} //animation to sectors, vertical
	else if (scrollStep(7))	{animateThis(obj[0], endMoveTop(1));} //end animation to sectors
	else if (scrollStep(8))	{animateThis(obj[2], (w/100)*perc);} //sector1 scroll to sector2
	else if (scrollStep(9))	{animateThis(obj[2], w);animateThis(obj[0], endMoveTop(1));} //end sector1 scroll to sector2
	else if (scrollStep(10)){animateThis(obj[0], Move(3, perc));} //scroll to products
	else if (scrollStep(11)){animateThis(obj[0], endMove(3));} //end scroll to products
	else if (scrollStep(12)){animateThis(obj[4], ((($(obj[4].id).height())/100)*perc));} //scroll all products
	else if (scrollStep(13)){animateThis(obj[4], $(obj[4].id).height());} //end scroll all products
	else if (scrollStep(14)){animateThis(obj[0], obj[3].top+$(obj[3].id).height()-h+(h-$(obj[5].id).height())/100*perc);} //scroll to clients
	else if (scrollStep(15)){animateThis(obj[0], Move(5,perc));} //scroll to clients
	else if (scrollStep(16)){animateThis(obj[0], endMove(5));} //end scroll to clients
	else if (scrollStep(17)){animateThis(obj[0], Move(6,perc));} //scroll to team
	else if (scrollStep(18)){animateThis(obj[0], endMove(6));} //end scroll to team
	else if (scrollStep(19)){animateThis(obj[0], obj[9].top+btm_height/100*perc-h);} //scroll to bottom
	else if (scrollStep(20)){animateThis(obj[0], obj[9].top+btm_height-h);} //end scroll to bottom
		
	//important animation to end when sliding to top or sliding drastically
	if ((scroll>=(step*5))) {animateThis(obj[1], (w*2));}
	if ((scroll>=(step*9))) {animateThis(obj[2], w);}
	if (scroll>=(step*15)) {animateThis(obj[4], $(obj[4].id).height());}
	//if (scroll>=(step*2)) {$("#slider header, .slider-btns").css('visibility','hidden'); $(".products-btns").css('visibility','visible');}
	//else $("#slider header, .slider-btns").css('visibility','visible')
	if (scroll>=(step*2)) {animateThis(obj[10], h);}
	if (scroll>=(step*19)) {$("#slider article").css("display","none");} else {$("#slider article").css("display","");}

	if (scroll<(step*2)) {animateThis(obj[1], 0);}
	if (scroll<(step*8)) {animateThis(obj[2], 0);}
	if (scroll<(step*12)) {animateThis(obj[4], 0);}
	if (scroll>=(step*19)) {if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent)) {}else $(".topbtn").removeClass('fixed').addClass('static');}
	else {if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent)) {} else $(".topbtn").removeClass('static').addClass('fixed');}
}

function scrollTextRight(obj){
	//var id = "#" + obj.parentElement.parentElement.parentElement.id + " .scroll-cols";
	var id = "#" + obj.parentElement.parentElement.id + " .scroll-cols";
	$(id).stop().animate({scrollLeft:$(id).scrollLeft()+$(".three-cols div").width()/2},{queue: false, easing: 'easeOutExpo', duration: 1000});
	return false;
}
function scrollTextLeft(obj){
	//var id = "#" + obj.parentElement.parentElement.parentElement.id + " .scroll-cols";
	var id = "#" + obj.parentElement.parentElement.id + " .scroll-cols";
	$(id).stop().animate({scrollLeft:$(id).scrollLeft()-$(".three-cols div").width()/2},{queue: false, easing: 'easeOutExpo', duration: 1000});
	return false;
}

function columnAll(columnized){
	var loaded = true;
	if ($("#competence article").length <= 0) loaded=false;
	if ($("#experience article").length <= 0) loaded=false;
	if ($("#sector2 article").length <= 0) loaded=false;
	if ($("#sector1 article").length <= 0) loaded=false;
	if (loaded){
		//var height = $(window).height()-$("header").height()-$("#partners").height()*2-parseInt($("#sector2 article").css("padding-top"))-parseInt($(".three-cols").css("padding-top"));
		var height = 0;
		if ($(window).width()>1024) height = $(window).height()-$("header").height()-parseInt($("#sector2 article").css("padding-top"))-parseInt($(".three-cols").css("padding-top"))-parseInt($("#partners").css("margin-top"));
		else  height = $(window).height()-$("header").height()-parseInt($("#sector2 article").css("padding-top"))-parseInt($(".three-cols").css("padding-top"))-parseInt($("#partners").css("margin-top"))-200;
		if ((height>300)||(height==0)) height = 300;
		$(".cursor-back, .cursor-more").css("height",height+"px");
		$(".cursor-back, .cursor-more").css("margin-top",-1*height+"px");
		$("#sector2 .cursor-back, #sector2 .cursor-more").css("margin-top",(-1*height-$("#partners").height())+"px");
		var width = $(".scroll-cols").width()-50;
		if ((width>0)&&(width<800)) width = width/2+50;
		else if(width>=800) width = width/4+120;
		$(".cursor-back, .cursor-more").css("width",width+"px");
		$(".cursor-back").css("right",width+"px");


		if (columnized=="index") $('.three-cols').columnize({width:width, height:height, buildOnce:false});
		else if (columnized!="no") $('.three-cols').columnize({width:width, buildOnce:false});
	}
}

function logosLeft(time){
	$("#logo-slider").animate({marginLeft: -1*($("#logo-slider").width()-$(window).width())},{queue: false, easing: 'linear', duration: time, complete:function(){logosRight(10000)}});
}
function logosRight(time){
	$("#logo-slider").animate({marginLeft: 0},{queue: false, easing: 'linear', duration: time, complete:function(){logosLeft(10000)}});
}

function scrollHref(id){
	var path = window.location.pathname;
	if (path.indexOf("index.php") >= 0){
		var obj = setObject();
		var w = $("#about-block").width();
		var h = $(window).height();
		if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent)) {
			if (id=="news") {location.hash = "#";animateThis(obj[1], 0);return false;}//animateThis(obj[0], h); - kazkodel neveikia
			if (id=="about-us") {location.hash = "#about-block";animateThis(obj[1], 0);return false;}//animateThis(obj[0], h); - kazkodel neveikia
			if (id=="competence") {location.hash = "#about-block";animateThis(obj[1], w); return false;}
			if (id=="experience") {location.hash = "#about-block";animateThis(obj[1], (w*2)); return false;}
			if (id=="sector1") {location.hash = "#sector-block";animateThis(obj[2], 0); return false;}
			if (id=="sector2") {location.hash = "#sector-block";animateThis(obj[2], w); return false;}
			if (id=="products") {location.hash = "#products"; return false;}
			if (id=="clients") {location.hash = "#clients"; return false;}
			if (id=="contacts") {location.hash = "#contacts";/*$("#slider article").css('visibility','hidden');$(".main-nav").css("display","none");*/ return false;}
			if (id=="top") {/*location.hash = "#slider";*/$(".main-nav").css("display","block");$("#slider article").css('visibility','visible');$("html,body").animate({ scrollTop: 0 }, "slow"); return false;}
		}
		else {
			 //main links			
			if (id=="news") {$(window).scrollTop(0); return false;}
			if (id=="about-us") {$(window).scrollTop(2*step_height); return false;}
			if (id=="competence") {$(window).scrollTop(3*step_height); return false;}
			if (id=="experience") {$(window).scrollTop(6*step_height); return false;}			
			if (id=="sector1") {$(window).scrollTop(7*step_height);$(window).scrollTop(7*step_height+1); return false;}
			if (id=="sector2") {$(window).scrollTop(9*step_height); return false;}
			if (id=="products") {$(window).scrollTop(11*step_height); $(window).scrollTop(11*step_height+1);return false;}
			if (id=="clients") {$(window).scrollTop(15*step_height); return false;}
			if (id=="contacts") {$(window).scrollTop(steps*step_height); return false;}
			if (id=="top") {$(window).scrollTop(0); return false;}
			
			//products
			//if (id=="ALIS") {slideNamed(id); $(window).scrollTop(16*step_height); return false;}
			//if (id=="cars") {/*slideTo('#slider-2');*/ $(window).scrollTop(16*step_height); return false;}
			//if (id=="infra") {/*slideTo('#slider-3');*/ $(window).scrollTop(16*step_height); return false;}
			if (slideNamed(id)) {$(window).scrollTop(16*step_height); return false;}
		}
	}
	return true;
}

function mobileScroll(event){
	//var curX = event.targetTouches[0].pageX;
    //var curY = event.targetTouches[0].pageY;
    //if ($(window).scrollTop()>$(window).height()*3) {$("#slider article").css('visibility','hidden');$(".main-nav").css("display","none");}
    //else {$("#slider article").css('visibility','visible');$(".main-nav").css("display","");}
	location.hash = "#touching";
}

//var PAGE_HEIGHT = 0;
function getPageHeight(page){
	if (page == "news")
	return $("#main-header").height() + $("#spotlight-wrapper").height() + $("#main-content").height() + $("#attention").height() + $("footer").height()+60+$("#news-bottom").height()+60-20; //60 - footer, #news-bottom paddings (30px top and bottom)
	if (page == "products")
	return $("#main-header").height() + $("#spotlight-wrapper").height() + $("#main-content").height() + $("#attention").height() + $("footer").height()+60+$("#news-bottom").height(); //60 - footer, #news-bottom paddings (30px top and bottom)
	return $("#main-header").height() + $("#main-content").height() + $("#attention").height() + $("footer").height()+60;
}

function postRedirect(url,where){
	var form = $('<form action="' + url + '" method="post">' +
 	 '<input type="text" name="scroll_to" value="' + where + '" />' +
	  '</form>');
	$('body').append(form);
	$(form).submit();
}

function goOnStart(){
	if(window.location.hash) {
			var hash_value = window.location.hash.replace('#scroll-', '');
			if (hash_value!='contacts')	scrollHref(hash_value);
	}
}

function postEmail(form_id){
	$.ajax({
	type    : 'POST',
	url     : 'php-content/email.php',
	data    : $(form_id).serialize(),
	cache   : false,
	dataType: 'text',
	success : function (serverResponse) {$("#thank-you-form-div").fadeIn("slow");$("#contact-us-form-div").fadeOut("slow");$("#hiring-form-div").fadeOut("slow");$(form_id)[0].reset();},
	error   : function (jqXHR, textStatus, errorThrown) {$("#error-form-div").fadeIn('slow');$("#contact-us-form-div").fadeOut("slow");$("#hiring-form-div").fadeOut("slow");$(form_id)[0].reset();}
	});
}

function showNews(news_file){
	$.get(news_file+'?news=true', function (data) {$('#main-content').append(data);});
}

function moreNews(){
	$.ajax({
	type    : 'POST',
	url     : 'php-content/news-more.php',
	cache   : false,
	dataType: 'json',
	success: function(responseJson) {if (responseJson.article != "no more news") $.get(responseJson.article+'?news=true', function (data) {$('#main-content').append(data);}); else $('#news-more').fadeOut('slow');},
	error: function() {$('#main-content').after("<article><section>There was an error processing your request.</section></article>");}
	});
}
//$.get("", function (data) {$("").append(data);});
$(function() {
	logosLeft(10);logosRight(10);
	var path = window.location.pathname;
	var columnized = "no";
	var obj = null;

	if (navigator.appName == 'Microsoft Internet Explorer') columnized = "ie";
	if (path.indexOf("index.php") >= 0) columnized = "index";
	if (path.indexOf("news") >= 0) columnized = "news";
	if (path.indexOf("products") >= 0) columnized = "products";

	var h = $(window).height(); var w = $(window).width();
	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent)) {
		$("#attention").css("z-index","0");$("#attention").css("overflow","hidden");
		tablet = false;if( /iPad/i.test(navigator.userAgent)) tablet = true;
		if (path.indexOf("index.php") >= 0){}// if ((!tablet)&&(h<1000)) $("#wrapper").css('margin-top', (h-30+"px"));else if (!tablet)$("#wrapper").css('margin-top', (h-$("#spotlight").height())+"px");}
		else columnized = "no";
		window.addEventListener("touchmove", mobileScroll, false);
		//window.onscroll = function() { alert('ok'); mobileScroll(null); };
		//$(".scroll-cols, .sections-block").css('overflow-x','scroll');
		if ($(window).scrollTop()>(h*3)) $("#slider article").css('visibility','hidden');
   		else $("#slider article").css('visibility','visible');
		$("#clients").css('margin-top',"0px");
		$("#products").css('height', 'auto');
		$("#products section").css('height', '100%');
		//$(".products-btns").css('visibility', 'hidden');
		if ((tablet)&&(path.indexOf("index.php") >= 0)) {$("#wrapper").css("position","static");$("#slider").css("position","static");$("#slider").css("margin-top","0");$("#spotlight-wrapper").css("margin-top",($("#spotlight-wrapper").height()*-1)+"px");$("#wrapper").css("margin-top","0");$("footer").css("background","url('img/footer.png')");$("footer").css("background-size","cover");}
		else if ((path.indexOf("index.php") >= 0)) {$("#wrapper").css("position","static");$("#slider").css("position","static");$("#slider").css("margin-top","0");$("#wrapper").css("margin-top","0");$("footer").css("background","url('img/footer.png')");$("footer").css("background-size","cover");}
		$(window).resize(function() {
			//if (path.indexOf("index.php") >= 0) { if ((!tablet)&&(h<1000)) $("#wrapper").css('margin-top', (h-30+"px"));else if (!tablet)$("#wrapper").css('margin-top', (h-$("#spotlight").height())+"px");}
			/*$("#clients").css('margin-top',"0px");
			$("#products").css('height', 'auto');
			$("#products section").css('height', '100%');
			$(".products-btns").css('visibility', 'hidden');*/
		});
	}
	else {
		$("body").append('<div id="page-height"><div>&nbsp;</div></div>'); 			// Virtual scroller element
		if (columnized=="index"){
			$(".products-btns").css('display','block');
			$("#wrapper").css('margin-top', ($(window).height()-$("#spotlight").height())+"px");
			$("#clients").css('margin-top',($(window).height()-$("#clients").height())+"px");
			$("body").append('<div id="onresize">Resizing... Calculating Positions...</div>');	// Showing on resize event
			$("#page-height div").height(scrollheight);
			obj = setObject();
		}
		else { //if no index page
			//$("article section").addClass("columns-three");
			$("#page-height div").height(getPageHeight(columnized));
		}
		$("#wrapper").css('position', 'fixed');
		h = $(window).height(); w = $(window).width();
		//$('html, body').css('overflow', 'hidden');
		$(window).scroll(function() {
			if (columnized=="index"){obj = setObject();scrollDivs($(window).scrollTop(), obj);}
			else {scrollNoIndex($(window).scrollTop());
			 			if ($(window).scrollTop() > ($(document).height()-$("footer").height()-$("#attention").height()-$(window).height())) $(".topbtn").removeClass('fixed').addClass('static');
			 			else $(".topbtn").removeClass('static').addClass('fixed');
					location.hash = "#scrolling";
			}
		});
		
		$(window).resize(function() {			
			if (columnized=="index"){
				$("#onresize").css('display','block');
				if(this.resizeTO) clearTimeout(this.resizeTO);
				this.resizeTO = setTimeout(function() {
					$(this).trigger('resizeEnd');
				}, 500);
			}
			else {$("#page-height div").height(getPageHeight(columnized));}//INDEXUI PASKAICIAVIMA PADARYTI!!!
		});
		//resizing ends
		$(window).bind('resizeEnd', function() {
			if (columnized=="index"){
				obj = setObject();
				scrollDivs($(window).scrollTop(), obj);
				if ($(window).width() > 500) $(".menu").fadeIn('slow');
				$("#wrapper").css('margin-top', ($(window).height()-$("#spotlight").height())+"px");
				$("#clients").css('margin-top',($(window).height()-$("#clients").height())+"px");
				$("#onresize").css('display','none');
			}
		});
	}
	//if (columnized=="index"){
	if (path.indexOf("index.php") >= 0){
	$.get("main-content/competence.php", function (data) {$("#competence").append(data);columnAll(columnized);obj = setObject();goOnStart();});
	$.get("main-content/experience.php", function (data) {$("#experience").append(data);columnAll(columnized);obj = setObject();goOnStart();});
	$.get("main-content/programming.php", function (data) {$("#sector2").append(data);columnAll(columnized);obj = setObject();goOnStart();});
	$.get("main-content/sector.php", function (data) {$("#sector1").append(data);columnAll(columnized);obj = setObject();goOnStart();});
	}
	//}
	goOnStart();
	
	$('#contact-us-form').bind('submit',function(){	postEmail('#contact-us-form');});
	$('#hiring-form').bind('submit',function(){	postEmail('#hiring-form'); });
	
});