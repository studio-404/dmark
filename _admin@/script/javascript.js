$(document).mouseup(function (e)
{
	var cont = new Array();
	cont[0]=$(".msg");
	for(i=0;i<=cont.length;i++)
	{
		if(cont[i]){
			if (!cont[i].is(e.target) && cont[i].has(e.target).length === 0)
			{
				cont[i].fadeOut("slow");
			}
		}
	}
});

function openPop(getDocs){
	$( ".mask" ).fadeIn("slow");
	$( ".mbox" ).fadeIn("slow");
	$( "body" ).scrollTop( 0 );
	$( "html" ).css({"overflow":"hidden"});
	$( ".mbox" ).html("<img src='images/loader.gif' alt='loader' />");
	$.get( "ajax/"+getDocs, function( data ) {		
		$( ".mbox" ).html( data );
	});
}

function delete_request(idx,varx)
{
	$( ".mask" ).fadeIn("slow");
	$( ".mbox" ).fadeIn("slow");
	$( "body" ).scrollTop( 0 );
	$( "html" ).css({"overflow":"hidden"});
	var x = varx.split(",");
	var out = '<div class="question">';
	out += '<div class="close" onclick="closeIt()"></div>';
	out += x[0];
	out += '</div>';
	out += '<div class="answer">';
	out += '<form action="" method="post">';
	out += '<div class="boxes">';
	out += '<input type="hidden" name="delete" value="'+idx+'" />';
	out += '<input type="submit" class="submit" id="submit" value="'+x[1]+'" />';
	out += '<div class="closex" onclick="location.reload()">'+x[2]+'</div>';
	out += '</div>';
	out += '</form><br />';
	out += '</div>';
	$( ".mbox" ).html( out );
}

function deleteMultiple(varx)
{
	$( ".mask" ).fadeIn("slow");
	$( ".mbox" ).fadeIn("slow");
	$( "body" ).scrollTop( 0 );
	$( "html" ).css({"overflow":"hidden"});
	$( ".mbox" ).html("Please wait...");
	
	var values = new Array();
	$.each($("input[name='sel[]']:checked"), function() {
	values.push($(this).val());
	});	
	var idx_values = "";
	for(var i=0; i<=values.length; i++){
		if(values[i]!="undefined" || values[i]!=""){
			idx_values += values[i]+",";
		}
	}
	idx_values+="0";
	
	var x = varx.split(",");
	var out = '<div class="question">';
	out += '<div class="close" onclick="closeIt()"></div>';
	out += x[0];
	out += '</div>';
	out += '<div class="answer">';
	out += '<form action="" method="post">';
	out += '<div class="boxes">';
	out += '<input type="hidden" name="delete" value="'+idx_values+'" />';
	out += '<input type="submit" class="submit" id="submit" value="'+x[1]+'" />';
	out += '<div class="closex" onclick="location.reload()">'+x[2]+'</div>';
	out += '</div>';
	out += '</form><br />';
	out += '</div>';
	$( ".mbox" ).html( out );
}

function ch(ms){
	if($('#mainx_'+ms).prop('checked')){
		$(".subx_"+ms).prop('checked', true);
	}else{
		$(".subx_"+ms).prop('checked', false);
	}
}

function closeIt(){
	$( ".mask" ).fadeOut("slow");
	$( ".mbox" ).fadeOut("slow");
	$( "html" ).css({"overflow":"show"});
}

function remove_item(getDocs)
{
	$( ".mask" ).fadeIn("slow");
	$( ".mbox" ).fadeIn("slow");
	$( "body" ).scrollTop( 0 );
	$( "html" ).css({"overflow":"hidden"});
	$( ".mbox" ).html("Please wait...");
	
	var values = new Array();
	$.each($("input[name='sel[]']:checked"), function() {
	values.push($(this).val());
	});	
	
	$.get( "ajax/"+getDocs+"&edit="+values, function( data ) {		
		$( ".mbox" ).html( data );
	});
}

function checkall()
{
	if($(".checkall").prop('checked'))
	{
		$(".all").prop('checked', true);
	}
	else
	{
		$(".all").prop('checked', false);
	}
}

function move(action,idx)
{
	$("#action").val(action);
	$("#idx").val(idx);
	$("#move").submit();
}

function moveAction(action,idx,position,menu_type){

	$.get( "ajax/move.php?action="+action+"&idx="+idx+"&position="+position+"&menu_type="+menu_type, function( data ) {
		if(data==1){
			location.reload();
		}
	});
	$( ".mask" ).fadeIn("slow");
}

function moveAction2(action,id,position){

	$.get( "ajax/move2.php?action="+action+"&id="+id+"&position="+position, function( data ) {
		if(data==1){
			location.reload();
		}
	});
	$( ".mask" ).fadeIn("slow");
}

function appx()
{
	$( '#files' ).clone().appendTo( '.appaends' );
}

function moroChartanswers()
{
	$('#f1').clone().appendTo('.appaends');
	$('#f2').clone().appendTo('.appaends');
}

function chart_n(v){
	if(v=="earthquakes_monthly" || v=="valueOverYear"){
		$('.label_name').val("dd/mm/YYYY");
	}else if(v=="mobile_phone_sub"){
		$('.label_value').val("2011:505; 2012:500; 2013:650;");
	}else{
		$('.label_name').val("");
	}
	$('.appaends').empty();
	if(v=="oil_reserves"){ $("#chart_img").html('<img src="images/olive.png" width="430" height="195" alt="" />'); }
	else if(v=="spend_time"){ $("#chart_img").html('<img src="images/spend_time.png" width="430" height="195" alt="" />'); }
	else if(v=="earthquakes_monthly"){ $("#chart_img").html('<img src="images/earthquike.png" width="430" height="195" alt="" />'); }
	else if(v=="valueOverYear"){ $("#chart_img").html('<img src="images/shareValueOver.png" width="430" height="195" alt="" />'); }
	else if(v=="country_wise"){ $("#chart_img").html('<img src="images/country_wise.png" width="430" height="195" alt="" />'); }
	else if(v=="marketShare"){ $("#chart_img").html('<img src="images/marketShare.png" width="430" height="195" alt="" />'); }
	else if(v=="mobile_phone_sub"){ $("#chart_img").html('<img src="images/mobile_phone_sub.png" width="430" height="195" alt="" />'); }
	else{ $("#chart_img").html(''); }
}

function toDayCurrent(){
	var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth()+1; //January is 0!
	var yyyy = today.getFullYear();
	if(dd<10) {
		dd='0'+dd
	} 
	if(mm<10) {
		mm='0'+mm
	} 
	today = dd+'/'+mm+'/'+yyyy;
	return today;
}

function remove_file(id)
{
	$.get( "ajax/remove_file.php?id="+id, function( data ) {
		if(data==1){
			$("#f_"+id).fadeOut("slow");
		}
	});
}

function search_vars(){
	var where = $("#whereto").val();
	var seach = $("#seach").val();
	if(where && seach){
		$("#where").val(where);
		$("#search_val").val(seach);
		$("#target").submit();	
	}
}

function copyAnswer(){
	var divTocopy = $("#whattocopy").html();
	var copyx = '<div class="boxes">';
	copyx += divTocopy;
	copyx += '</div>';
	$("#here").append(copyx);	
}

function post(path, params, method) {
    method = method || "post";
    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", path);

    for(var key in params) {
        if(params.hasOwnProperty(key)) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);

            form.appendChild(hiddenField);
         }
    }

    document.body.appendChild(form);
    form.submit();
}

function sendPost(idx){
	//alert("hey");
	post("ka/add/navigation",{ from_nav_step: idx });
}

function changeSlideType(ty)
{
	if(ty==0)
	{
		$(".photoHide").fadeIn("slow");
	}
	else
	{
		$(".photoHide").fadeOut("slow");
	}
}