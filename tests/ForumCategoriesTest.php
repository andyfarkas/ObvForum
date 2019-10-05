<?php

use Obv\ObvForum\Categories\Category;
use Obv\ObvForum\Categories\CategoryNotFoundException;
use Obv\ObvForum;
use Obv\Storage\InMemoryStorage;
use PHPUnit\Framework\TestCase;

class ForumCategoriesTest extends TestCase
{
    public function testCreateCategory_categoryName_returnsCreatedCategory()
    {
        $app = $this->createObvForum();
        $category = $app->createCategory("PHP Development");
        $this->assertInstanceOf(Category::class, $category);
    }

    public function testFindCategoryById_existingCategoryId_returnsThatCategory()
    {
        $app = $this->createObvForum();
        $category = $app->createCategory("PHP Development");
        $app->createCategory("C# Development");
        $app->createCategory("Java Development");
        $retrievedCategory = $app->findCategoryById($category->getId());
        $this->assertEquals($category, $retrievedCategory);
    }

    public function testFindCategoryById_nonExistingCategoryId_throwsCategoryNotFoundException()
    {
        $app = $this->createObvForum();

        $this->expectException(CategoryNotFoundException::class);
        $app->findCategoryById("id that does not exist");
    }

    public function testUpdateCategory_existingCategory_returnUpdatedCategory()
    {
        $app = $this->createObvForum();
        $app->createCategory("Java Development");
        $category = $app->createCategory("PHP Development");
        $changedCategory = new Category($category->getId(), 'PHP Development 2.0');
        $app->createCategory("C# Development");
        $app->updateCategory($changedCategory);
        $retrievedCategory = $app->findCategoryById($category->getId());

        $this->assertEquals($changedCategory, $retrievedCategory);
    }

    /**
     * @return ObvForum
     */
    public function createObvForum(): ObvForum
    {
        return new ObvForum(
            new InMemoryStorage(),
            new InMemoryStorage()
        );
    }

}