<?php
namespace App\Repositories\Interfaces;

interface BaseRepositoryInterface
{
    public function all();

    public function find($id);

    public function create(array $data);

    public function update($id ,array $data);

    public function delete($id);

    public function paginate($page);
    public function updateOrInsert(string $table, array $data);

}
