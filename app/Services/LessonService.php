<?php
// app/Services/LessonService.php
namespace App\Services;

use App\Models\Lesson;

class LessonService
{
public function create(array $data): Lesson
{
    if (! empty($data['video_url']) && $videoId = $this->youtubeId($data['video_url'])) {
        $data['video_url'] = "https://www.youtube.com/embed/{$videoId}";
        $data['video_thumbnail'] ??= "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg";
    }

    if (empty($data['order_number'])) {
        $data['order_number'] = (Lesson::where('section_id', $data['section_id'])->max('order_number') ?? 0) + 1;
    }

    return Lesson::create($data);
}

private function youtubeId(string $url): ?string
{
    return preg_match(
        '/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/',
        $url,
        $m
    ) ? $m[1] : null;
}
}
