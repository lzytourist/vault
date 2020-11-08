<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CreditResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'from' => $this->from,
            'note' => $this->note,
            'amount' => $this->amount,
            'date' => Carbon::make($this->created_at)->diffForHumans()
        ];
    }
}
