<?php

namespace App\Entity;

use App\Repository\FavoriteFruitsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FavoriteFruitsRepository::class)]
class FavoriteFruits
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(targetEntity: Fruit::class, inversedBy: 'favoriteFruit')]
    #[ORM\JoinColumn(name: 'fruit_id', referencedColumnName: 'id', nullable:false)]
    private Fruit $fruit;

    #[ORM\Column]
    private ?int $user_id = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFruit(): Fruit
    {
        return $this->fruit;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }
}
