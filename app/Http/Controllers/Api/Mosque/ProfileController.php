<?php

namespace App\Http\Controllers\Api\Mosque;

use App\Contracts\Mosque\ProfileInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProfileController extends Controller
{
    public function __construct(protected ProfileInterface $profile) {}

    public function show(): JsonResponse
    {

        $userId = auth()->user()->id;
        $params = ['id' => $userId];
        $relations = ['userDetail'];
        $response = $this->profile->getWhereFirst(params: $params, relation: $relations);
        $statusCode = isset($response['statusCode']) ? $response['statusCode'] : 501;
        return response()->json([$response], $statusCode);
    }

    public function update(ProfileUpdateRequest $request, AuthService $updateProfile): JsonResponse
    {

        $userId = auth()->user()->id;
        $data = $updateProfile->updateProfile($request);
        $response = $this->profile->update(data: $data, id: $userId);
        $statusCode = isset($response['statusCode']) ? $response['statusCode'] : 501;
        return response()->json([$response], $statusCode);
    }
}
