<?php

namespace App\tests;
use App\Entity\Category;
use App\Entity\Recipe;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{
    public function testGettersAndSetters()
    {
        $category = new Category();
        $name = 'Desserts';

        $category->setName($name);

        $this->assertSame($name, $category->getName());
    }
    public function testOnPrePersist()
{
    $category = new Category();
    $category->onPrePersist();

    $this->assertInstanceOf(DateTimeImmutable::class, $category->getCreatedAt());
    $this->assertInstanceOf(DateTimeImmutable::class, $category->getUpdatedAt());
}

public function testOnPreUpdate()
{
    $category = new Category();
    $category->onPreUpdate();

    $this->assertInstanceOf(DateTimeImmutable::class, $category->getUpdatedAt());
}


public function testAddAndRemoveRecipe()
{
    $category = new Category();
    $recipe = new Recipe();

    $category->addRecipe($recipe);
    $this->assertSame($category, $recipe->getCategory());
    $this->assertCount(1, $category->getRecipes());

    $category->removeRecipe($recipe);
    $this->assertNull($recipe->getCategory());
    $this->assertCount(0, $category->getRecipes());
}


}
