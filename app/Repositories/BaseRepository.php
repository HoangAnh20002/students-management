<?php

namespace App\Repositories;
use App\Repositories\Interfaces\RepositoryInterface;
use Faker\Provider\Base;
use Illuminate\Database\Eloquent\Model;
use function PHPUnit\Framework\returnValueMap;

class BaseRepository implements BaseRepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }
    public function all(){
        return $this->model->all();
    }
    public function find($id){
        return $this->model->find($id);
    }
    public function create(array $data){
        return $this->model->create($data);
    }
    public function update($id, array $data){
        $record = $this->model->find($id);
        return $record->updade($data);
    }
    public function delete($id)
    {
        return $this->model->destroy($id);
    }
}
