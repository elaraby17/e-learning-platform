<?php
// app/Http/Controllers/CategoryController.php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(private CategoryService $categoryService) {}

    public function index()
    {
        $categories = $this->categoryService->paginate();

        return view('admins.category.allCategory', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string|max:1000',
        ]);

        $this->categoryService->create($data);

        return redirect()->route('admin.categories.index')->with('success', 'تم إضافة القسم بنجاح.');
    }

    public function edit(Category $category)
    {
        $categories = $this->categoryService->paginate();

        return view('admins.category.edit', compact('category', 'categories'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255|unique:categories,name,'.$category->id,
            'description' => 'nullable|string|max:1000',
        ]);

        $this->categoryService->update($category, $data);

        return redirect()->route('admin.categories.index')->with('success', 'تم تحديث القسم بنجاح.');
    }

    public function destroy(Category $category)
    {
        $this->categoryService->delete($category);

        return redirect()->route('admin.categories.index')->with('success', 'تم حذف القسم بنجاح.');
    }
}
