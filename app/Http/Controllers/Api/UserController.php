<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\UpdateProfileRequest;
use App\Http\Requests\Api\ChangePasswordRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserController extends AuthController
{
    /**
     * Show Profile.
     *
     * @return JsonResponse
     */
    public function show(): JsonResponse
    {
        $user = response()->json(Auth::user())->getData();
        return $this->responseSuccess(Response::HTTP_OK, $user);
    }

    /**
     * Update Profile
     *
     * @param UpdateProfileRequest $request
     * @return JsonResponse
     */
    public function update(UpdateProfileRequest $request): JsonResponse
    {
        if (!empty(Auth::user()->confirmed)) return $this->responseError(Response::HTTP_BAD_REQUEST, __('message.permission'), new \stdClass());
        $data = $request->all();
        if ($request->has('avatar')) {
            $data['avatar'] = $this->userRepository->getUrlAvatar($request->file('avatar'));
        }
        $user = $this->userRepository->update($data, Auth::id());
        return $this->responseSuccess(Response::HTTP_ACCEPTED, $user);
    }

    /**
     * changePassword
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        if(Auth::user()->getAuthPassword() != bcrypt($request->password_old)){
            return $this->responseError(Response::HTTP_BAD_REQUEST, 'パスワードが間違っています。', new \stdClass());
        }
        $data = $request->only('password');
        $user = $this->userRepository->update($data, Auth::id());
        return $this->responseSuccess(Response::HTTP_ACCEPTED, $user);
    }
}
