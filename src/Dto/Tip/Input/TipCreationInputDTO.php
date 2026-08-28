<?php 

namespace App\Dto\Tip\Input;
use Symfony\Component\Validator\Constraints as Assert;
class TipCreationInputDTO {

    public function __construct()
    {}

    #[Assert\NotBlank(message: "field content is required")]
    #[Assert\Length(min: 1, minMessage: "The content must contain at least {{ limit }} symbols")]
    public string $content;

    #[Assert\NotBlank(message: "field monthsNums is required")]
    #[Assert\All([
        new Assert\Type('integer'),
        new Assert\Range(min: 1, max: 12),
    ])]
    public array $monthsNums;

    public function getContent(): string
    {
        return $this->content;
    }

    public function getMonthsNums(): array
    {
        return $this->monthsNums;
    }
}