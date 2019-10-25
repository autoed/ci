<?php
namespace Auto;

use Faker\Factory;

Class Data {
    /**
     * @var $fun string  //function name. (Added in PHP 4.3.0)
     * @Author: LiDi at 2019/10/25 14:24
     * @Email : lidi.bj@acewill.cn
     */
    public static $fun;

    /**
     * @var $data Factory::create()
     * @Author: LiDi at 2019/10/23 23:41
     * @Email : lidi.bj@acewill.cn
     */
    protected static $data;

    /**
     * Data constructor.
     */
    public function __construct()
    {
        isset(self::$data) ? : self::$data = Factory::create();
    }

    /**
     * 姓名
     * eg: Augusta Gislason
     * @return string
     * @Author: LiDi at 2019/10/24 0:37
     * @Email : lidi.bj@acewill.cn
     */
    public static function name()
    {
        self::$fun = __FUNCTION__;

        return   self::$data->name;
    }

    /**
     * 银行卡
     * eg: 188118427081
     * @return string
     * @Author: LiDi at 2019/10/24 0:56
     * @Email : lidi.bj@acewill.cn
     */
    public static function bankAccountNumber()
    {
        self::$fun = __FUNCTION__;

        return   self::$data->bankAccountNumber;
    }

    /**
     * 地址
     * eg: 86944 Bobby Tunnel
     *     West Zella, MI 21698-4660
     * @return string
     * @Author: LiDi at 2019/10/25 13:41
     * @Email : lidi.bj@acewill.cn
     */
    public static function address()
    {
        self::$fun = __FUNCTION__;

        return   self::$data->address;
    }

    /**
     * 邮箱
     * eg: maegan03@gmail.com
     * @return string
     * @Author: LiDi at 2019/10/25 14:09
     * @Email : lidi.bj@acewill.cn
     */
    public static function email()
    {
        self::$fun = __FUNCTION__;

        return   self::$data->email;
    }


}