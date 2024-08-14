<?php

namespace App\Tests\Entity;

use App\Entity\Category;
use App\Entity\Recipe;
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{
    public function testAddAndRemoveRecipe()
    {
        $category = new Category();
        $recipe = new Recipe();

        $category->addRecipe($recipe);

        $this->assertTrue($category->getRecipes()->contains($recipe));
        $this->assertSame($category, $recipe->getCategory());

        $category->removeRecipe($recipe);

        $this->assertFalse($category->getRecipes()->contains($recipe));
        $this->assertNull($recipe->getCategory());
    }
}
