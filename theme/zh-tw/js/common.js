//$ready('body')
//function show_more(){
//	$("#body_part_2").show();
//	$("#show_more_btn").hide();
//}
$("#show_more_btn").on('click',function(e){
	$("#body_part_2").show();
	$("#show_more_btn").hide();
})

$("#get_more").on('click',function(e){
	var type =  $('#get_more').attr('type');
	var node_container ='node_page_list';
	var page = $('#get_more').attr('page');
	page = new Number(page) +1 ;
	var url = '/node/more/'+type+'/'+page;
	$.ajax({
		type:'get',
		url:url,
		dataType:'json',
		success:function(response){
			if(response.error_code==0){
				$('#'+node_container).append(response.data);
				$('#get_more').attr('page',page);		
			}
			else{
				alert(response.error_msg);
			}
		}
	});
})

$("#login_button").on('click',function(e){
	var url = window.location.href;
	//var redirect = 'home';
	$.ajax({
		type:'post',
		url:url,
		dataType:'json',
		data:$('#login_form').serialize(),
		success:function(response){
			if(response.error_code!=0){
				$("#show_tips").addClass('show_error');
				$("#show_tips").html('');
				$("#show_tips").html(response.error_msg);
				$("#show_tips").show();
			}
			else{
				$("#show_tips").removeClass("show_error");
				$("#show_tips").addClass("show_success");
				$("#show_tips").html('');
				$("#show_tips").html(response.success_msg);
				$("#show_tips").show();
				window.location.href = response.data.redirect;
			}
		}
	});
})
//点击概要阅读文章
$('.article-summary').on('click',function(){
	var url = $(this).attr('jumpurl');
	if (url!=''){
		window.location.href = url;
	}
});


//返回
$('.backbtn').on('click',function(){
	window.history.back(-1);
})
//设置图片满屏
$(".pic").find('img').css('max-width','96%');
//減少圖片縮進
$(".wz_font16").find('img').parents("p").css("text-indent","5px");