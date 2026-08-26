<?php

namespace App\Enums;

enum EquipmentCategory: string
{
    case Camera = 'camera';
    case Lente = 'lente';
    case Audio = 'audio';
    case Iluminacao = 'iluminacao';
    case Estabilizacao = 'estabilizacao';
    case Drone = 'drone';
    case Edicao = 'edicao';
    case Streaming = 'streaming';
    case Outro = 'outro';

    public function label(): string
    {
        return match ($this) {
            self::Camera => 'Câmera',
            self::Lente => 'Lente',
            self::Audio => 'Áudio',
            self::Iluminacao => 'Iluminação',
            self::Estabilizacao => 'Estabilização',
            self::Drone => 'Drone',
            self::Edicao => 'Edição',
            self::Streaming => 'Streaming',
            self::Outro => 'Outro',
        };
    }
}
