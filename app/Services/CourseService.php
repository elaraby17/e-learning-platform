<?php
// app/Services/CourseService.php
namespace App\Services;

use App\Models\Category;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CourseService
{
    public function publishedCategories()
    {
        return Category::whereHas('courses', fn ($q) => $q->where('status', 'published'))->get();
    }

    public function paginatePublished(?string $categorySlug = null, int $perPage = 10)
    {
        return Course::with(['instructor', 'category'])
            ->where('status', 'published')
            ->when($categorySlug, fn ($q) => $q->whereHas(
                'category', fn ($c) => $c->where('slug', $categorySlug)
            ))
            ->paginate($perPage)
            ->withQueryString();
    }

    public function create(array $data, User $actor): Course
    {
        $data = $this->handleImage($data);

        // الأدمن بس هو اللي يختار instructor، الـ instructor دايماً نفسه
        $data['instructor_id'] = $actor->role === 'admin'
            ? ($data['instructor_id'] ?? $actor->id)
            : $actor->id;

        return Course::create($data);
    }

    public function update(Course $course, array $data, User $actor): Course
    {
        $data = $this->handleImage($data, $course->image);

        if ($actor->role !== 'admin') {
            unset($data['instructor_id']);
        }

        $course->update($data);

        return $course;
    }

    public function delete(Course $course): void
    {
        if ($course->image) {
            Storage::disk('public')->delete($course->image);
        }

        $course->delete();
    }

    private function handleImage(array $data, ?string $oldPath = null): array
    {
        if (($data['image'] ?? null) instanceof UploadedFile) {
            if ($oldPath) {
                Storage::disk('public')->delete($oldPath);
            }
            $data['image'] = $data['image']->store('course_images', 'public');
        } else {
            unset($data['image']);
        }

        return $data;
    }
}
