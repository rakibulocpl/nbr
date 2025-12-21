<?php
namespace App\Services;

use App\DTOs\LandPurchaseDTO;
use App\Models\LandPurchase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class LandPurchaseService
{
    public function store(LandPurchaseDTO $dto): LandPurchase
    {
        try {
            return DB::transaction(function () use ($dto) {
                return LandPurchase::create([
                    'land_id'       => $dto->landId,
                    'seller_name'   => $dto->sellerName,
                    'mobile'        => $dto->mobile,
                    'address'       => $dto->address,
                    'nid_no'        => $dto->nidNo,
                    'nid_file'      => $dto->nidFile,
                    'buying_price'  => $dto->buyingPrice,
                ]);
            });
        } catch (Throwable $e) {
            if ($dto->nidFile) {
                Storage::disk('public')->delete($dto->nidFile);
            }
            throw $e;
        }
    }
}
