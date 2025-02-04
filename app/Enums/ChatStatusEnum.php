<?php

namespace App\Enums;

enum ChatStatusEnum: string
{
    case Pendente = 'Pendente';
    case Ativo = 'Ativo';
    case Finalizado = 'Finalizado';
}
