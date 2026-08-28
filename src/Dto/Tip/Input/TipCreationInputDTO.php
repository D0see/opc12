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
    #[Assert\Count(
        min: 1,
        max: 12,
        minMessage: 'You must specify at least {{ limit }} month',
        maxMessage: 'You cannot specify more than {{ limit }} month',
    )]
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