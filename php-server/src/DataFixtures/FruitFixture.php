<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Fruit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class FruitFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 15; $i++) {
            $fruit = new Fruit();

            $fruit->setName("Fruit-$i");
            $fruit->setFamily("X");
            $fruit->setGenus("X");
            $fruit->setFruityviceId($i);
            $fruit->setFruitOrder("X");
            $fruit->setCalories(10);
            $fruit->setFat(10);
            $fruit->setSugar(10);
            $fruit->setCarbohydrates(10);
            $fruit->setProtein(10);
            $fruit->setNutritionSum(50);

            $manager->persist($fruit);
        }

        $manager->flush();
    }
}
