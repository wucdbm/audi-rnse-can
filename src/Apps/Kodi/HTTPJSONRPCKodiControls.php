<?php

namespace Wucdbm\AudiRnseCan\Apps\Kodi;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use Symfony\Component\Console\Output\OutputInterface;

class HTTPJSONRPCKodiControls implements KodiControls
{
    private Client $client;

    public function __construct(
        private OutputInterface $output,
        private bool $secure,
        private readonly string $ip,
        private readonly int $port,
    )
    {
        $url = sprintf(
            '%s://%s:%s/jsonrpc',
            $this->secure ? 'https' : 'http',
            $this->ip,
            $this->port,
        );

        $this->output->writeln(sprintf(
            'Kodi controls initialized at HTTP JSON RPC "%s"',
            $url
        ));

        $this->client = new Client([
            RequestOptions::HEADERS => [
                'Content-Type' => 'application/json',
            ],
            'base_uri' => $url,
        ]);

    }

    // curl -X POST -H 'Content-Type: application/json' -i
    // http://192.168.0.227:8080/jsonrpc
    // --data '{"jsonrpc": "2.0", "method": "Player.PlayPause", "params": { "playerid": 0 }, "id": 1}'

    public function left(): void
    {
        $this->sendRPC([
            'jsonrpc' => '2.0',
            'method' => 'Input.Left',
            'id' => 1,
        ]);
    }

    public function right(): void
    {
        $this->sendRPC([
            'jsonrpc' => '2.0',
            'method' => 'Input.Right',
            'id' => 1,
        ]);
    }

    public function up(): void
    {
        $this->sendRPC([
            'jsonrpc' => '2.0',
            'method' => 'Input.Up',
            'id' => 1,
        ]);
    }

    public function down(): void
    {
        $this->sendRPC([
            'jsonrpc' => '2.0',
            'method' => 'Input.Down',
            'id' => 1,
        ]);
    }

    public function select(): void
    {
        $this->sendRPC([
            'jsonrpc' => '2.0',
            'method' => 'Input.Select',
            'id' => 1,
        ]);
    }

    public function escape(): void
    {
        $this->sendRPC([
            'jsonrpc' => '2.0',
            'method' => 'Input.Back',
            'id' => 1,
        ]);
    }

    public function play(): void
    {

    }

    public function pause(): void
    {

    }

    public function playPause(): void
    {
        $this->sendRPC([
            'jsonrpc' => '2.0',
            'method' => 'Player.PlayPause',
            'params' => [
                'playerid' => 0,
            ],
            'id' => 1,
        ]);
    }

    public function previous(): void
    {

    }

    public function next(): void
    {

    }

    public function setupWTF(): void
    {

    }

    private function sendRPC(array $payload): void
    {
        $response = $this->client->sendRequest(
            new Request('POST', '', [], json_encode(
                $payload,
                JSON_THROW_ON_ERROR,
            ))
        );

        $contents = $response->getBody()->getContents();
        $decoded = json_decode($contents, JSON_THROW_ON_ERROR);

        if (isset($decoded['error'])) {
            $this->output->writeln(sprintf(
                'Kodi JSONRPC Error: "%s"',
                $contents
            ));
        }
    }
}
