<?php

namespace App\Services;

use App\Helpers\ImageHelper;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(
        protected UserRepositoryInterface $repository
    ) {
    }

    public function paginate($perPage = 10, $search = null)
    {
        return $this->repository->paginate(
            $perPage,
            $search
        );
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function store(array $data)
    {
        DB::beginTransaction();

        try {

            if (!empty($data['profile_image'])) {
                $data['profile_image'] = ImageHelper::upload(
                    $data['profile_image'],
                    'users'
                );
            }

            $data['password'] = Hash::make($data['password']);

            $role = $data['role'];

            unset($data['role']);

            $user = $this->repository->create($data);

            $user->syncRoles($role);

            DB::commit();

            return $user;

        } catch (\Throwable $e) {

            DB::rollBack();

            throw $e;
        }
    }

    public function update($id, array $data)
    {
        DB::beginTransaction();

        try {

            $user = $this->repository->find($id);

            if (!empty($data['profile_image'])) {

                ImageHelper::delete($user->profile_image);

                $data['profile_image'] = ImageHelper::upload(
                    $data['profile_image'],
                    'users'
                );
            }

            if (!empty($data['password'])) {

                $data['password'] = Hash::make($data['password']);

            } else {

                unset($data['password']);
            }

            $role = $data['role'];

            unset($data['role']);

            $this->repository->update($user, $data);

            $user->syncRoles($role);

            DB::commit();

            return true;

        } catch (\Throwable $e) {

            DB::rollBack();

            throw $e;
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {

            $user = $this->repository->find($id);

            ImageHelper::delete($user->profile_image);

            $this->repository->delete($user);

            DB::commit();

            return true;

        } catch (\Throwable $e) {

            DB::rollBack();

            throw $e;
        }
    }

}
