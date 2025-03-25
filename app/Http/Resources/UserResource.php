<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->user_uuid,
            'first_name' => $this->first_name,
            'second_name' => $this->second_name,
            'lastname' => $this->first_lastname,
            'second_lastname' => $this->second_lastname,
            'email' => $this->email,
            'phone' => $this->phone,
            'dui' => $this->dui,
            'document' => $this->document,
            'country' => $this->country_data,
        ];
    }
}
