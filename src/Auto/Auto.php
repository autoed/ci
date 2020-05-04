<?php
/**
 * 自动注解：PHP测试命名空间 Auto
 * @Author: LiDi at 2019/10/25 13:31
 * @Email : lidi.bj@acewill.cn
 */

namespace Auto;

/**
 * 自动注解：类
 * @Author: LiDi at 2019/10/22 22:52
 * @Email : lidi.bj@acewill.cn
 */
Class Auto
{

    /**
     * 黑名单列表
     * @var $BLACK_FUN_NAMES string
     * @Author: LiDi at 2019/11/8 10:06
     * @Email : lidi.bj@acewill.cn
     */
    protected static $BLACK_FUN_NAMES = 'blackFunNames';

    /**
     * 自动注解：生成数据
     * @return object
     * @Author: LiDi at 2019/10/24 1:06
     * @Email : lidi.bj@acewill.cn
     */
    public static function data()
    {
        return new Data();
    }

    /**注释文档 转 HTML
     * @param string $doc
     * @return string
     * @Author: LiDi at 2019/11/7 10:17
     * @Email : lidi.bj@acewill.cn
     */
    private static function StrDoc2html($doc)
    {
        if ($doc) {
            $str = json_encode($doc, JSON_UNESCAPED_UNICODE);
            $strArr = explode('\n\t', $str);
            if (count($strArr)==1) {
                $strArr = explode('\n', $str);
            }
            $doc = '<br>/**</br>';
            array_shift($strArr);
            array_pop($strArr);
            foreach ($strArr as $item) {
                $doc .= '<br>' . $item . '</br>';
            }
            $doc = $doc . '<br>*/</br>';
        }
        return $doc;
    }

    /**获取黑名单 列表
     * @param array $funNames //黑名单
     * @example array('__construct','get_instance')
     * object|array $config
     * string|int   $key
     * @return mixed
     * @Author: LiDi at 2019/11/7 11:42
     * @Email : lidi.bj@acewill.cn
     */
    private static function getBlackFunNames($funNames = array())
    {
        $blackFunNames = array_merge(array('__construct', 'get_instance'), $funNames);
        $config = array(
            'blackFunNames' => $blackFunNames,
        );
        $key = self::$BLACK_FUN_NAMES;
        //从配置文件加载
        return $config[$key];
    }

    /**获取方法 路由
     * @param object $item
     * @return string
     * @Author: LiDi at 2019/11/7 13:54
     * @Email : lidi.bj@acewill.cn
     */
    private static function getFunRouteName($item)
    {
        $strLowClass = strtolower($item->class);
        $strLowName = strtolower($item->name);
        $strUrl = $strLowClass . '/' . $strLowName;
        return $strUrl;
    }

    /**
     * 自动注解：处理数据
     * @param string $methodDoc
     * @return mixed
     * @Author: LiDi at 2019/10/24 1:24
     * @Email : lidi.bj@acewill.cn
     */
    private static function deal($methodDoc)
    {
        $matchedGET  = preg_match('/@GET\s*([^\s]*)/i', $methodDoc, $matchesGET);
        $matchedPOST = preg_match('/@POST\s*([^\s]*)/i', $methodDoc, $matchesPOST);
        $matchedAD   = preg_match('/@AD\s*([^\s]*)/i', $methodDoc, $matchesAD);
        /**
         * @var $data =Factory::create();
         * $data::name;
         * $data::address;
         * $data::text;
         */
        $data    = self::data();
        $type    = 'POST';
        $realArr = array();
        if ($matchedGET) {
            $matchesGET = $matchesGET[1];
            $strArr = "return " . $matchesGET . ";";
            $realArr = @eval($strArr);
            $type    = 'GET';
        }
        if ($matchedPOST) {
            $matchesPOST = $matchesPOST[1];
            $strArr = "return " . $matchesPOST . ";";
            $realArr = @eval($strArr);
        }
        if ($matchedAD) {
            $matchesAD = $matchesAD[1];
            $strArr = "return " . $matchesAD . ";";
            $realArr = @eval($strArr);
        }

        return array('data'=>$realArr, 'type'=>$type);
    }

    /**
     * 自动注解：载入数据
     * @param object $class
     * @param string $method
     * @return mixed
     * @throws \ReflectionException
     * @Author: LiDi at 2019/10/22 22:56
     * @Email : lidi.bj@acewill.cn
     */
    public static function _auto($class, $method)
    {
        $classObject = $class;
        $reflection = new \ReflectionClass($classObject);

        $methodObjectArr = $reflection->getMethods();
        foreach ($methodObjectArr as $key => $item) {
            if ($item->name == $method) {
                $realKey = $key;
            }
        }
        $methodDoc = '';
        if (isset($realKey)) {
            $methodDoc = $methodObjectArr[$realKey]->getDocComment();
        }
        $tmp     = self::deal($methodDoc);
        $realArr = $tmp['data'];
        return $realArr;
    }

    /**
     * Get style
     * User:  fomo3d.wiki
     * Email: fomo3d.wiki@gmail.com
     * Date: 2020/5/4
     * @return string
     */
    public static function getStyle()
    {
        $style = '<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body {
		margin: 0 15px 0 15px;
	}

	p.footer {
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}

	.container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
	}
	</style>';
        return $style;
    }

    /**
     * Send curl
     * User:  fomo3d.wiki
     * Email: fomo3d.wiki@gmail.com
     * Date: 2020/5/4
     * @return string
     */
    public static function sendCurl()
    {
        $ajax = '<script id="auto_host" class="'.AUTO_TEST_API_HOST.'" type="text/javascript" src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script>
    function ajax(type, url, data,  callback) {
    if (data) {
        $.ajax({
            type: type,
            url: url,
            data: data,
            success: function (data){
                callback(data);
            },
        })
    } else {
        $.ajax({
            type: type,
            url: url,
            success: function (data){
                callback(data);
            },
        })
    }
}
$(".sendBtn").on("click",function(){
    real_button = $(this);
    real_api    = $("#auto_host").attr("class") + "/" + $(this).siblings("a").html();
    real_params = JSON.parse($(this).siblings("b").html());
    real_keys   = JSON.parse($(this).siblings("d").html());
    real_type   = real_button.siblings("c").html();
    if (real_keys) {
        real_data = {};
        for (var i=0; real_keys.length>i; ++i) {
            var real_value = real_button.parent("p").siblings("p").children("."+real_keys[i]).val();
            if (real_value) {
                real_data[real_keys[i]] = real_value;
            }
        }
        if (Object.keys(real_data).length>0) {
            real_params = real_data;
        }
    };
    ajax(real_type,real_api,real_params,function(data){
    if(real_button.siblings(".container").length>0){
        real_button.siblings(".container").remove();
    }
    real_button.parent("p").append("<div style=\"background-color: #555555;color: white\" class=\"container\">"+JSON.stringify(data)+"</div>")
    })
    })
</script>';
        return $ajax;
    }

    /**
     * 生成 HTML格式的 文档
     * @param object $uri
     * @return string
     * @throws \ReflectionException
     * @Author: LiDi at 2019/11/8 10:21
     * @Email : lidi.bj@acewill.cn
     */
    public static function getStrDoc($uri)
    {
        $class = $uri->rsegments[1];
        $classObject = new $class;
        $reflection  = new \ReflectionClass($classObject);
        $methodObjectArr = $reflection->getMethods();
        $strDoc = '';
        //黑名单过滤
        $blackFunNames = self::getBlackFunNames(array('api'));

        foreach ($methodObjectArr as $key => $item) {
            if (!in_array($item->name, $blackFunNames)) {
                $funRouteName = self::getFunRouteName($item);
                $deal_array   = self::deal($item->getDocComment());
                $deal_input   = '';
                array_map(function ($item) use(&$deal_input) {
                    $deal_input .= $item . ':<input class="'.$item.'">'.'<br><br>';
                }, array_keys($deal_array['data']));
                $realData = json_encode($deal_array['data']);
                $strDoc .= '<div style="padding-left: 10px" class="container">'
                    . self::StrDoc2html($item->getDocComment())
                    . '<p>'.$deal_input.'</p>'
                    . '<p style="font-size: 15px;font-weight:  bold;color: #003399"><button class="sendBtn" style="font-weight:  bold;">发送请求</button>'
                    . ': <a>' . $funRouteName .'</a>'
                    .'<b style="display: none">' .$realData.'</b>'
                    .'<d style="display: none">' .json_encode(array_keys($deal_array['data'])).'</d>'
                    .'<c style="display: none">' .$deal_array['type'].'</c>'
                    . '</div>';
            }
        }
        return self::getStyle().'<div class="container">'.$strDoc.'</div>'.self::sendCurl();
    }
}