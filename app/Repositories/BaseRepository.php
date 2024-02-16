<?php

namespace App\Repositories;
use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;


abstract class BaseRepository implements BaseRepositoryInterface
{
    public function __construct()
    {
        $this->setModel();
    }
    abstract protected function getModel();
    protected function setModel(){
        $this->model = $this->getModel();
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
        return $record->update($data);
    }
    public function delete($id)
    {
        return $this->model->destroy($id);
    }
    public function paginate($page){
        return $this->model->paginate($page);
    }
}
