<?php

namespace App\Repositories;

use App\Contracts\AuthInterface;
use App\Models\User;
use App\Models\UserDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Passport;

class AuthRepository implements AuthInterface
{

    public function register(array $data)
    {
        $user = User::create($data['credential']);
        $userId = $user->id;
        $userDetail = $data['userDetail'];
        $userDetail['user_id'] = $userId;
        UserDetail::create($userDetail);

        DB::table('role_user')->insert([
            'user_id' => $userId,
            'role_id' => $data['role']['roleId'],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $token  = $user->createToken('yes')->accessToken;
        $userDetail = $user->where('id', $user->id)->with(['userDetail', 'roles'])->first();

        return [
            'user' => $userDetail,
            'status' => true,
            'statusCode' => 200,
            'token' => $token,
            'message' => __("registered_successfully")
        ];
    }

    public function loginWithEmail(string $email, string $password, string|null|bool $rememberToken = false)
    {


        $credentials = Auth::attempt(['email' => $email, 'password' => $password], $rememberToken);
        if ($credentials) {
            $user  = Auth::user();
            $token  = $user->createToken('api')->accessToken;
            $userDetail = $user->where('id', $user->id)->with(['userDetail', 'roles'])->first();
            return [
                'user' => $userDetail,
                'status' => true,
                'statusCode' => 200,
                'token' => $token,
            ];
        }

        return [
            'user' => null,
            'status' => false,
            'statusCode' => 401,
            'token' => null,
            'message' => __("invalid_credentials")
        ];
    }

    public function loginWithMobileNumber(int $mobileNumber, string $password, string|null|bool $rememberToken = false)
    {
        $credentials = Auth::attempt(['mobile_number' => $mobileNumber, 'password' => $password], $rememberToken);

        if ($credentials) {
            $user  = Auth::user();
            $token  = $user->createToken('api')->accessToken;

            $userDetail = $user->where('id', $user->id)->with(['userDetail', 'roles'])->first();

            return [
                'user' => $userDetail,
                'status' => true,
                'statusCode' => 200,
                'token' => $token,
            ];
        }

        return [
            'user' => null,
            'status' => false,
            'statusCode' => 401,
            'token' => null,
            'message' => __("invalid_credentials")
        ];
    }

    public function logout()
    {

        $user = Auth::user();
        $user->token()->revoke();

        return [
            'status' => true,
            'statusCode' => 200,
            'message' => __('loged_out_successfully'),
        ];
    }
}
