<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Usuario extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'email' => $this->email,
            'password' => $this->password,
            'nivel_usuario_id' => $this->nivel_usuario_id
        ];
    }
}
