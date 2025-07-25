<?php

namespace App\Enums;

enum SignatureStatus: int
{    
    case ATIVADA = 3;
    case SESPENÇA = 2;
    case CANCELADA = 1;
    case DESATIVADA = 0;  
}