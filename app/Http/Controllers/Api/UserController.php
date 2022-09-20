<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\UpdateProfileRequest;
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

        $user = $this->userRepository->update($request->all(), Auth::id());
        return $this->responseSuccess(Response::HTTP_ACCEPTED, $user);
    }
}
