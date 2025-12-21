<?php

namespace App\DTOs;

use Illuminate\Http\Request;

class LandSaleDTO
{
    public function __construct(

        public string $landId,
        public string $buyerName,
        public string $mobile,
        public string $address,
        public string $nidNo,
        public ?string $nidFile,
        public float  $sellingPrice,
    )
    {
    }

    public static function fromRequest(Request $request, ?string $nidFilePath = null): self
    {
        return new self(
            landId: $request->input('land_id'),
            buyerName: $request->input('buyer_name'),
            mobile: $request->input('mobile'),
            address: $request->input('address'),
            nidNo: $request->input('nid_no'),
            nidFile: $nidFilePath,
            sellingPrice: $request->input('selling_price')
        );
    }
}
