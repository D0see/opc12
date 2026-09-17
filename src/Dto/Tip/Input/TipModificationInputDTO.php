<?php 

namespace App\Dto\Tip\Input;
use Symfony\Component\Validator\Constraints as Assert;
class TipModificationInputDTO {

    public function __construct()
    {}

    #[Assert\Length(min: 1, minMessage: "The content must contain at least {{ limit }} symbols")]
    public ?string $content = null;

    #[Assert\All([
        new Assert\Type('integer'),
        new Assert\Range(min: 1, max: 12),
    ])]
    public ?array $monthsNums = null;

    public function getContent(): string
    {
        return $this->content;
    }

    public function getMonthsNums(): array
    {
        return $this->monthsNums;
    }
}