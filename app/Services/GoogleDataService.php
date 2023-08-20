<?php

namespace App\Services;

use Google_Client;
use Google\Auth\OAuth2;
use Google\Auth\CredentialsLoader;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class GoogleService
{
    protected $client;
    protected $httpClient;

    public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setAuthConfig(config('sheets.config'));
        $this->httpClient = new Client();
    }

    public function getAccessToken()
    {
        if (Cache::has('google_access_token')) {
            return Cache::get('google_access_token');
        }
        require_once 'vendor/autoload.php';

        $keyFile = config('sheets.config');
        $audience = $keyfile->token_uri;
        $scope = 'https://www.googleapis.com/auth/drive';

        $credentials = CredentialsLoader::makeCredentials($scope, $keyFile);
        $client = new Client();

        $jwt = (new OAuth2([
            'signingAlgorithm' => 'RS256',
            'signingKey'       => $credentials['signingKey'],
            'audience'         => $audience,
            'issuer'           => $credentials['clientEmail'],
            'subject'          => $credentials['clientEmail'],
            'scopes'           => $scope,
            'lifetime'         => '3600',
        ]))->toJwt();

        // Use the JWT to get an access token
        $response = $client->post($audience, [
            'json' => [
                'assertion' => $jwt,
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer'
            ]
        ]);

        $accessToken = json_decode($response->getBody(), true)["access_token"];
        Cache::put('google_access_token', $accessToken, 3500);

        return $accessToken;
    }

    public function runScript(Str $scriptId, $functionName, array $parameters = [])
    {
        $accessToken = $this->getAccessToken();

        $response = $this->httpClient->request('POST', "https://script.googleapis.com/v1/scripts/{$scriptId}:run", [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
                'Accept' => 'application/json',
            ],
            'json' => [
                'function' => $functionName,
                'parameters' => $parameters
            ]
        ]);

        $content = json_decode($response->getBody()->getContents(), true);

        return $content;
    }
}
