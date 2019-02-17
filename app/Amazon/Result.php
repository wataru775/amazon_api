<?php
/**
 * Created by PhpStorm.
 * User: wataru
 * Date: 2019-02-16
 * Time: 12:19
 */

namespace App\Amazon;


class Result
{
    public $detailURL;
    public $image;
    public $title;
    public $author;
    public $price;

    public static function valueOf($item){
        $result = new Result();
        $result->detailURL=$item->DetailPageURL;//商品のURL
        $result->image=$item->MediumImage->URL;//画像のURL
        $result->title=$item->ItemAttributes->Title;//商品名
        $result->author=$item->ItemAttributes->Author;//著者名
        $result->price=$item->ItemAttributes->ListPrice->Amount;//価格
        return $result;
    }
}