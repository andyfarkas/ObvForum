<?php

class ForumCategoriesTests extends PHPUnit_Framework_TestCase
{
    public function testCreateCategory_categoryName_returnsCreatedCategory()
    {
        $app = new \ObvForum\ObvForum();
        $category = $app->createCategory("PHP Development");
        $this->assertInstanceOf(ObvForum\Categories\Category::class, $category);
    }

    public function testFindCategoryById_existingCategoryId_returnsThatCategory()
    {
        $app = new \ObvForum\ObvForum();
        $category = $app->createCategory("PHP Development");
        $app->createCategory("C# Development");
        $app->createCategory("Java Development");
        $retrievedCategory = $app->findCategoryById($category->getId());
        $this->assertEquals($category, $retrievedCategory);
    }

    public function testFindCategoryById_nonExistingCategoryId_throwsCategoryNotFoundException()
    {
        $app = new \ObvForum\ObvForum();

        $this->expectException(\ObvForum\Categories\CategoryNotFoundException::class);
        $app->findCategoryById("id that does not exist");
    }

    public function testUpdateCategory_existingCategory_returnUpdatedCategory()
    {
        $app = new \ObvForum\ObvForum();
        $app->createCategory("Java Development");
        $category = $app->createCategory("PHP Development");
        $changedCategory = new \ObvForum\Categories\Category($category->getId(), 'PHP Development 2.0');
        $app->createCategory("C# Development");
        $app->updateCategory($changedCategory);
        $retrievedCategory = $app->findCategoryById($category->getId());

        $this->assertEquals($changedCategory, $retrievedCategory);
    }

}