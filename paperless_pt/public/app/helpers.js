
//PAD
function pad (str, max) {
	str = str.toString();
	return str.length < max ? pad("0" + str, max) : str;
}

//NUMBER FORMAT WITH COMMA
function formatNumber(str){
	// str = str.toString();
	// return str.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	
	//Seperates the components of the number
    var components = str.toString().split(".");
    //Comma-fies the first part
    components[0] = components[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    //Combines the two sections
    return components.join(".");
}

//INPUT TEXT THAT ONLY NUMBERS ALLOWED
function inputTextNumberOnly(inputName){
	$(inputName).keypress(function(e){
		let allow_char = [48,49,50,51,52,53,54,55,56,57];
		if(allow_char.indexOf(e.which) == -1 ){
			return false;
		}
	});
}

// INPUT TEXT THAT ONLY NUMBERS AND PERIOD ALLOWED
function inputTextNumberAndPeriodOnly(inputName){
	$(inputName).keypress(function(e){
		var allow_char = [46,48,49,50,51,52,53,54,55,56,57];
		if(allow_char.indexOf(e.which) == -1 ){
			return false;
		}
	});
}

/*remove an element in an array*/
function pull (arr,elementToRemove){
	var array = arr;
	var index = array.indexOf(find);
	if (index > -1) {
		array.splice(index, 1);
	}
	return array;
}

/*console.log*/
function log (str){
	console.log(str);
}

//SHOW MORE SPAN
function showMoreSpan(data){

	tableID    = data['tableID'];
	tdClass    = data['tdClass'];	
	spanClass  = data['spanClass'];	
	var spann = spanClass.substr(1);	
	var tablee = tableID.substr(1);
	
	// var showSpan = 3;
	var showSpan = parseInt(data['showSpan']);
	var moretext = "Show more >";
	var lesstext = "< Show less";
	
	var rowMore = 0;
	$(tableID).find("td"+tdClass).each(function(){
		var content = $(this).find($(spanClass));

		if(content.length > showSpan){
			var c = "";
			var h = "";
			var t = 1;
			var j = "";
			var htmlAdd = "";
			content.each(function(){
				j = $(this).text();
				if(t <= showSpan){
					c += "<span class='"+spann+"'>"+j+"</span>";
				}
				else{
					h += "<span class='"+spann+"'>"+j+"</span>";
				}
				t++;
			});


			htmlAdd += "<div class='showClass' id='showID"+rowMore+tablee+"'>"+c+"</div>"
					+ 	"<div class='hide hideClass' id='hideID"+rowMore+tablee+"'>"+h+"</div>"
					+ "<a href='' class='moreLink' style='font-weight: bold; font-size: 10px;' row-more-attr='"+rowMore+"' table-attr='"+tablee+"'>" + moretext + "</a>";

			$(this).html(htmlAdd);
			rowMore++;
		}//if
		
	});

	$(".moreLink").unbind("click").on("click",function(){
		var rowAttr = $(this).attr("row-more-attr");
		var tableAttr = $(this).attr("table-attr");
		
		if($(this).hasClass("less")) {
			$(this).removeClass("less");
			$(this).html(moretext);
			$("#hideID"+rowAttr+tableAttr).addClass("hide");
			console.log("less");
		}
		else {
			$(this).addClass("less");
			$(this).html(lesstext);
			$("#hideID"+rowAttr+tableAttr).removeClass("hide");
			console.log("more");
		}
		return false;
	});

}


//SHOW MORE TEXT
function showMoreChar(data){
	
	var tdClassName = data['tdClass'];
		
	var showChar = parseInt(data['showChar']);  // How many characters are shown by default
	var ellipsestext = "...";
	var moretext = "Show more >";
	var lesstext = "< Show less";
		
	$(tdClassName).each(function() {
		var content = $(this).html();
		
		if(content.length > showChar) {
			var c = content.substr(0, showChar);
			var h = content.substr(showChar, content.length - showChar);
		
			var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span>'
				+ '<span class="morecontent">'
				+ 	'<span style="display: none;">' + h + '</span>&nbsp;&nbsp;'
				+	'<a href="" class="moreLinkTD" style="font-weight: bold; font-size: 10px;">' + moretext + '</a>'
				+	'</span>';
			$(this).html(html);
		}
	
	});
	
	$(".moreLinkTD").unbind("click").on("click",function(){
		if($(this).hasClass("less")) {
			$(this).removeClass("less");
			$(this).html(moretext);
		} else {
			$(this).addClass("less");
			$(this).html(lesstext);
		}
		$(this).parent().prev().toggle();
		$(this).prev().toggle();
		return false;
	});
	// END
}

//NEXT BUTTON
function nextPageLi(data){
	var disableClass = data['disableClass'];
	var currentLi = data['currentLi'];
	var nextLi = data['nextLi'];
	var currentTab = data['currentTab'];
	var nextTab = data['nextTab'];
	
	$(currentLi).removeClass("active");
	
	$(nextLi).removeClass(disableClass).addClass("active");
	
	$(currentTab).removeClass("in").removeClass("active");
	$(nextTab).addClass("in").addClass("active");
}

//PREVIOUS BUTTON
function prevPageLi(data){
	var currentLi = data['currentLi'];
	var prevLi = data['prevLi'];
	var currentTabPanel = data['currentTabPanel'];
	var prevTabPanel = data['prevTabPanel'];
	

	$(currentLi).removeClass("active");
	$(prevLi).addClass("active");
	
	$(currentTabPanel).removeClass("in").removeClass("active");
	$(prevTabPanel).addClass("in").addClass("active");
}

//table row highlight
$('.table-highlight tbody').on( 'click', 'tr', function () {
	$(this).addClass('table-select').siblings().removeClass('table-select');
});

//ERROR LINE IN INPUTS
function errorLine(thisParent){
	//thisParent = $(this).parent(".form-line");
	thisParent.addClass("error");
		
	if(thisParent.hasClass("error")){
		thisParent.next("span").remove();
	}

	thisParent.after("<span style='color: red;'>This field is required.</span>");
}

//LINE IN INPUT WHEN ERROR
function removeErrorLine(input_child, input_parent){
	/*$(".form-control").on("keyup change paste",function(){
		var t = $(this);//input_child
		var tParent = t.parent(".form-line");//input_parent

		removeErrorLine(t, tParent);
	});*/
	
	if(input_child.val() != ""){
		input_parent.removeClass("error");
		input_parent.next("span").remove();
	}
	else{
		if(input_parent.hasClass("error")){
			input_parent.next("span").remove();
		}

		input_parent.addClass("error");
		input_parent.after("<span style='color: red;'>This field is required.</span>");
	}
}

//DESTROY SESSION
function end_session(){
	swal({title:"ERROR!", text:"Session is already destroy. Kindly Login again.", type:"error"},
	function(){
		$("#logIn").modal("show");
	});
}
//DUPLICATE SESSION
function duplicate_entry(){
	swal("DUPLICATE!", "Duplicate entry.", "error");
}

function ajaxTblDisplay(url,tbodyId,rowsArray,tblId,frmId,rowsGroupCounter,dataSent,ifDbTbl,ifResponsiveTbl){
	$(frmId).waitMe({effect: "stretch"});
	
	if(ifDbTbl == "yes"){
		$(tblId).DataTable().destroy();
	}

	$.ajax({
		type: "post",
		dataType: "html",
		data: {
			sendData : dataSent
		},
		url: url,
		success: function(html){
			$(tbodyId).html(html);
		},
		complete: function(){
			
			if(ifDbTbl == "yes"){
				if(rowsGroupCounter == "yes"){
					$(tblId).DataTable({
						"rowsGroup" : rowsArray
					});	
				}else{
					if(ifResponsiveTbl == "yes"){
						$(tblId).DataTable({
							responsive: true,
							scrollY: true,
							scrollX: true,
							scrollCollapse: true
						});
						
					}else{
						$(tblId).DataTable();
					}
				}
			}
			
			$(frmId).waitMe("hide");
		}
	});
}

function ajaxDataModalFunction(url,array,modals){
	$.ajax({
		type: "post",
		dataType: "json",
		data: {
			sendData : array
		},
		url: url,
		success: function(data){
			if(data.flag == 1){
				swal({title: "Success", text: "Save Successfully", type:"success" }
				,function(){
					if(modals == ""){
						location.reload();
					}else{
						$(modals).modal("hide");						
					}
				});
			}else{
				if(data.msg == "duplicate"){
					duplicate_entry();
				}else{
					end_session();
				}
			}
		}
	});
}

function ajaxActiveFunction(url,array){
	$.ajax({
		type: "post",
		dataType: "json",
		data: {
			sendData : array
		},
		url: url,
		success: function(data){
			if(data.flag == 1){
				swal("Success","Save Successfully","success");
			}else{
				end_session();
			}
		}
	});
}

function monthFunction(monthPicker){
    var monthNow = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
    $(monthPicker).val(monthNow[new Date().getMonth()]);
}

function yearFunction(yearPicker){
	//year picker
    for (var i = new Date().getFullYear(); i >= 1900; i--)
    {
        $(yearPicker).append($('<option />').val(i).html(i));
    }
}

//MAX LENGTH OF WEEK INPUT
function maxLength(value,idName,valLength){
	if(parseInt(value) > parseInt(valLength)){
		swal("Error","Kindly input not more than "+valLength+". Thank you","error");
		$(idName).val("");
	}
	return false;
}

//CHOSEN DESTROY
function chosenDestroy(selectId){
	if($(selectId).chosen()){
		$(selectId).chosen("destroy");
	}
}

//CHOSEN
function chosenSelect(selectId){
	$(selectId).chosen({width: "100%",search_contains: true});
}

//TIMESTAMP
function timeStampFunction(){
	d = new Date();
	return d.getTime();
}

//DATE RANGE
function dateRangeDisabled(datePickerId,disabledArr){
	var startDate, endDate, dateRange = [];
	
	
	for(var i = 0; i < disabledArr.length; i++){
		for (var d = new Date(disabledArr[i]['from']); d <= new Date(disabledArr[i]['to']); d.setDate(d.getDate() + 1)) {
			dateRange.push($.datepicker.formatDate('yy-mm-dd', d));
		}
		
	}
	
	$(datePickerId).datepicker("destroy");
	
	$(datePickerId).datepicker({
		beforeShowDay: function (date) {
			var dateString = jQuery.datepicker.formatDate('yy-mm-dd', date);
			return [dateRange.indexOf(dateString) == -1];
		}
	});
}

//COUNT TEXT CHARACTER
function countChar(txtId,maxLength){
    var cs = $(txtId).val().length;
	
    if(parseInt(cs) > parseInt(maxLength)){
    	var content = $(txtId).val();
    	var c = content.substr(0, maxLength);
    	$(txtId).val(c);
    	cs = $(txtId).val().length;
    }

	var cc = parseInt(maxLength) - parseInt(cs);

	return cc;
}

//PREVENT QUOTATION
function quotationFunction(e,txtId){
	if(e.keyCode == 222) {
		var thisVal = $(txtId).val().replace(/['"]/g, '');
		$(txtId).val(thisVal);
		return false;
	}
}