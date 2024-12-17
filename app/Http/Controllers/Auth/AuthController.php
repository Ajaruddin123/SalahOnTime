<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\AuthInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginWithEmailRequest;
use App\Http\Requests\LoginWithMobileNumberRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function __construct(protected readonly AuthInterface $authInterFace) {}

    public function register(RegisterRequest $regRequest, AuthService $authService)
    {
        try {
            $data = $authService->dataToRegister($regRequest);
            $response = $this->authInterFace->register($data);
            $statusCode = isset($response['statusCode']) ? $response['statusCode'] : 501;;
        } catch (ValidationException $e) {
            $response = $e->getMessage();
            $statusCode = 501;
        }

        return response()->json($response, $statusCode);
    }

    public function loginWithEmail(LoginWithEmailRequest $loginWithEmailRequest)
    {

        try {
            $response = $this->authInterFace->loginWithEmail(email: $loginWithEmailRequest->email, password: $loginWithEmailRequest->password);
            $statusCode = isset($response['statusCode']) ? $response['statusCode'] : 501;
        } catch (ValidationException $e) {
            $response = $e->getMessage();
            $statusCode = 501;
        }
        return response()->json($response, $statusCode);
    }

    public function loginWithMobileNumber(LoginWithMobileNumberRequest $loginWithMobileRequest)
    {

        try {
            $response = $this->authInterFace->loginWithMobileNumber(mobileNumber: $loginWithMobileRequest->mobile_number, password: $loginWithMobileRequest->password);
            $statusCode = isset($response['statusCode']) ? $response['statusCode'] : 501;
        } catch (ValidationException $e) {
            $response = $e->getMessage();
            $statusCode = 501;
        }
        return response()->json($response, $statusCode);
    }

    public function logout()
    {

        try {
            $response = $this->authInterFace->logout();
            $statusCode = isset($response['statusCode']) ? $response['statusCode'] : 501;
        } catch (ValidationException $e) {
            $response = $e->getMessage();
            $statusCode = 501;
        }
        return response()->json($response,  $statusCode);
    }
}
