<?php
/**
 * Created by PhpStorm.
 * User: wataru
 * Date: 2019-02-16
 * Time: 11:08
 */
namespace App\Search;


class Request
{

    public $ASIN;

    public static function valueOf(\Illuminate\Http\Request $current_request){
        $request = new Request();
        $request->ASIN = $current_request->input("ASIN");
        return $request;
    }
}