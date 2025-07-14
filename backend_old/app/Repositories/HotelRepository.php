<?php
namespace App\Repositories;

use App\Contracts\HotelRepositoryInterface;
use App\Models\Hotel;
use Illuminate\Support\Collection;

class HotelRepository implements HotelRepositoryInterface
{
    public function all(): Collection
    {
        return Hotel::all();
    }

    public function find(int $id): ?Hotel
    {
        return Hotel::find($id);
    }

    public function create(array $data): Hotel
    {
        return Hotel::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $hotel = $this->find($id);
        return $hotel ? $hotel->update($data) : false;
    }

    public function delete(int $id): bool
    {
        $hotel = $this->find($id);
        return $hotel ? $hotel->delete() : false;
    }
}
