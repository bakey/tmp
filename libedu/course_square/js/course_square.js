$(function(){
  //大图轮播
    var len  = $(".pic_list li").length;
	var page = 1;
	$(".thumb li").click(function(){
	  page =   $(".thumb li").index(this);
	  PicScroll(page);
	});	
	$('.pic_list').hover(function(){
	  if(_PicScroll){
		clearInterval(_PicScroll);
	  }
	},function(){
		_PicScroll = setInterval(function(){
		if(page == len){ page = 0; }
		PicScroll(page);
		page++; 
	  }, 3000);
	});
	var _PicScroll = setInterval(function(){
	  PicScroll(page);
	  page++; 
	  if(page == len){ page = 0; }
	}, 3000);
	function PicScroll(page){
	  $('.pic_list li').animate({'left':'-'+810*page+'px'});
	  $('.thumb li span').eq(page).addClass('cur')
	  $('.thumb li span').eq(page).parent('li').siblings('li').find('span').removeClass('cur');
	}
  //Tab切换
	$('.lib_tab li').click(function(){TabSelect('.lib_tab li', '.show_con', 'cur', $(this))});
	$('.lib_tab li').eq(0).trigger('click');

	function TabSelect(tab,con,addClass,obj){
		var jQuery_self = obj;
		var jQuery_nav = jQuery(tab);
		jQuery_nav.removeClass(addClass),
		jQuery_self.addClass(addClass);
		var jQuery_index = jQuery_nav.index(jQuery_self);
		var jQuery_con = jQuery(con);
		jQuery_con.hide(),
		jQuery_con.eq(jQuery_index).show();
	}
  
  //资源检索翻页
	$('.resource_next').live('click',function(){
		$('.resource_inner').animate({'left':'-745px'},1000);
	})
});
