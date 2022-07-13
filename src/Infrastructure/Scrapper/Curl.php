<?php

namespace Module\Infrastructure\Scrapper;

class Curl
{

    const API_URL = 'https://api.webscrapingapi.com/v1';
    const API_KEY = 'cTcty1xNDaGDKXICgDnI5u3BX9v7vKvc';

    public function Call($url, $countryCode, array $extractRule): bool|string
    {
        $jsonExtractRule = json_encode($extractRule);
        $curl = curl_init();
        $url = self::API_URL
            . "?url=". urlencode($url)
            ."&api_key=". self::API_KEY
            ."&device=desktop&proxy_type=datacenter"
            ."&country=" . $countryCode . '&extract_rules=' . urlencode($jsonExtractRule);

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_SSL_VERIFYPEER =>0
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            throw new \Exception($err);
        }
        return $response;
    }
}
