<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'order_number' => strtotime($this->order_number),
            'user_id' => $this->user_id,
            'discount_code' => $this->discount_code,
            'sub_total' => $this->sub_total,
            'discount_amount' => $this->discount_amount,
            'total_shippings_charge' => $this->total_shippings_charge,
            'total_amount' => $this->total_amount,
            'total_product_cost' => $this->total_product_cost,
            'total_returned_amount' => $this->total_returned_amount,
            'total_final_amount' => $this->total_final_amount,
            'status' => $this->status,
            'total_merchant_commission' => $this->total_merchant_commission,
            'notes' => $this->notes,
            'refund_status' => $this->refund_status,
            'feedback_text' => $this->feedback_text,
            'feedback_number' => $this->feedback_number,
            'created_at' => dateFormat($this->created_at, 1),
            'details' => $this->orderDetails,
            'user' => $this->user,
            'address' => $this->address,
        ];
    }
    
}
