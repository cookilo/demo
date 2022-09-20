<?php

namespace App\Repositories;

use App\Models\User;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class UserRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function getUsersRoleUser()
    {
        return $this->whereHas('roles', function ($query) {
            return $query->where('name', '=', 'user');
        })
            ->with('roles')
            ->orderBy('created_at', 'DESC')
            ->paginate(10);
    }

    public function findUserWithRole($id)
    {
        return $this->with('roles')->find($id);
    }
}
