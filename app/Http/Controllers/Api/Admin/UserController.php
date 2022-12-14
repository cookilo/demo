<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Requests\Api\ChangePasswordRequest;
use App\Http\Requests\Api\StoreProfileRequest;
use App\Http\Requests\Api\UpdateProfileRequest;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Prettus\Validator\Exceptions\ValidatorException;
use Symfony\Component\HttpFoundation\Response;

class UserController extends AuthController
{
    /**
     * get list users.
     *
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        $users = $this->userRepository->getUsersRoleUser();
        return $this->responseSuccess(Response::HTTP_OK, $users);
    }

    /**
     * get profile.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $user = $this->userRepository->find($id);
        return $this->responseSuccess(Response::HTTP_OK, $user);
    }

    /**
     * Register a User.
     *
     * @param StoreProfileRequest $request
     * @return JsonResponse
     */
    public function store(StoreProfileRequest $request): JsonResponse
    {
        $data = $request->all();
        if ($request->has('avatar')) {
            $data['avatar'] = $this->userRepository->getUrlAvatar($request->file('avatar'));
        }
        $user = $this->userRepository->create($data);
        $user->assignRole('user');
        return $this->responseSuccess(Response::HTTP_CREATED, $user);
    }

    /**
     * update profile.
     *
     * @param UpdateProfileRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(UpdateProfileRequest $request, $id): JsonResponse
    {
        $data = $request->all();
        if ($request->has('avatar')) {
            $data['avatar'] = $this->userRepository->getUrlAvatar($request->file('avatar'));
        }
        $user = $this->userRepository->update($data, $id);
        return $this->responseSuccess(Response::HTTP_ACCEPTED, $user);
    }

    /**
     * delete profile.
     *
     * @param $id
     * @return JsonResponse
     */
    public function delete($id): JsonResponse
    {
        $user = $this->userRepository->delete($id);
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
        $data = $request->only('password');
        $user = $this->userRepository->update($data, $request->id);
        return $this->responseSuccess(Response::HTTP_ACCEPTED, $user);
    }
}
