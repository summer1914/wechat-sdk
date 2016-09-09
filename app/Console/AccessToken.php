<?php

namespace App\Console;

use Illuminate\Console\Command;
use App\Models\Wechat;
use GuzzleHttp\Client;

class AccessToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'getToken';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '获取微信的access token';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->getToken();
    }

    public function getToken()
    {
        $client = new Client();
        $res = $client->request('GET', Wechat::API.'/cgi-bin/token', [
            'query' => ['grant_type' => 'client_credential', 'appid' => Wechat::APPID, 'secret' => Wechat::SECRET]
            ])->getBody()->getContents();
        $res = json_decode($res, true);
	var_dump($res);
        isset($res['access_token']) && $_SESSION['access_token'] = $res['access_token'];
	var_dump(session('access_token'));
    }
}
