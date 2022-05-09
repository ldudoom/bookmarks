<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CategoriesFixtures extends Fixture
{

    public const REFERENCE_MOVISTAR_CATEGORY = 'movistar-category';

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $category = new Category();
        $category->setName('Movistar');
        $category->setColor('blue');
        $manager->persist($category);
        $manager->flush();
        $this->addReference(self::REFERENCE_MOVISTAR_CATEGORY, $category);

        for ($i = 0; $i < 5; $i++) {
            $category = new Category();
            $category->setName($faker->word);
            $category->setColor($faker->colorName);
            $manager->persist($category);
        }
        $manager->flush();

    }
}
