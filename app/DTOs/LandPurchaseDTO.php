<?php
namespace App\DTOs;

use Illuminate\Http\Request;

class LandPurchaseDTO
{
    public function __construct(
        public string $landId,
        public string $sellerName,
        public string $mobile,
        public string $address,
        public string $nidNo,
        public ?string $nidFile,
        public float $buyingPrice,
    ) {}

    public static function fromRequest(Request $request,int $landId, ?string $nidFilePath = null): self
    {
        return new self(
            landId: $landId,
            sellerName: $request->input('seller_name'),
            mobile: $request->input('mobile'),
            address: $request->input('address'),
            nidNo: $request->input('nid_no'),
            nidFile: $nidFilePath,
            buyingPrice: $request->input('buying_price'),
        );
    }
}
