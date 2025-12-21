<?php
namespace App\Services;

use App\DTOs\LandDTO;
use App\Models\Land;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class LandService
{
    public function store(LandDTO $dto): Land
    {
        try {
            return DB::transaction(function () use ($dto) {
                return Land::create([
                    'title'       => $dto->title,
                    'land_location'   => $dto->landLocation,
                    'dolil_no'        => $dto->dolilNo,
                    'dag_no'       => $dto->dagNo,
                    'buying_price'        => $dto->buyingPrice,
                    'purchase_status'   => $dto->purchaseStatus,
                ]);
            });
        } catch (Throwable $e) {
            throw $e;
        }
    }
}
