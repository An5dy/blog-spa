<?php

namespace App\Http\Controllers\Api;

use App\Services\FriendlyLinkService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FriendlyLinkController extends Controller
{
    protected $friendlyLinkService;

    /**
     * FriendlyLinkController constructor.
     * @param FriendlyLinkService $friendlyLinkService
     */
    public function __construct(FriendlyLinkService $friendlyLinkService)
    {
        $this->friendlyLinkService = $friendlyLinkService;
    }

    /**
     * 获取列表
     *
     * @return \App\Http\Resources\FriendlyLinkCollection
     */
    public function index()
    {
        $response = $this->friendlyLinkService->all();

        return $response;
    }
}
