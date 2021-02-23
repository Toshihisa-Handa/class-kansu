<?php 
namespace Myapp;


class Utils 
{
//特殊文字対策
public static function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}





}



