<?php
use Auto\Auto;
use Auto\Data;

require __DIR__ . '/vendor/autoload.php';
$eol = PHP_EOL;
/**
 * 脚本自测
 * @param string $str
 * @param string $fun
 * @Author: LiDi at 2019/10/25 14:17
 * @Email : lidi.bj@acewill.cn
 */
function _($str,$fun)
{
echo <<<cd

[{$fun}]:
{$str}

cd;
}
/**
 * @var $data Data
 */
$data = Auto::data();

//========================================
/**
 * [191022] name
 * eg: Augusta Gislason
 */
_($data::name(),$data::$fun);
/**
 * [191022] bankAccountNumber
 * eg: 188118427081
 */
_($data::bankAccountNumber(),$data::$fun);
//========================================
/**
 * [191025] address
 * eg: 86944 Bobby Tunnel
 *     West Zella, MI 21698-4660
 */
_($data::address(),$data::$fun);
/**
 * [191025] email
 * eg: maegan03@gmail.com
 */
_($data::email(),$data::$fun);
//========================================
