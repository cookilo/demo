<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class Repository implements AbstractRepositoryInterface
{
    protected $model;

    // Constructor to bind model to repo
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    // Get all instances of model
    public function paginate($param)
    {
        $result = $this->model->newQuery();
        return $result->paginate($param);
    }

    // Get all instances of model
    public function all()
    {
        return $this->model->all();
    }

    // create a new record in the database
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    // update record in the database
    public function update($id, array $attributes)
    {
        $result = $this->model->find($id);
        if ($result) {
            $result->update($attributes);
            return $result;
        }

        return false;
    }

    // remove record from the database
    public function delete($id)
    {
        return $this->model->find($id)->delete();
    }


    // show the record with the given id
    public function show($id)
    {
        return $this->model->findOrFail($id);
    }

    // Get the associated model
    public function getModel()
    {
        return $this->model;
    }

    // Set the associated model
    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    // Eager load database relationships
    public function with(array $relations)
    {
        return $this->model->with($relations);
    }

    public function find($id)
    {
        $result = $this->model->find($id);

        return $result;
    }

    public function search($fieldName, $param)
    {
        $result = $this->model->where($fieldName, 'LIKE', '%' . $param . '%');
        return $result;
    }

    public function where($fieldName, $operator, $value)
    {
        $result = $this->model->where($fieldName, $operator, $value)->get();

        return $result;
    }

    public function whereMultiple(array $matchThese)
    {
        $result = $this->model->where($matchThese)->get();

        return $result;
    }

    public function insert(array $data)
    {
        return $this->model->insert($data);
    }

}
