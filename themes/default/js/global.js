jQuery(function($){
    //导航菜单效果
	$('#nav li.fmenu').each(function(i,o){
		var sm=$(o).find('div.subcate').eq(0);
		var cp=sm.find('span.cor').eq(0),aw=$(o).find('a.fmenu').eq(0);
		cp.css('marginLeft',(aw.width()-cp.width())*.5+parseInt(aw.css('paddingLeft'))+parseInt($(o).css('paddingLeft')));
		sm.attr('oheight',sm.height())
		.css({'height':0,'display':'block','width':sm.width(),'overflow':'hidden'});
		if($(o).hasClass('active'))$(o).attr('default','1')
		var timeout;
		if($.browser.msie && parseFloat($.browser.version)<8){
			$(o).mouseover(function(){
				if(!$(this).attr('default'))$(this).addClass('active');
				clearTimeout(timeout);
				sm.stop(true,false).animate({height:sm.attr('oheight')},'fast');
			}).mouseout(function(){
				if(!$(this).attr('default'))$(this).removeClass('active');
				clearTimeout(timeout);
				timeout=setTimeout(function(){
					sm.stop(true,false).animate({height:0},'fast');
				},200);
			});
		}else{
			$(o).hover(function(){
				if(!$(this).attr('default'))$(this).addClass('active');
				sm.stop(true,false).animate({height:sm.attr('oheight')},'fast');
			},function(){
				if(!$(this).attr('default'))$(this).removeClass('active');
				sm.stop(true,false).animate({height:0},'fast');
			});
		}
	});
	
	//导航随页面下拉
	~function(){
		var n=$('#navwraper'),nt=n.offset()['top'],rnode,isFixed=false,
		    supportFixed=!$.browser.msie || parseInt($.browser.version)>7;
		if(supportFixed){
			n.css('width',n.width());
			n.after(rnode=$('<div style="display:none;height:'+n.height()+'px"></div>'));
		}
		
		$(window).bind('scroll',function(){
			var t=$(window).scrollTop();
			if(t>nt){
				if(supportFixed){
					if(!isFixed){
						n.css({'position':'fixed','top':0});
						rnode.show();
						isFixed=true;
					}
				}else{
				    n.css({top:t-nt});
					
				}
			}else{
				if(supportFixed){
                    if(isFixed){
                        n.css({'position':'','top':0});
                        rnode.hide();
                        isFixed=false;
                    }
                }else{
                    
                    n.css({top:0});
                }
			}
		});
	}();
	
	//定位锚
	if(location.hash!='' && location.hash!='#'){
		var oft=$('[name='+location.hash.substr(1)+']').offset()||$(location.hash).offset();
		var top;
		if(oft && oft.top)top=oft.top-$('#navwraper').height();else top=0;
		$('html,body').animate({'scrollTop':top})
	}
	
	//尾元素处理
	$('#location ul li:last').addClass('last');
	$('#pagenav').css('width',$('.turnpage').width());
	$('#pagenav .turnpage li:last').addClass('last');
	$('#pagenav .turnpage li').hover(function(){
		if(!$(this).hasClass('pagecurrent'))$(this).addClass('pageative');
	},function(){
		$(this).removeClass('pageative');
	});
	
	//空链接处理
	$('a[href=#]').click(function(e){e.preventDefault()});
	
	
	//引导工具
	var tool=$('<div id="tool"><a href="javascript:void(0)" class="top" title="回顶部"></a><a href="javascript:void(0)" class="fav" title="收藏该商品"></a><a href="javascript:void(0)" class="com" title="看评论"></a><a href="javascript:void(0)" class="bot" title="到底部"></a></div>').appendTo(document.body);
	var ie6=$.browser.msie && parseInt($.browser.version)<7,scrollobj=$('html,body');
	tool.find('a.top').click(function(){scrollobj.animate({scrollTop:0})});
	if(location.href.match(/products\/view/i)){
		tool.find('a.fav').click(function(){$('#addFav').trigger('click')});
		tool.find('a.com').click(function(){scrollobj.animate({scrollTop:$('.prodview-reply').offset()['top']-$('#navwraper').height()})});
		if(ie6)tool.css('height',tool.find('a.top').height()*4);
	}else{
		tool.find('a.fav').hide();
		tool.find('a.com').hide();
		if(ie6)tool.css('height',tool.find('a.top').height()*2);
	}
	tool.find('a.bot').click(function(){scrollobj.animate({scrollTop:$(document.body).height()-$(window).height()})});
	if( !ie6 ){
		tool.css('position','fixed');
		tool.find('a.top').hide();
		$(window).bind('scroll',function(){
			if($(window).scrollTop()>0){
				tool.find('a.top').fadeIn('fast');
			}else{
				tool.find('a.top').fadeOut('fast');
			}
			
			if($(window).scrollTop()>=$(document.body).height()-$(window).height()){
				tool.find('a.bot').fadeOut('fast');
			}else{
				tool.find('a.bot').fadeIn('fast');
			}
		});
	}else{
		var timet=null;
		$(window).bind('scroll',function(){
			tool.hide();
			clearTimeout(timet);
			setTimeout(function(){
			tool.fadeIn('fast').css('top',$(window).scrollTop()+$(window).height()-tool.height()-10);
			},800);
		});
		
		//顺便缓存背景
		document.execCommand("BackgroundImageCache", false, true);
	}
	tool.fadeIn('fast');
	$('a').attr('hideFocus',true);
});

//初始化搜索框
initInput(document.getElementById('keyword'),'输入产品名称搜索');

//文字闪烁
(function blink(opt){
	var opts={
		colors:['#155557','#107b7f','#16b3b9','#1ec0c6','#1ad5dd','#27f7ff','#1ad5dd','#1ec0c6'],
		delay:60,
		inter:1000,
		attr:'color',
		obj:null
	};
	if(opt)$.extend(opts,opt);
	var index=0,t,tc,ocolor=$(opts.obj).css(opts.attr);
	function start(){
		t=setInterval(function(){
			$(opts.obj).css(opts.attr,opts.colors[index++]);
			if(index>=opts.colors.length){
				index=0;
				clearInterval(t);
				tc=setTimeout(start,opts.inter);
			}
		},opts.delay);
	}
	start();
	$(opts.obj).hover(function(){
		$(opts.obj).css(opts.attr,ocolor);
		index=0;
		clearInterval(t);
		clearTimeout(tc);
	},start);
	
})({obj:'#newprod a'});
