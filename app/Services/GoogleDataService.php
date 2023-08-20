<?php

namespace App\Services;

use Google\Client;
use Google\Service\Script;
use Google\Service\Script\ExecutionRequest;
use Google\Service\Script\Operation;

class GoogleDataService
{
    /**
     * @var Script
     */
    private $scriptInstance;
    public $client;

    public function __construct()
    {
        $client = new Client();
        $client->setApplicationName('css-scope-api');
        $client->setScopes('https://www.googleapis.com/auth/script.projects');
        $client->setAuthConfig('sheetcredentials.json');

        $scriptInstance = new Script($client);
        $scriptInstance->scriptId = config('script.id.sheets');
    }

    public function runScript(string $functionName, array $params)
    {
        $this->scriptInstance->script->run($this->scriptId, $functionName, $params);
    }
}



// use Exception;
// use Google_Client;
// use Google\Auth\OAuth2;
// use Google\Auth\CredentialsLoader;
// use GuzzleHttp\Client;
// use Illuminate\Support\Facades\Cache;
// use Illuminate\Support\Str;

// class GoogleDataService
// {
//     protected $client;
//     protected $httpClient;

//     public function __construct()
//     {
//         $this->client = new Google_Client();
//         $this->client->setAuthConfig(config('sheets.config'));
//         $this->httpClient = new Client();
//     }

//     public function getAccessToken()
//     {
//         if (Cache::has('google_access_token')) {
//             return Cache::get('google_access_token');
//         }
//         require_once 'vendor/autoload.php';

//         $keyFile = json_decode(file_get_contents(config('sheets.config')), true);
//         $audience = $keyFile['token_uri'];
//         $scope = [
//             'https://www.googleapis.com/auth/script.projects',
//             'https://www.googleapis.com/auth/script.processes',
//             'https://www.googleapis.com/auth/spreadsheets',
//             'https://www.googleapis.com/auth/drive',
//         ];

//         $credentials = CredentialsLoader::makeCredentials($scope, $keyFile);
//         $token = $credentials->fetchAuthToken();
//         $accessToken = $token['access_token'];
//         echo $accessToken;


//         // $jwt = (new OAuth2([
//         //     'signingAlgorithm' => 'RS256',
//         //     'signingKey'       => $keyFile['private_key'],
//         //     'audience'         => $audience,
//         //     'issuer'           => $keyFile['client_email'],
//         //     'subject'          => $keyFile['client_email'],
//         //     'scopes'           => $scope,
//         //     'lifetime'         => '3600',
//         // ]))->toJwt();

//         // // Use the JWT to get an access token
//         // $response = $client->post($audience, [
//         //     'json' => [
//         //         'assertion' => $jwt,
//         //         'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer'
//         //     ]
//         // ]);

//         // $accessToken = json_decode($response->getBody(), true)["access_token"];
//         // Cache::put('google_access_token', $accessToken, 3500);

//         return $accessToken;
//     }

//     public function runScript($functionName, array $parameters = [])
//     {
//         $accessToken = $this->getAccessToken();
//         $scriptId = config('sheets.id.script');

//         $response = $this->httpClient->request('POST', "https://script.googleapis.com/v1/scripts/{$scriptId}:run", [
//             'headers' => [
//                 'Authorization' => 'Bearer ' . $accessToken,
//                 'Accept' => 'application/json',
//             ],
//             'json' => [
//                 'function' => $functionName,
//                 'parameters' => $parameters
//             ]
//         ]);

//         $content = json_decode($response->getBody()->getContents(), true);

//         return $content;
//     }
// }
