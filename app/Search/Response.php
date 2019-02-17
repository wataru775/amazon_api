<?php
namespace App\Search;


class Response
{
    /**
     * @var int 実行結果( 200 : 正常終了 )
     */
    public $code = 200;
    /**
     * @var string メッセージ
     */
    public $message = "";
    /**
     * @var array リクエスト
     */
    public $request;
    /**
     * @var array 実行結果
     */
    public $results = [];
}