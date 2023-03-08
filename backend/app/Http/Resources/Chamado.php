<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Chamado extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'descricao_chamado' => $this->descricao_chamado,
            'solicitante_id' => $this->solicitante_id,
            'chamado_statu_id' => $this->chamado_statu_id,
            'historico_chamado_id' => $this->historico_chamado_id ? $this->historico_chamado_id : null,
        ];
    }
}
