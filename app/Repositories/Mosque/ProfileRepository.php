<?php

namespace App\Repositories\Mosque;

use App\Contracts\Mosque\ProfileInterface;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ProfileRepository implements ProfileInterface
{
    public function __construct(
        protected readonly User $user,
        protected readonly UserDetail $userDetail
    ) {}
    public  function add(array|object $data): string|object
    {
        return collect([]);
    }

    public function update(array|object $data, string|int $id): string|object|array
    {
        $this->userDetail->where('user_id', $id)->update($data);
        return [
            'statusCode' => 200,
            'message' => __('profile_updated_sucessfully'),
        ];
    }

    public function delete(array $params): bool
    {
        return true;
    }

    public function getAll(array $params, array $relation = [], int $pageLength): Collection|LengthAwarePaginator
    {
        return collect([]);
    }

    public function getWhereFirst(array $params, array $relation = []): array
    {
        $user = $this->user->where($params)->with($relation)->first();
        if (!$user) {
            return [
                'statusCode' => 204,
                'message' => __('data_not_found'),
            ];
        }
        return [
            'statusCode' => 200,
            'user' => $user,
        ];
    }

    public function getWhereAll(array $params, array $relation = []): array
    {
        return [];
    }
}
