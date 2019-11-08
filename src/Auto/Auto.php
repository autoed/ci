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
Class Auto {

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
     * @param  string $doc
     * @return string
     * @Author: LiDi at 2019/11/7 10:17
     * @Email : lidi.bj@acewill.cn
     */
    private static function StrDoc2html($doc)
    {
        if ($doc) {
            $str = json_encode($doc,JSON_UNESCAPED_UNICODE);
            $strArr = explode('\n\t',$str);
            $doc = '<br>/**</br>';
            array_shift($strArr);
            array_pop($strArr);
            foreach ($strArr as $item) {
                $doc .= '<br>'.$item.'</br>';
            }
            $doc = $doc.'<br>*/</br>';
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
    private static function getBlackFunNames($funNames=array())
    {
        $blackFunNames = array_merge(array('__construct','get_instance'),$funNames);
        $config = array(
            'blackFunNames' => $blackFunNames,
        );
        $key = self::$BLACK_FUN_NAMES;
        //从配置文件加载
        return $config[$key];
    }

    /**获取方法 路由
     * @param  object $item
     * @return string
     * @Author: LiDi at 2019/11/7 13:54
     * @Email : lidi.bj@acewill.cn
     */
    private static function getFunRouteName($item)
    {
        $strLowClass = strtolower($item->class);
        $strLowName  = strtolower($item->name);
        $strUrl = $strLowClass.'/'.$strLowName;
        return $strUrl;
    }

    /**
     * 自动注解：处理数据
     * @param  string $methodDoc
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
         * @var $data=Factory::create();
         * $data::name;
         * $data::address;
         * $data::text;
         */
        $data = self::data();
        $is_not_AD = true;

        if ($matchedGET) {
            $matchesGET = $matchesGET[1];
            @eval($matchesGET);
        }
        if ($matchedPOST) {
            $matchesPOST = $matchesPOST[1];
            @eval($matchesPOST);
        }
        if ($matchedAD) {
            $matchesAD = $matchesAD[1];
            $strArr  = "return ".$matchesAD.";";
            $realArr = @eval($strArr);
            $is_not_AD = false;
        }

        return $is_not_AD ? true : $realArr;
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
        foreach ($methodObjectArr as $key=>$item) {
            if ($item->name == $method) {
                $realKey = $key;
            }
        }
        $methodDoc = '';
        if (isset($realKey)) {
            $methodDoc = $methodObjectArr[$realKey]->getDocComment();
        }

        $realArr = self::deal($methodDoc);
        return $realArr;
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
        $reflection = new \ReflectionClass($classObject);
        $methodObjectArr = $reflection->getMethods();
        $strDoc = '';
        //黑名单过滤
        $blackFunNames = self::getBlackFunNames();
        foreach ($methodObjectArr as $key => $item) {
            if (!in_array($item->name, $blackFunNames)) {
                $funRouteName = self::getFunRouteName($item);
                $strDoc .= '<div id="container"><div id="body">'
                    . self::StrDoc2html($item->getDocComment())
                    . '<p style="font-size: 15px;font-weight:  bold;color: #003399"><button style="font-weight:  bold;">发送请求</button>' . ': ' . $funRouteName . '</p>'
                    . '</div></div>';
            }
        }
        $strDoc = '<div id="container"><div id="body">' . $strDoc . '</div></div>';
        return $strDoc;
    }
}