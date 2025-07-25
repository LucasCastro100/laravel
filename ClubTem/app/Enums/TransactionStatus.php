<?php

namespace App\Enums;

enum TransactionStatus: int
{
    case PAGA = 3;
    case AGUARDANDO = 2;
    case CANCELADA = 1;
    case FALHA = 0;
}
