<?php

namespace App\Http\Controllers\WebHook;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeploymentController extends Controller
{
    /**
     * 下来daima
     *
     * @param Request $request
     */
    public function deploy(Request $request)
    {
        $commands = ['cd /www/blog-spa', 'git pull'];
        $signature = $request->header('X-hub-Signature');
        $payload = file_get_contents('php://input');
        if ($this->isFromGitHub($payload, $signature)) {
            foreach ($commands as $command) {
                shell_exec($command);
            }
            http_response_code(200);
        } else {
            abort(403);
        }
    }

    /**
     * 验证签名
     *
     * @param $payload
     * @param $signature
     * @return bool
     */
    private function isFromGitHub($payload, $signature)
    {
        return 'sha1=' . hash_hmac('sha1', $payload, config('global.webHook.token'), false) === $signature;
    }
}
