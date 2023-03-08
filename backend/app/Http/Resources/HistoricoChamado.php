<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HistoricoChamado extends JsonResource
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
            'chamado_id' => $this->descricao_chamado,
            'chamado_statu_id' => $this->solicitante_id,
            'usuario_id' => $this->chamado_statu_id
        ];
    }
}
