<?php

namespace App\Entity;

use App\Repository\FruitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FruitRepository::class)]
#[ORM\UniqueEntity('fruityvice_id')]
#[ORM\Index(name: 'fruityvice_id_index', columns: ['fruityvice_id'])]
#[ORM\Index(name: 'name_index', columns: ['name'])]
#[ORM\Index(name: 'family_index', columns: ['family'])]
class Fruit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column( unique: true)]
    private ?int $fruityvice_id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $family = null;

    #[ORM\Column(length: 255)]
    private ?string $fruit_order = null;

    #[ORM\Column(length: 255)]
    private ?string $genus = null;

    #[ORM\Column]
    private ?float $calories = null;

    #[ORM\Column]
    private ?float $fat = null;

    #[ORM\Column]
    private ?float $sugar = null;

    #[ORM\Column]
    private ?float $carbohydrates = null;

    #[ORM\Column]
    private ?float $protein = null;

    #[ORM\Column]
    private ?float $nutrition_sum = null;

    #[OneToOne(targetEntity: FavoriteFruits::class, mappedBy: 'fruit')]
    private FavoriteFruits|null $favoriteFruit = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFruityviceId(): ?int
    {
        return $this->fruityvice_id;
    }

    public function setFruityviceId(int $fruityvice_id): self
    {
        $this->fruityvice_id = $fruityvice_id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFamily(): ?string
    {
        return $this->family;
    }

    public function setFamily(string $family): self
    {
        $this->family = $family;

        return $this;
    }

    public function getFruitOrder(): ?string
    {
        return $this->fruit_order;
    }

    public function setFruitOrder(string $fruit_order): self
    {
        $this->fruit_order = $fruit_order;

        return $this;
    }

    public function getGenus(): ?string
    {
        return $this->genus;
    }

    public function setGenus(string $genus): self
    {
        $this->genus = $genus;

        return $this;
    }

    public function getCalories(): ?float
    {
        return $this->calories;
    }

    public function setCalories(float $calories): self
    {
        $this->calories = $calories;

        return $this;
    }

    public function getFat(): ?float
    {
        return $this->fat;
    }

    public function setFat(float $fat): self
    {
        $this->fat = $fat;

        return $this;
    }

    public function getSugar(): ?float
    {
        return $this->sugar;
    }

    public function setSugar(float $sugar): self
    {
        $this->sugar = $sugar;

        return $this;
    }

    public function getCarbohydrates(): ?float
    {
        return $this->carbohydrates;
    }

    public function setCarbohydrates(float $carbohydrates): self
    {
        $this->carbohydrates = $carbohydrates;

        return $this;
    }

    public function getProtein(): ?float
    {
        return $this->protein;
    }

    public function setProtein(float $protein): self
    {
        $this->protein = $protein;

        return $this;
    }

    public function getNutritionSum(): ?float
    {
        return $this->nutrition_sum;
    }

    public function setNutritionSum(float $nutrition_sum): self
    {
        $this->nutrition_sum = $nutrition_sum;

        return $this;
    }

    public function getFavoriteFruit(): FavoriteFruits
    {
        return $this->favoriteFruit;
    }
}
