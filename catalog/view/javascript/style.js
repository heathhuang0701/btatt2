$(function()
{
	//$('body').jpreLoader({splashID: "#jSplash",loaderVPos: '41%',autoClose: true},function(){ 
		//NAV();
		//GOTOP();
	//});
	NAV();	
	GOTOP();
    $('.bxslider').bxSlider();

});
    
function GOTOP(){

    $(".gotop").click(function(){
      $("html,body").stop(true,false).animate({scrollTop:0},800);
      return false; 
    });

    $(window).scroll(function(){
     var Y = $(window).scrollTop();
       if(Y>800){
        $(".gotop").stop(true,false).animate({ bottom:40,opacity:1},500);
        }else{
        $(".gotop").stop(true,false).animate({ bottom:20,opacity:0},500);
        }
    });

}

function NAV(){

    $(".porbtn").hover(function() {
        $(this).find('.subbtn').stop(true,true).slideDown();      
    }, function() {
        $(this).find('.subbtn').stop(true,true).slideUp();     
    });

    $(".pro_list ul li").hover(function() {
        // $(this).find('.rightbtn').stop(true,true).slideDown();
        $(this).find('.rightbtn').css("display","block");
    }, function() {
        // $(this).find('.rightbtn').stop(true,true).slideUp();
        $(this).find('.rightbtn').css("display","none");     
    });

    $(".m_munebtn").click(function(){
        $('.m_munelist').stop(true,true).slideDown();
        $(".m_closebtn").css("display","block"); 
        $(this).css("display","none");
    });

    $(".m_closebtn").click(function(){
        $('.m_munelist').stop(true,true).slideUp();
        $(".m_munebtn").css("display","block"); 
        $(this).css("display","none");
    });

    $(".m_porbtn a").bind('click', function(){
        if($('.m_subbtn').css('display') == 'none'){
            $('.m_subbtn').slideDown();
        }else{
            $('.m_subbtn').slideUp();
        }
    });

    $(".work_img ul li a").click(function(){
        $(".popupbox01,.popupbg").css("display","block"); 
    });

    $(".closebtn").click(function(){
        $(".popupbox01,.popupbg").css("display","none"); 
    });

}

