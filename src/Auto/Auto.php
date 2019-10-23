<?php
namespace Auto;

/**
 * 自动注解：类
 * @Author: LiDi at 2019/10/22 22:52
 * @Email : lidi.bj@acewill.cn
 */
Class Auto {

    /**
     * 自动注解：生成数据
     * @return Data
     * @Author: LiDi at 2019/10/24 1:06
     * @Email : lidi.bj@acewill.cn
     */
    public static function data()
    {
       return new Data();
    }

    /**
     * 自动注解：处理数据
     * @param $methodDoc
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
        }
        $strArr  = "return ".$matchesAD.";";
        $realArr = @eval($strArr);
        return $realArr;
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

}