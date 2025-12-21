<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class NodeAuthService
{
    /**
     * Get a valid token (from DB or refresh if expired)
     */
    public static function getToken()
    {
        $record = DB::table('tokens')->latest()->first();

        if ($record && Carbon::now()->lt(Carbon::parse($record->expires_at))) {
            // Token still valid
            return $record->token;
        }

        // Otherwise login again
        return self::loginAndSaveToken();
    }

    /**
     * Login to Node server and save token
     */
    private static function loginAndSaveToken()
    {
        $url = Config::get('app.api_base_url') . '/login';


        $response = Http::asMultipart()->post($url, [
            [
                'name' => 'user_id',
                'contents' => Config::get('app.api_user'),
            ],
            [
                'name' => 'password',
                'contents' => Config::get('app.api_password'),
            ],
        ]);

        if ($response->failed()) {
            throw new \Exception('Login request to Node server failed');
        }

        $data = $response->json();

        if (!isset($data['token'])) {
            throw new \Exception('Token not found in Node server response');
        }

        $token = $data['token'];
        $expiry = Carbon::now()->addMinutes(15);

        DB::table('tokens')->insert([
            'token' => $token,
            'expires_at' => $expiry,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return $token;
    }

    public function getSummaryDetails($summary,$type){
        $url = Config::get('app.api_base_url') . '/getdetails';
        $token = self::getToken();
        $response = Http::asMultipart()->post($url, [
            [
                'name' => 'statement_id',
                'contents' => $summary->statement_id,
            ],
            [
                'name' => 'fiscal_year',
                'contents' => $summary->fiscal_year,
            ],
            [
                'name' => 'type',
                'contents' => $type,
            ],
            [
                'name' => 'token',
                'contents' => $token,
            ],
        ]);
        if ($response->failed()) {
            throw new \Exception('Get details request to Node server failed');
        }
        $data = json_decode($response->body());
        return $data;
    }

    public function getSearchDAta($statementFile,$phrase){

        $url = Config::get('app.api_base_url') . '/search';

        $response = Http::get($url, [
            'request_id'   => $statementFile->analysis->request_id,
            'statement_id' => $statementFile->statement_id,
            'phrase'       => $phrase,
        ]);


        if ($response->failed()) {
            throw new \Exception('Search API call failed');
        }
        $data = json_decode($response->body());
        return $data;
    }


}
