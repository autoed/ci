<?php
namespace Auto;

use Faker\Factory;

Class Data {
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
     * @return string
     * @Author: LiDi at 2019/10/24 0:37
     * @Email : lidi.bj@acewill.cn
     */
    public static function name()
    {
        return   self::$data->name;
    }

    /**
     * @return string
     * @Author: LiDi at 2019/10/24 0:56
     * @Email : lidi.bj@acewill.cn
     */
    public static function bankAccountNumber()
    {
        return   self::$data->bankAccountNumber;
    }


}