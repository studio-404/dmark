$(document).ready(function(){

	// get body size
	var width = $( document ).width();
	var height = $( document ).height();

	//margin top logo 
	if ( $(".error-404-container").length ) {
     	$( ".error-404-container" ).css({"height": height+"px" });
     	if(width<=280){
     		$( ".error-404-container .error-404-rowcenter" ).css({"margin-top": "-100px" });
     	}else{
     		$( ".error-404-container .error-404-rowcenter" ).css({"margin-top": "-199.5px" });	
     	}
     	
 	}

 	// logo width on < 380px
 	if(width<=380){
 		var rowcenter = $(".error-404-rowcenter").width();
 		$(".error-404-logo").css({"width": "200px !important" }); 
 	}else if(width<=992){
 		$(".error-404-logo").css({"width": "300px !important" }); 
 	}else if(width<=768){
 		$(".error-404-logo").css({"width": "300px !important" }); 
 	}else if(width<=1292){
 		$(".error-404-logo").css({"width": "300px !important" }); 
 	}

 	// logo click
 	if($(".error-404-logo").length)
 	{
 		$(".error-404-logo").click(function(){
 			var u = $(".error-404-logo").data("url");
 			location.href=u;	
 		});
 	}
 	var slideMenu = 1;
 	// remove navigation and set dropdonw
 	if($("main .filterx").length){
 		$("main .filterx").click(function(){
 			if(width >= 1290)
 			{
 				if(slideMenu==1){
	 				var listwidth = $(".cd-tab-filter").width();
	 				$(".cd-tab-filter").css({"left":"-"+(listwidth-30)+"px", "display":"block"});
	 				$(".menuSelected").removeClass("selectedx");
	 				$(".cd-tab-filter").stop().animate({
		          			left: "200px"
		      		});
		      		slideMenu = 2;
 				}else{
 					var listwidth = $(".cd-tab-filter").width();
 					$(".menuSelected").addClass("selectedx");
	 				$(".cd-tab-filter").stop().animate({
		          			left: -(listwidth-30)+"px" 
		      		}, 1000);
		      		slideMenu = 1;
		      		console.log(listwidth);
 				}
 				
 			}else{
 				if(slideMenu==1){
 					$(".cd-tab-filter").fadeIn();
 					$(".menuSelected").removeClass("selectedx");
 					$(".menuSelected").addClass("transferd");
 					slideMenu = 2;
 				}else{
 					$(".cd-tab-filter").fadeOut();
 					$(".menuSelected").addClass("selectedx");
 					$(".menuSelected").removeClass("transferd");
 					slideMenu = 1;
 				}

 			}
 		});
 	}

 	// set filter length
 	// if($("main .lists").length){
 	// 	if(width >= 1290){
 	// 		// alert("test "+width);
 	// 		var lissize = $("main .lists li").length * 150;
 	// 		alert("heu");
 	// 		$("main .filterx .selected").stop().click(function(){
 	// 			if(!$("main .filterx .selected").hasClass("transferd")){
	 // 				$("main .lists").css({"display":"block"});
	 // 				$("main .filterx").css({"width":(lissize+200)+"px"});
	 // 				$('main .lists').animate({
	 //          			left: '180px' 
	 //      			}); 
	 // 				$("main .filterx .selected").addClass("transferd"); 
 	// 			}else{
  //     				$("main .lists").css({"display":"none"});
	 // 				$("main .filterx").css({"width":"200px"});
	 // 				$('main .lists').animate({
	 //          			left: '0px' 
	 //      			}); 
  //     				$("main .filterx .selected").removeClass("transferd"); 
 	// 			}
 	// 		});

 	// 	}else{
 	// 		$("main .filterx .selected").stop().click(function(){
 	// 			$("main .lists2").css({"display":"none"});
 	// 			$("main .lists li").css({"padding":"0","width":"100%","text-align":"left"}); 
 	// 			if(!$("main .filterx .selected").hasClass("transferd")){
	 // 				$("main .lists").css({"z-index":"99","top":"25px"});
	 				
 	// 				$('main .lists').slideDown("slow");
	 // 				$("main .filterx .selected").addClass("transferd"); 
 	// 			}else{
  //     				$("main .lists").css({"top":"25px"});	 			
 	// 				$('main .lists').slideUp("slow"); 
  //     				$("main .filterx .selected").removeClass("transferd"); 
 	// 			}
 	// 		});
 	// 	}
 	// }


	$('.toggle').click(function(){
		$('.menu').slideToggle();
		$('.menu ul').append('<li class="close" onclick="closeNav()"><img src="assets/img/x.png" width="35" height="35" alt="" /></li>');
		$('.menu ul').css({"position":"relative"});
		$('.menu ul .close').css({
									"width":"35px", 
									"height":"35px", 
									"position":"absolute", 
									"top":"-64px", 
									"right":"2px", 
									"opacity":"100", 
									"filter":"alpha(opacity=100)", 
									"z-index":"1001" 
								});
	});
	var globalProjectAnimate = 1;
	$('.error-404-text p a').stop().hover(function(){		
			if(globalProjectAnimate==1){
				$( ".error-404-text p a img" ).stop().animate({
				'margin-left': '20px'
				}, 500, function() {
				// Animation complete.
				});
				globalProjectAnimate = 2;
			}else{
				$( ".error-404-text p a img" ).stop().animate({
				'margin-left': '10px'
				}, 500, function() {
				// Animation complete.
				});
				globalProjectAnimate = 1;
			}

	});
	var colorChange = 1;
	$(".error-404-articleImg").hover(function(){
		var rightSide = $(this).next(".error-404-newsText");
		if(colorChange==1){
			rightSide.find("h2").css({"background":"#fd4b1d"});
			rightSide.find("h2 a").css({"color":"#ffffff"});
			rightSide.find("h2 span").css({"color":"#ffffff"});
			colorChange = 2;
		}else{
			rightSide.find("h2").css({"background":""});
			rightSide.find("h2 a").css({"color":""});
			rightSide.find("h2 span").css({"color":""});
			colorChange = 1;
		}
	});

});


function closeNav(){
	$('.menu').slideToggle();
	$('.menu ul .close').remove();
}

// function filt(ha){	
// 	location.href=ha;
// 	var h = ha.split("#");		
// 	$("#grid .error-404-item").each(function(){
// 		if(h[1]=="all"){
// 			$(this).show(1000);
// 		}else if(h[1]!=$(this).data("filter")){
//             $(this).hide(1000);

// 		}else{
// 			$(this).show(1000);
// 		}
// 	});
// 	var selectedHashValue = $("."+h[1]).html();
// 	$(".selected").html(selectedHashValue);
// 	if( $(document).width() < 1290 )
// 	{
// 		$("main .lists").css({"top":"25px"});	 			
//  		$('main .lists').slideUp("slow"); 
//       	$("main .filterx .selected").removeClass("transferd"); 
//       	yx = 1; 
// 	}else{
// 		$("main .lists").css({"display":"none"});
// 		$("main .filterx").css({"width":"200px"});
// 		$('main .lists').animate({
// 			left: '0px' 
// 		}); 
// 		$("main .filterx .selected").removeClass("transferd");
// 		yx = 1; 
// 	}
// }

function loadNews()
{
	var loaderGif = '<div class="loader"><img src="assets/img/loader.gif" alt="loader" /></div>';
	var xmlhttp;	
	if( !$(".error-404-newsContainer").has(".loader") ){
		$(".error-404-newsContainer").append(loaderGif);
	}
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{		
			var jj = xmlhttp.responseText;
			var obj = JSON.parse(jj);
			var arr = new Array();
			for (var elem in obj) {
				arr.push(obj[elem]);
			} 
			var insidexx = "";
			for(var i=0; i<=(arr.length-1); i++)
			{
				insidexx += '<article class="row error-404-article lazyFade" style="display:none">'; 
				insidexx += '<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 error-404-articleImg">';
				insidexx += '<a href="'+arr[i].urlx+'">';
				insidexx += '<img src="'+arr[i].imgx+'" width="100%" alt="" />';
				insidexx += '</a>';
				insidexx += '</div>';
				insidexx += '<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 error-404-newsText">';
				insidexx += '<h2><a href="'+arr[i].urlx+'">'+arr[i].titlex+'</a> <span>'+arr[i].datex+'</span></h2>';
				insidexx += '<p>';
				insidexx += arr[i].textx;
				insidexx += '</p>';
				insidexx += '</div>';
				insidexx += '</article>';

				$(".error-404-newsContainer").append(insidexx);
				$(".lazyFade").fadeIn(1000);
				$(".error-404-article").removeClass("lazyFade"); 
				insidexx="";
				$(".error-404-newsContainer .loader").remove();
			}			
		}
  	} // http://ajaratv.ge/new/?json&lang=ge&cat=14&limit=10
	xmlhttp.open("GET","json_news.php?limit=5",true);
	xmlhttp.overrideMimeType('application/json; charset=utf-8');
	xmlhttp.send();
}

function loadProjects()
{
	var loaderGif = '<div class="loader"><img src="assets/img/loader.gif" alt="loader" /></div>';
	var xmlhttp;
	var h = location.hash; 
	h = h.split("#"); 	
	if( !$("#grid").has(".loader") ){
		$("#grid").append(loaderGif);
	}
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{		
			var jj = xmlhttp.responseText;
			var obj = JSON.parse(jj);
			var arr = new Array();
			for (var elem in obj) {
				arr.push(obj[elem]);
			} 
			var insidexx = "";
			for(var i=0; i<=(arr.length-1); i++)
			{
				/*insidexx += '<div class="col-lg-2 col-md-4 col-sm-4 col-xs-12 error-404-item lazyFade" data-filter="'+arr[i].datax+'" style="display:none">'; 
				insidexx += '<a href="'+arr[i].urlx+'">';
				insidexx += '<img src="'+arr[i].imagex+'" width="100%" alt="'+arr[i].titlex+'" />'; 
				insidexx += '<p>'+arr[i].titlex+'</p>'; 
				insidexx += '</a>';
				insidexx += '</div>';

				

				<li class="col-lg-2 col-md-4 col-sm-4 col-xs-6 error-404-item mix color-1 check1 radio2 option3">
					<a href="project_view.html">
						<img src="assets/img/project1.png" width="100%" alt="" />
						<p>Bussines Center</p>
					</a>
				</li>

				*/
				insidexx += '<li class="col-lg-2 col-md-4 col-sm-4 col-xs-6 error-404-item mix color-1 check1 radio2 option3 lazyFade">';
				insidexx += '<a href="'+arr[i].urlx+'">';
				insidexx += '<img src="'+arr[i].imagex+'" width="100%" alt="'+arr[i].titlex+'" />'; 
				insidexx += '<p>'+arr[i].titlex+'</p>'; 
				insidexx += '</a>';
				insidexx += '</li>';


				$("#gridx").append(insidexx);
				$(".lazyFade").fadeIn(1000);
				$(".error-404-item").removeClass("lazyFade"); 
				insidexx="";
				$("#gridx .loader").remove();
			}			
		}
  	} // http://ajaratv.ge/new/?json&lang=ge&cat=14&limit=10
  	if(h[1]){ var categ = h[1]; }else{ var categ = "all"; }
	xmlhttp.open("GET","json.php?cat="+categ+"&limit=10",true);
	xmlhttp.overrideMimeType('application/json; charset=utf-8');
	xmlhttp.send();
}