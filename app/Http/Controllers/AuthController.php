<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\AuthService;

class AuthController extends Controller
{
    private $AuthService;

    public function __construct()
    {
        $this->AuthService = new AuthService();
    }

    public function loginProcess(Request $request)
    {
        return $this->AuthService->login($request);
    }

    public function logoutProcess()
    {
        return $this->AuthService->logout();
    }
}
