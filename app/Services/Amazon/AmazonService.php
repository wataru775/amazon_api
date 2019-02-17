<?php
/**
 * Created by PhpStorm.
 * User: wataru
 * Date: 2019-02-16
 * Time: 11:27
 */

namespace App\Services\Amazon;


use App\Amazon\Result;

class AmazonService
{

    public function searchItems($asin){
        $aws_access_key_id = env('AWS_ACCESS_KEY');
        $aws_secret_key = env('AWS_SECRET_KEY');
        $AssociateTag = env('ASSOCIATE_TAG');

        //URL生成
        $endpoint = 'webservices.amazon.co.jp';
        $uri = '/onca/xml';

        //パラメータ群
        $params = array(
            'Service' => 'AWSECommerceService',
            'Operation' => 'ItemSearch',
            'AWSAccessKeyId' => $aws_access_key_id,
            'AssociateTag' => $AssociateTag,
            'SearchIndex' => 'Books',
            'ResponseGroup' => 'Medium',
            'Keywords' => $asin
        );

        //timestamp
        if (!isset($params['Timestamp'])) {
            $params['Timestamp'] = gmdate('Y-m-d\TH:i:s\Z');
        }

        //パラメータをソート
        ksort($params);

        $pairs = array();
        foreach ($params as $key => $value) {
            array_push($pairs, rawurlencode($key).'='.rawurlencode($value));
        }

        //リクエストURLを生成
        $canonical_query_string = join('&', $pairs);
        $string_to_sign = "GET\n".$endpoint."\n".$uri."\n".$canonical_query_string;
        $signature = base64_encode(hash_hmac('sha256', $string_to_sign, $aws_secret_key, true));
        $request_url = 'http://'.$endpoint.$uri.'?'.$canonical_query_string.'&Signature='.rawurlencode($signature);
        $amazon_xml=simplexml_load_string(@file_get_contents($request_url));

        $results = [];
        foreach($amazon_xml->Items->Item as $item_a=>$item){
            $results[] = Result::valueOf($item);
        }

        return $results;
    }
}