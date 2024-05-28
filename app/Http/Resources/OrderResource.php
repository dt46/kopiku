<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id' => $this->id,
            'user_id' => $this->user_id,
            'product_id' => $this->product_id,
            'ongkos_kirim' => $this->ongkos_kirim,
            'total_harga' => $this->total_harga,
            'banyak_item' => $this->banyak_item,
            'nama_file_original' => $this->nama_file_original,
            'bukti_pembayaran' => $this->bukti_pembayaran,
            'no_resi' => $this->no_resi,
            'status' => $this->status,
        ];
    }
}
