<?php

namespace App\Services\Instructor;

use App\Models\Lesson;

class InstructorLessonService
{
    public function create(array $data): Lesson
    {
        // لو الرابط يوتيوب حوله لرابط embed وهات الصورة المصغرة
        if (! empty($data['video_url']) && $videoId = $this->youtubeId($data['video_url'])) {
            $data['video_url'] = "https://www.youtube.com/embed/{$videoId}";
            $data['video_thumbnail'] ??= "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg";
        }

        // لو الترتيب مش متحدد، حطه آخر درس في السيكشن
        if (empty($data['order_number'])) {
            $data['order_number'] = (Lesson::where('section_id', $data['section_id'])->max('order_number') ?? 0) + 1;
        }

        return Lesson::create($data);
    }

    public function delete(Lesson $lesson): void
    {
        $lesson->delete();
    }

    private function youtubeId(string $url): ?string
    {
        $found = preg_match(
            '/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/',
            $url,
            $matches
        );

        return $found ? $matches[1] : null;
    }
}
