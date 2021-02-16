<?php

namespace app\models;

use yii\base\Model;

class Rate extends Model
{
    const URL = 'https://www.cbr-xml-daily.ru/daily_json.js';

    public static function get($params)
    {
        list($currency, $rateCurrency, $rateSum) = $params;

        $data = json_decode(Rate::get_data(Rate::URL));

        if ($data) {

            $name = $data->Valute->{$currency}->Name;
            $rate = $data->Valute->{$currency}->Value;
            $crossRate = ($rateCurrency == "RUR") ? $data->Valute->{$currency}->Value : $data->Valute->{$currency}->Value / $data->Valute->{$rateCurrency}->Value;
            $result = $rateSum * $crossRate;

            $responce = [
                    "name" => $name,
                    "code" => $currency,
                    "result" => number_format($result, 1, ",", ""),
                    "rateCurrency" => $rateCurrency,
                    "rateSum" => $rateSum,
                    "rate" => number_format($crossRate, 2, ",", "")
                    ];
        }
        else
        {
            $responce = [
                     "error" => "404",
                     "message" => "data not found",
                     "detail" => ""
                    ];
        }

        return $responce;
    }

    public static function get_data($url)
    {
        if ($url) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            // curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
            curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            $data = curl_exec($ch);
            curl_close($ch);
            return $data;
        }

        return false;
    }


}
