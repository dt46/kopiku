<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'id_admin' => $this->id_admin,
            'fotoProduk' => $this->fotoProduk,
            'nama_foto_original' => $this->nama_foto_original,
            'namaProduk' => $this->namaProduk,
            'hargaProduk' => $this->hargaProduk,
            'stokProduk' => $this->stokProduk,
            'beratProduk' => $this->beratProduk,
            'deskripsiProduk' => $this->deskripsiProduk,
            'kategoriProduk' => $this->kategoriProduk,
        ];
    }
}
