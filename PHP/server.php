<?php
require('vendor/autoload.php');

use \Prack\Response;

define('API_ENDPOINT', 'http://localhost:4242/api/v1/request');
$client = new \GuzzleHttp\Client();

function prepareResponse(\Prack\Response $response)
{
    $headers = array_merge(
        [
            'Content-Type' => 'text/html',
            'Content-length' => strlen($response->getBody()),
            'Connection' => 'close',
        ],
        $response->getHeaders()
    );

    return json_encode([
        'identifier' => $response->getIdentifier(),
        'code' => $response->getStatusCode(),
        'headers' => $headers,
        'body' => $response->getEncodedBody(),
    ]);
}

function sendResponse($response)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, API_ENDPOINT);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, prepareResponse($response));
    curl_exec($ch);
    curl_close($ch);
}

while (true) {
    try {
        $request = $client->request('GET', API_ENDPOINT);
    } catch(\GuzzleHttp\Exception\ConnectException $e) {
        // Prack isn't running
        sleep(5);
        continue;
    } catch(\GuzzleHttp\Exception\GuzzleException $e) {
        // There are no requests pending, so we'll try again. Please notice
        // there is no need to sleep here, Prack will put this thread to
        // sleep for us.
        continue;
    }

    $json = json_decode($request->getBody());
    $request = (new \Prack\Request)
        ->withIdentifier($json->identifier)
        ->buildFromEnvironment((array) $json->environment);

    if ($request->getMethod() != 'GET' || $request->getPathInfo() != '/') {
        $response = (new \Prack\Response)
            ->withIdentifier($json->identifier)
            ->withStatus(404)
            ->withStringBody('Not found, try <a href="/">here</a>');

        sendResponse($response);
    }

    $response = (new \Prack\Response)
        ->withIdentifier($json->identifier)
        ->withHeader('Content-Type', 'application/json')
        ->withStringBody(json_encode(['Hello' => 'World!']));

    sendResponse($response);
}
