<?php
/**
 * Created by PhpStorm.
 * User: wataru
 * Date: 2019-02-16
 * Time: 11:21
 */

namespace App\Services;
use App\Exceptions\AmazonSearchControllerServiceException;
use App\Search\Request;
use App\Services\Amazon\AmazonService;

class AmazonSearchControllerService
{
    private $amazonItemSearchService;
    public function __construct(AmazonService $amazonItemSearchService)
    {
        $this->amazonItemSearchService = $amazonItemSearchService;
    }

    public function searchItems(Request $request){
        if(strlen( $request->ASIN) != 10){
            throw new AmazonSearchControllerServiceException("ASINの桁数が不正です");
        }
        $items = $this->amazonItemSearchService->searchItems($request->ASIN);
        if(count($items) == 0 ){
            throw new AmazonSearchControllerServiceException("商品が見つかりません");
        }
        if(count($items) != 1 ){
            throw new AmazonSearchControllerServiceException("対象商品が多すぎます");
        }
        return $items;
    }
}