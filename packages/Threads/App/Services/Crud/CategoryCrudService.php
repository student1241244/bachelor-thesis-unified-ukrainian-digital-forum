<?php
declare( strict_types = 1 );

namespace Packages\Threads\App\Services\Crud;

use Packages\Threads\App\Models\Category;

/**
 * Class CategoryCrudService
 */
class CategoryCrudService
{
    public function store(array $data): Category
    {
        $category = Category::create($data);

        return $category;
    }

    public function update(Category $category, array $data): Category
    {
        $category->update($data);

        return $category;
    }

    public function delete(Category $category): void
    {
        $category->delete($category);
    }
}
