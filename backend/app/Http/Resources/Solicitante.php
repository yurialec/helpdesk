<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Solicitante extends JsonResource
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
            'id' => $this->id,
            'nome' => $this->nome,
            'email' => $this->email,
            'password' => $this->password,
            'nivel_usuario_id' => $this->nivel_usuario_id
        ];
    }
}
