<?php

namespace App\Dto\Tip\Mapper;

use App\Dto\Tip\Output\TipOutputDTO;
use App\Entity\Tip;

class TipMapper {
    
    public function TipToOutputDTO(Tip $tip): TipOutputDTO
    {
        return new TipOutputDTO(
            id: $tip->getId(),
            content: $tip->getContent()
        );
    }
}