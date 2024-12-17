<?php

namespace App\Contracts;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

interface MainInterface
{
    /**
     * @param array $data should be in kay and value pair structure ex params = ['name'=>'John Doe']
     * @return string|object
     */
    public function add(array|object $data): string|object;

    /**
     * Undocumented function
     *
     * @param array|object $data 
     * @param string|integer $id
     * @return string|object|array
     */
    public function update(array|object $data, string|int $id): string|object|array;


    /**   
     * @param array $params
     * @return boolean
     */
    public function delete(array $params): bool;

    /**    
     * @param array $params
     * @param array $relation
     * @return Collection|LengthAwarePaginator
     */
    public function getAll(array $params, array $relation = [], int $pageLength): Collection|LengthAwarePaginator;

    /**
     * @param array $params 
     * @param array $relation
     * @return array
     */
    public function getWhereFirst(array $params, array $relation = []): array;

    public function getWhereAll(array $params, array $relation = []): array;
}
