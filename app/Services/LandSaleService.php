<?php
namespace App\Services;

use App\DTOs\LandPurchaseDTO;
use App\DTOs\LandSaleDTO;
use App\Models\LandPurchase;
use App\Models\LandSale;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class LandSaleService
{
    public function store(LandSaleDTO $dto): LandSale
    {
        try {
            return DB::transaction(function () use ($dto) {
                return LandSale::create([
                    'land_id'   => $dto->landId,
                    'buyer_name'   => $dto->buyerName,
                    'mobile'        => $dto->mobile,
                    'address'       => $dto->address,
                    'nid_no'        => $dto->nidNo,
                    'nid_file'      => $dto->nidFile,
                    'selling_price'  => $dto->sellingPrice,
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
