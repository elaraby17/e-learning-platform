<?php
// app/Services/CategoryService.php
namespace App\Services;

use App\Exceptions\CategoryHasCoursesException;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryService
{
    public function paginate(int $perPage = 10)
    {
        return Category::latest()->paginate($perPage);
    }

    public function create(array $data): Category
    {
        $data['slug'] = Str::slug($data['name']);

        return Category::create($data);
    }

    public function update(Category $category, array $data): Category
    {
        $data['slug'] = Str::slug($data['name']);
        $category->update($data);

        return $category;
    }

    public function delete(Category $category): void
    {
        if ($category->courses()->exists()) {
            throw new CategoryHasCoursesException();
        }

        $category->delete();
    }
}
