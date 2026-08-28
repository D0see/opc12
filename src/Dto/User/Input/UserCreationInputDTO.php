<?php 

namespace App\Dto\User\Input;
use Symfony\Component\Validator\Constraints as Assert;
class UserCreationInputDTO {

    public function __construct()
    {}

    #[Assert\NotBlank(message: "field username is required")]
    #[Assert\Length(min: 1, max: 255, minMessage: "The username must contain at least {{ limit }} symbols", maxMessage: "The username must contain a maximum of {{ limit }} symbols")]
    public string $username;

    #[Assert\NotBlank(message: "field password is required")]
    #[Assert\Length(min: 1, max: 255, minMessage: "The password must contain at least {{ limit }} symbols", maxMessage: "The password must contain a maximum of {{ limit }} symbols")]
    public string $password;

    #[Assert\NotBlank(message: "field postalCode is required")]
    #[Assert\Length(min: 5, max: 5, minMessage: "The postalCode must contain {{ limit }} numbers", maxMessage: "The postalCode must contain {{ limit }} numbers")]
    public string $postalCode;

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }


    public function getPostalCode(): string
    {
        return $this->postalCode;
    }
}