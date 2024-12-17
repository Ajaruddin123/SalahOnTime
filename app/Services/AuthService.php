<?php

namespace App\Services;


use App\Models\Role;
use App\Models\UserDetail;
use App\Traits\FileManagerTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    use FileManagerTrait;

    public function dataToRegister(Object $request): array
    {
        $credential = [
            'country_code' => $request->country_code ?? '+91',
            'mobile_number' => $request->mobile_number,
            'email' => $request->email,
            'password' => Hash::make($request->pass),
            'ip_address' => request()->ip()
        ];

        $userDetail = [
            'user_id' => 0,
            'name' => $request->name,
            'last_name' => $request->lname,
            'image' => $request->hasfile($request->image) ? $this->uploadFile(dir: 'profile/', image: $request->file('image')) : 'def.png',
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'postal_code' => $request->postal_code,
        ];

        $role = [
            'roleId' => Role::where('name', $request->user_type)->value('id'),
        ];

        return [
            'credential' => $credential,
            'userDetail' => $userDetail,
            'role' => $role
        ];
    }

    public function updateProfile(object $request): array
    {
        $oldImage = UserDetail::where('user_id', auth()->user()->id)->value('image');

        return [
            'name' => $request->name,
            'last_name' => $request->lname,
            'image' => $request->hasfile($request->image) ? $this->updateFile(dir: 'profile/', oldImage: $oldImage, image: $request->file('image')) : $oldImage,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'postal_code' => $request->postal_code,
            'updated_at' => Carbon::now(),
        ];
    }
}
