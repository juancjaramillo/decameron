<?php
namespace App\Contracts;

use App\Models\Hotel;
use Illuminate\Support\Collection;

interface HotelRepositoryInterface
{
    public function all(): Collection;
    public function find(int $id): ?Hotel;
    public function create(array $data): Hotel;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}
