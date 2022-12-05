<?php

namespace App\Modules\User\Repository;

use App\Modules\User\User;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * UserRepository Eloquent
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepositoryInterface
{

    protected $fieldSearchable = [
        'name' => 'like'
    ];

    public function boot()
    {
        $this->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }
}
