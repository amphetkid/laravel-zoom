<?php

namespace Amphetkid\Zoom;

use Exception;
use Firebase\JWT\JWT;
use Illuminate\Support\Str;
use Amphetkid\Zoom\Interfaces\PrivateApplication;
use GuzzleHttp;

class Zoom
{
    private $api_url = 'https://api.zoom.us/v2/';

    private function generateJWTKey() {
        $key    = config('zoom.api_key');
        $secret = config('zoom.api_secret');

        $token = array(
            "iss" => $key,
            "exp" => time() + 3600
        );

        return JWT::encode( $token, $secret );
    }

    protected function sendRequest( $calledFunction, $data, $request = "GET" ) {
        $args = array(
            'Authorization' => 'Bearer ' . $this->generateJWTKey(),
            'Content-Type'  => 'application/json'
        );

        $client = new GuzzleHttp\Client([
            'headers'  => $args
        ]);
        $request_url = $this->api_url . $calledFunction;

        if ( $request == "GET" ) {

            $veri = !empty( $data ) ? $data : array();
            $response = $client->request('GET', $request_url, $veri);
        } else if ( $request == "DELETE" ) {
            $veri  = ! empty( $data ) ? json_encode( $data ) : array();
            $response = $client->request('DELETE', $request_url, $veri);
        } else if ( $request == "PATCH" ) {
            $veri['body'] = ! empty( $data ) ? json_encode( $data ) : array();
            $response = $client->request('PATCH', $request_url, $veri);
        } else {
            $veri['body'] = ! empty( $data ) ? json_encode( $data ) : array();
            $response = $client->request('POST', $request_url, $veri);
        }

        $response =  $response ;

        /*dump($response);
        die;*/

        if ( ! $response ) {
            return false;
        }

        return $response->getBody()->getContents();
    }
}
