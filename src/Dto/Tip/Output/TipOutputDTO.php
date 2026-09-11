<?php 

namespace App\Dto\Tip\Output;

class TipOutputDTO {
    public function __construct(
        public int $id,
        public string $content
    ) {

    }
}