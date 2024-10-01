<?php declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\Get;

class TestController extends Controller
{
    use AuthorizesRequests;

    #[Get('/', name: 'test.index')]
    public function index(): JsonResponse
    {
        return response()->json([
            'test' => true
        ]);
    }
}
