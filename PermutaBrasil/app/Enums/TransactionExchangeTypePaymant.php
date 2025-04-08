<?php

namespace App\Enums;

enum TransactionExchangeTypePaymant: int
{   
    case OUTROS = 4;
    case MOEDA = 3;
    case SERVIÇO_PRODUTO = 2;
    case PRODUTOS = 1;
    case SERVIÇO = 0;
}
