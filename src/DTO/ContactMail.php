<?php
namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class ContactMail{
#[Assert\NotBlank]
#[Assert\Length(min:3,max:200)]
     public string $name="";
     #[Assert\Email]
     public string $email= "";
     #[Assert\NotBlank]
     #[Assert\Length(min:50, max:500)]
     public string $message= "";
}


