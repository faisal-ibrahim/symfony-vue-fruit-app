<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\FavoriteFruitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FavoriteFruitRepository::class)]
class FavoriteFruit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Fruit::class)]
    #[ORM\JoinColumn(name: "fruit_id", referencedColumnName: "id", nullable: false)]
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

    public function setFruit(Fruit $fruit): self
    {
        $this->fruit = $fruit;

        return $this;
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
