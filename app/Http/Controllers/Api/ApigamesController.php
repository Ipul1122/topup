<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ApigamesService;
use Illuminate\Http\Request;

class ApigamesController extends Controller
{
    protected $apigamesService;

    // Inject Service menggunakan Dependency Injection Laravel
    public function __construct(ApigamesService $apigamesService)
    {
        $this->apigamesService = $apigamesService;
    }

   public function getInfo()
    {
        $info = $this->apigamesService->getMerchantInfo();
        
        // KITA RETURN LANGSUNG RAW RESPONSE DARI APIGAMES
        return response()->json($info);
    }

    public function checkGameAccount(Request $request)
    {
        $request->validate([
            'game_code' => 'required|string',
            'user_id'   => 'required|string',
        ]);

        $response = $this->apigamesService->checkUsername(
            $request->game_code, 
            $request->user_id
        );

        // KITA RETURN LANGSUNG RAW RESPONSE DARI APIGAMES
        return response()->json($response);
    }
}