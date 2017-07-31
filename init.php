<?php
error_reporting(0);
require 'parserVideo.class.php';
header("content-type:text/html;charset=utf-8");
//根据不同的网站加载不同的关键词
$action = trim(strtolower(htmlspecialchars($_SERVER['REQUEST_URI']))," \t\r\n\/");
Base::_cget('');

//支持的网站列表
$info['support'] = array(
	"综合视频" => array(
		'优酷视频|youku'=>array(
			'http://v.youku.com/v_show/id_XMjYxMTQwMTIxNg==.html',
			'http://m.youku.com/video/id_XMjYxMTQwMTIxNg==.html',
		),
		'搜狐视频|sohu'=>array(
			'http://tv.sohu.com/20170327/n485079520.shtml',
			'https://m.tv.sohu.com/20170327/n485079520.shtml',
			'https://wx.m.tv.sohu.com/20170327/n485079520.shtml',
		),
		'芒果TV|mgtv'=>array(
			'http://www.mgtv.com/b/309452/3882556.html',
			'http://m.mgtv.com/#/b/309452/3882556?ref=',
		),
		'哔哩哔哩|bilibili'=>array(
			'http://www.bilibili.com/video/av9069110/',
			'http://www.bilibili.com/mobile/video/av9069110.html',
		),
		'梨视频|pearvideo'=>array(
			'http://www.pearvideo.com/video_1050733',
		),
	),
	
	"短视频" => array(
		'新浪微博|weibo'=>array(
			'http://weibo.com/tv/v/EzT2dfJ8h',
			'http://weibo.com/1949142521/EzT2dfJ8h',
			'http://weibo.com/tv/v/b45f5a5d33b49ccb667eb3afbc4fa16c?fid=1034:b45f5a5d33b49ccb667eb3afbc4fa16c',
		),
		'快手视频|kuaishou'=>array(
			'https://www.kuaishou.com/photo/83855155/1570965204',
			'https://www.kuaishou.com/i/photo/lwx?userId=83855155&photoId=1570965204',
		),
		'秒拍视频|miaopai'=>array(
			'http://www.miaopai.com/show/26DzLcDT0bM-orvSuNLxiw__.htm',
			'http://m.miaopai.com/show/channel/26DzLcDT0bM-orvSuNLxiw__',
		),
		'美拍|meipai'=>array(
			'http://www.meipai.com/media/688342435'
		),
		'小咖秀|xiaokaxiu'=>array(
			'https://v.xiaokaxiu.com/v/fhX23JOcSbVEJOQ9LFKtOP2WBkeP1AA-.html',
			'https://m.xiaokaxiu.com/m/fhX23JOcSbVEJOQ9LFKtOP2WBkeP1AA-.html',
		),
		'微录客|vlook'=>array(
			'http://www.vlook.cn/show/qs/YklkPTI3OTQxNzM',
		),
		'爱拍|aipai'=>array(
			'http://www.aipai.com/c37/OjolJyQlJCxqJWQuKw.html',
		),
	),
	
	"音乐舞蹈" => array(
		'音悦Tai|yinyuetai'=>array(
			'http://v.yinyuetai.com/video/2769045',
			'http://v.yinyuetai.com/video/h5/2769045',
			'http://m2.yinyuetai.com/video.html?id=2769045',
		),
		'酷狗MV|kugou'=>array(
			'http://www.kugou.com/mvweb/html/mv_605623.html',
			'http://m.kugou.com/mv/?hash=386cd39c500d0452ebf5357dc6ccad79',
		),
		'酷我MV|kuwo'=>array(
			'http://www.kuwo.cn/mv/3430797/',
			'http://m.kuwo.cn/mv/3430797/',
		),	
		'糖豆广场舞|tangdou'=>array(
			'http://www.tangdou.com/v90/dAOkNEMjwD1z3A2.html',
			'http://m.tangdou.com/v90/dAOkNEMjwD1z3A2.html',
		),
		'播视网|boosj'=>array(
			'http://www.boosj.com/6995113.html',
			'http://m.boosj.com/6995113.html',
		),
		'Echo回声|appecho'=>array(
			'http://www.app-echo.com/#/sound/51799',
			'http://www.app-echo.com/sound/51799',	
		),
		'贝瓦儿歌|beva'=>array(
			'http://g.beva.com/kan-erge/xiao-tu-zi-guai-guai.html#371',
			'http://m.beva.com/erge/c10106/xiao-tu-zi-guai-guai.html',
		),	
	),

	"国外视频" => array(
		'Youtube|youtube'=>array(
			'https://youtu.be/HACmzZZEca0',
			'https://www.youtube.com/watch?v=HACmzZZEca0',
			'https://m.youtube.com/watch?v=HACmzZZEca0&feature=youtu.be',
		),
		'Tumblr|tumblr'=>array(
			'https://xizi199108.tumblr.com/',
			'https://xizi199108.tumblr.com/page/1',
			'http://yakul-fox.tumblr.com/post/158468244987/',
		),
		'Facebook|facebook'=>array(
			'https://www.facebook.com/similer.chan/posts/10211501748279946',
			'https://m.facebook.com/similer.chan/posts/10211501748279946',
		),
		'Instagram|instagram'=>array(
			'https://www.instagram.com/p/BRg6eqMg7rb/',
			'https://www.instagr.am/p/BRg6eqMg7rb/',
		),
	),
);

//网站sitemap
if(!empty($action) && preg_match("~(sitemap)~i",$action)){
	echo '<?xml version="1.0" encoding="UTF-8"?>';
	echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
	echo '<url>';
	echo '<loc>https://www.parsevideo.com/</loc>';
	echo '</url>';
	$info['support']['91porn|v91porn'] = "http://www.91porn.com/view_video.php?viewkey=5f891af740988357f514";
	foreach($info['support'] as $k=>$v){
		echo '<url>';
		echo '<loc>https://www.parsevideo.com/'.end(explode("|",$k)).'/</loc>';
		echo '</url>';
	}
	echo '</urlset>';
	exit;
}

//根据不同的参数加载不同的网站信息
if(!empty($action) && is_file(CLASS_DIR.$action.".class.php")){	
	foreach($info['support'] as $k=>$v){
		if(preg_match("~{$action}~i",$k)){
			$info['support'] = array(
				$k =>$v,
			);
		}
	}
	$action = ucfirst($action);
	$action::parse('');
}

//升级日志
$info['log'] = array(
	"2017-02-25"=>"视频解析网项目立项，注册parsevideo.com域名。",
	"2017-03-15"=>"视频解析网初期开发工作完成，Beta版上线测试，支持网站：音悦Tai、酷狗MV、酷我MV、美拍网、秒拍视频、新浪微博、快手视频、微录客、小咖秀、哔哩哔哩、Echo回声、Youtube、Tumblr、Instagram、Facebook。",
	"2017-03-22"=>"增加解析支持网站：梨视频，爱拍网、糖豆广场舞、播视网、贝瓦儿歌，搜狐视频，优酷视频。",
	"2017-03-27"=>"修正在移动端浏览器视频预览窗口无法正常显示的问题。",
);

//友情链接
$info['link'] = array(
	"百度" => "http://www.baidu.com",
	"火车采集器" => "http://www.locoy.com/",
	"BanYuner" => "http://www.banyuner.com/",
	"91freedom" => "http://www.91-freedom.com/",
	"楚盟博客" => "http://www.5yun.org/",

	
	"申请链接联系" => "http://wpa.qq.com/msgrd?v=3&uin=78007024&site=qq&menu=yes",
);


//广告代码
$info['adtop'] = '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- PV_INDEX_TOP -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-8932852745399256"
     data-ad-slot="9649402120"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>';
$info['admid'] = '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- PV_INDEX_MID -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-8932852745399256"
     data-ad-slot="6556334924"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>';
$info['adbot'] = '';
//版权申明
$info["copyright"] = 'Parsevideo.com（下简称：视频解析网）为广大用户提供视频地址在线解析服务，用于用户备份及收藏个人喜爱的视频等。视频解析网不储存、发布相关视频，视频版权归属其合法持有人所有，本站不对使用者的行为负担任何法律责任。如果有因为本站而导致您的权益受到损害，请与我们联系，我们将理性对待，协助你解决相关问题。联系邮箱：dowell_tech#qq.com。';

//统计代码
$info['tongji'] = '<script>var _hmt = _hmt || [];(function() {  var hm = document.createElement("script");  hm.src = "https://hm.baidu.com/hm.js?523b2b57d238fe80d5972a1cdb325542";  var s = document.getElementsByTagName("script")[0];   s.parentNode.insertBefore(hm, s);})();</script><script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id=\'cnzz_stat_icon_1253580347\'%3E%3C/span%3E%3Cscript src=\'" + cnzz_protocol + "s4.cnzz.com/stat.php%3Fid%3D1253580347\' type=\'text/javascript\'%3E%3C/script%3E"));</script>';

//验证hash和代理服务器
$info['hash'] = md5("ParserVideo.C0m".ceil(time()/100000));

$info['proxy_en'] = "socks5h://127.0.0.1:10801";
$info['proxy_cn'] = "socks5h://127.0.0.1:8990";
