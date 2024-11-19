<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'message' => $this->message,
            'attachment' => $this->attachment,
            'user_id' => $this->user_id,
            'client_name' => $this->client->name,
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}
