<?php
namespace App\DTOs;

use Illuminate\Http\Request;

class LandDTO
{
    public function __construct(
        public string $title,
        public string $landLocation,
        public string $dolilNo,
        public string $dagNo,
        public string $buyingPrice,
        public ?string $purchaseStatus,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            title: $request->input('title'),
            landLocation: $request->input('land_location'),
            dolilNo: $request->input('dolil_no'),
            dagNo: $request->input('dag_no'),
            buyingPrice: $request->input('buying_price'),
            purchaseStatus: $request->input('purchase_status', 'in-progress'),
        );
    }
}
