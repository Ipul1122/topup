<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DigiflazzService;
use Illuminate\Http\Request;

class DigiflazzController extends Controller
{
    protected $digiflazzService;

    // Inject Service menggunakan Dependency Injection Laravel
    public function __construct(DigiflazzService $digiflazzService)
    {
        $this->digiflazzService = $digiflazzService;
    }

    public function getInfo()
    {
        $info = $this->digiflazzService->getMerchantInfo();
        return response()->json($info);
    }

    public function checkGameAccount(Request $request)
    {
        $request->validate([
            'game_code' => 'required|string',
            'user_id'   => 'required|string',
        ]);

        $response = $this->digiflazzService->checkUsername(
            $request->game_code, 
            $request->user_id
        );

        return response()->json($response);
    }
}
