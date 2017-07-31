<?php
  error_reporting(7);
  include "init.php";
?><!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title><?=$info["seo_title"]?></title>
    <meta name="keywords" content="<?=$info["seo_keywords"]?>">
    <meta name="description" content="<?=$info["seo_description"]?>">
    <meta name="author" content="">
    <meta http-equiv="Cache-Control" content="no-transform " /> 
    <meta name="referrer" content="no-referrer" />    
    <meta name="robots" content="index, follow" />
    <meta name="applicable-device" content="pc,mobile" />
    <meta property="og:title" content="<?=$info["seo_title"]?>" />
    <meta property="og:image" content="http://www.parsevideo.com/static/img/logo1.png" />
    <!-- Bootstrap -->
    <link href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href="//cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="//cdn.bootcss.com/fancybox/2.1.6/css/jquery.fancybox.min.css" rel="stylesheet">
    <link href="./static/css/style.css" rel="stylesheet">
    <link rel="shortcut icon" href="./static/img/logo.ico">
    <?=$info['tongji']?>
  </head>
  <body>
  <!--头部-->
  <header class="site-header">
    <div class="header-main container">
      <div class="row">
        <div class="col-xs-12">
          <h2>parse&nbsp;<img src="./static/img/logo.png" alt="LOGO" class="">&nbsp;video</h2>
          <form action="" method="post" onsubmit="return false;">
            <div class="form-group form-group-lg input-group input-group-lg">
              <input type="text" id="url_input" name="url" class="form-control" autocomplete="off" placeholder="<?=$info['url_input_placeholder']?>">
              <span class="input-group-btn" id="url_submit">
                <button class="btn btn-default btn-success" type="button" title="视频解析">
                  <span class="glyphicon glyphicon-arrow-right" id="url_submit_icon" aria-hidden="true"></span>
                </button>
              </span>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!--分享插件 -->
    <div class="header-share">
      <div class="bdsharebuttonbox">
      <a href="#" class="bds_more" data-cmd="more"></a>
      <a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a>
      <a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a>
      <a href="#" class="bds_fbook" data-cmd="fbook" title="分享到Facebook"></a>
      <a href="#" class="bds_bdhome" data-cmd="bdhome" title="分享到百度新首页"></a>
      <a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a>
      </div>
      <script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"32","bdSign":"normal"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
    </div>
    <!--分享插件 -->
  </header>
  <!--头部-->
  <hr/>
  <!--内容部分-->
  <div class="site-middle container">
    <!--窗口提示-->
    <div id="message"></div>
    <!--窗口提示-->
    <!--视频信息部分-->
    <div id="video" style="display:none;"></div>
    <!--视频信息部分-->
    <!--列表部分-->
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="javascript:void(0);">支持列表:</a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse">
          <ul class="nav navbar-nav navbar-right">
            <?php foreach ($info["support"] as $k => $v){ ?>
            <li class="<?php if(md5($k) == 'ec5321a9b3aedf1e7010608999263a68'){echo 'active';}?>">
              <a href="#video_tab_<?=md5($k);?>" data-toggle="tab"><?=$k?></a>
            </li>
            <?php }?>
          </ul>
        </div>
      </div>
    </nav>
    <div class="tab-content">
      <?php foreach ($info["support"] as $k => $v){ ?>
      <div class="tab-pane fade <?php if(md5($k) == 'ec5321a9b3aedf1e7010608999263a68'){echo 'in active';}?>" id="video_tab_<?=md5($k);?>">
        
        <table class="table table-hover table-condensed table-striped table-bordered">
          <?php foreach ($v as $k1 => $v1){ ?> 
            <tr>
              <th class="text-center">
                <h5><a class="left-title" href="./<?=end(explode("|",$k1))?>/"><?=current(explode("|",$k1))?></a></h5>
              </th>
              <td class="bs-callout bs-callout-info">
                <div class="list-unstyled list-group up-list">
                <?php foreach ($v1 as $k2 => $v2){?> 
                   <a class="list-group-item get-link" href="#<?=$v2?>"><?=$v2?></a>
                <?php } ?>
                </div>
              </td>
            </tr>
          <?php } ?>
        </table>
        
      </div>
      <?php }?>
    </div>
    <!--列表部分-->
  </div>  
  <!--内容部分-->
  <hr>
  <!--底部-->
  <footer class="site-footer">
    <div class="container">
      <div class="row footer-top">
        <div class="footer-about col-md-5 col-sm-12">
          <h4>版权声明</h4>
          <p><?=$info["copyright"]?></p>
        </div>
        <div class="footer-link col-md-3 col-sm-12 hidden-xs">
          <h4>友情链接</h4>
          <ul class="list-inline">
            <?php foreach ($info['link'] as $k => $v){ ?>
            <li class="list-link"><a target="_blank" href="<?=$v?>" class="link"><?=$k?></a></li>
            <?php } ?>
          </ul>
        </div>
        <div class="footer-qqun col-md-4 col-sm-12 hidden-xs">
          <h4>加入QQ群</h4>
          <ul class="list-unstyled">
            <li class="list-qqun">
              <a target="_blank" href="https://jq.qq.com/?_wv=1027&k=45m58Wh">
                <img border="0" src="https://pub.idqqimg.com/wpa/images/group.png" alt="1.Parsevideo.com Group 1" title="1.Parsevideo.com Group 1">
              </a>
            </li>
            <li class="list-qqun">
              <a target="_blank" href="https://jq.qq.com/?_wv=1027&k=45m57Lh">
                <img border="0" src="https://pub.idqqimg.com/wpa/images/group.png" alt="1.Parsevideo.com Group 2" title="1.Parsevideo.com Group 2">
                </a>
            </li>
            <li class="list-qqun">
              <a target="_blank" href="https://jq.qq.com/?_wv=1027&k=45m07zw">
                <img border="0" src="https://pub.idqqimg.com/wpa/images/group.png" alt="1.Parsevideo.com Group 3" title="1.Parsevideo.com Group 3">
              </a> 
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <ul class="list-inline text-center footer-copyright">
        <li>©2016-2017</li>
        <li><a href="" class="record">渝ICP备3234464号</a></li>
      </ul>
    </div>
  </footer>
  <a href="#" id="back-to-top"><i class="fa fa-angle-up"></i></a>
  <!--底部-->
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="//cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="//cdn.bootcss.com/clipboard.js/1.6.1/clipboard.min.js"></script>
  <script src="//cdn.bootcss.com/fancybox/2.1.6/js/jquery.fancybox.min.js"></script>
  <script src="//cdn.bootcss.com/jquery.qrcode/1.0/jquery.qrcode.min.js"></script>
  <script type="text/javascript">
    $(function(){
      //导航文本框获取链接
      var url = $(location).attr('hash').replace('#', '');
        if(url){
          $("#url_input").attr("value",url);
        }
      /* 双击清空网址输入框 */
        $("#url_input").dblclick(         
          function() {
            $("#url_input").val('');
          }
        ); 
      /* 单击选择网址输入框 */
        $("#url_input").click(
          function() {
            $(this).select();
          }
        );
      //点击链接到输入框
      $(".get-link").click(function(){
        var get_url = $(this).text();
        //$("#url_input").attr("value",get_url);
        $("#url_input").val(get_url);
        $('html, body').animate({
          scrollTop: $(".site-header").offset().top
        }, 100).end();
      });
      //$("#get-video").attr('src',vod_url);  
      //回车事件
      $(document).keydown(function(event){
        if(event.keyCode == "13"){
          $("#url_submit").trigger("click");
        }
      });
      //返回顶部事件
      $(window).scroll(function(){
        $(this).scrollTop()>100?$("#back-to-top").fadeIn():$("#back-to-top").fadeOut();
      });
      $("#back-to-top").on("click",function(){
        $("html, body").animate({scrollTop:0},1000);
      });
      //ajax提交数据
      $("#url_submit").click(function(){
          $("#message").html("");
          $("#video").fadeOut("slow");
          window.location.href="#"+$("#url_input").val();
          var url = $("#url_input").val();
          _hmt.push(['_trackEvent', 'video', 'prase', url]);
          var hash = "<?=$info['hash'];?>";
          $("#url_submit_icon").attr("class", "fa fa-spinner fa-pulse fa-lg");
          /* 如果为空弹出提示 */
          if(!url){
            $("#message").html("<div class=\"alert alert-warning alert-dismissible fade in\" role=\"alert\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>请输入正确的视频解析网址！</div>");
            $("#url_submit_icon").attr("class", "glyphicon glyphicon-arrow-right");
          }else{
            $.ajax({
              type: "POST",
              url: "./api.php",
              data: { url: url ,hash:hash},
              dataType: "jsonp",
              jsonp: "callback",
              success: function(result) {
                if(result.status == 'ok' && result.total != 0){
                  var video_html = "<div class=\"panel panel-success\"><div class=\"panel-heading\"><h3 class=\"panel-title\">视频列表</h3></div><ul class=\"list-group\">";
                    $.each(result.video, function(i) {                      
                      video_html += "<li class=\"list-group-item\"><p class=\"input-group\"><input type=\"text\" name=\"search\" id=\"video"+i+"\" class=\"form-control get-text\" value=\""+result.video[i].url+"\"><span class=\"input-group-btn\"><a href=\"javascript:void(0);\" class=\"btn btn-info btnCopy\" data-clipboard-action=\"copy\" data-clipboard-target=\"#video"+i+"\" data-toggle=\"tooltip\" data-placement=\"bottom\" onclick=\"_hmt.push(['_trackEvent', 'video', 'copy', '"+result.video[i].url+"']);\"><span class=\"glyphicon glyphicon-duplicate\"></span></a><a href=\""+result.video[i].url+"\" class=\"btn btn-primary get-dowmload\" download=\"title-time.mp4\" role=\"button\" title=\"下载\" onclick=\"_hmt.push(['_trackEvent', 'video', 'download', '"+result.video[i].url+"']);\"><span class=\"glyphicon glyphicon-save\"></span></a><a href=\"javascript:void(0);\" class=\"btn btn-success\" role=\"button\" title=\"播放\" onclick=\"_hmt.push(['_trackEvent', 'video', 'play', '"+result.video[i].url+"']);$.fancybox.open('<div class=\\\'container\\\'><div class=\\\'embed-responsive embed-responsive-16by9\\\'><video autoplay controls class=\\\'embed-responsive-item\\\' src=\\\'"+result.video[i].url+"\\\'></div></div>',{autoResize:true,scrolling:'no',aspectRatio:false,scrollOutside:true,autoCenter:true,autoSize:true,opacity:true,hideOnOverlayClick:true,autoDimensions:true,autoScale:true});\"><span class=\"glyphicon glyphicon-play\"></span></a><a class=\"btn btn-default btn-warning hidden-xs\" title=\"扫码看视频\" onclick=\"_hmt.push(['_trackEvent', 'video', 'qrcode', '"+result.video[i].url+"']);$.fancybox.open('<div id=\\\'qrcode\\\'></div>');$('#qrcode').qrcode({text:'"+result.video[i].url+"'});\"><span class=\"fa fa-qrcode\"></span></a></span></p><p class=\"get-desc\">简介："+result.video[i].desc+"</p></li>";
                    });
                    video_html += "</ul></div>";
                    $("#video").html(video_html);
                    //淡出搜索内容
                    $("#video").fadeIn("slow");
                    //选中文本
                    $(".get-text").click(function(){
                        $(this).select();
                      });
                    //复制内容
                    var clipboard = new Clipboard('.btnCopy');
                    clipboard.on('success', function(e) {
                      $('.btnCopy').tooltip({
                        delay : {
                         show : 100,
                         hide : 500,
                         },
                        trigger : 'hover|click',
                        title : '复制成功！'
                      });

                    });
                    clipboard.on('error', function(e) {
                      $('.btnCopy').tooltip('destroy');
                    });   
                }else{
                  $("#video").fadeOut("slow");
                  $("#message").html("<div class=\"alert alert-warning alert-dismissible fade in\" role=\"alert\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>"+result.message+"</div>"); 
                }
                $("#url_submit_icon").attr("class", "glyphicon glyphicon-arrow-right");
              }
            });

          }
        });
    });
  </script>  
  </body>
</html>