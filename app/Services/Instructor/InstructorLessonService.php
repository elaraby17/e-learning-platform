<?php

namespace App\Services\Instructor;

use App\Models\Lesson;

class InstructorLessonService
{
    public function create(array $data): Lesson
    {
        $data = $this->prepare($data);


        if (empty($data['order_number'])) {
            $data['order_number'] = (Lesson::where('section_id', $data['section_id'])->max('order_number') ?? 0) + 1;
        }

        return Lesson::create($data);
    }

    public function update(Lesson $lesson, array $data): Lesson
    {
        $lesson->update($this->prepare($data));

        return $lesson;
    }

    public function delete(Lesson $lesson): void
    {
        $lesson->delete();
    }


    private function prepare(array $data): array
    {
        if (! empty($data['video_url']) && $videoId = $this->youtubeId($data['video_url'])) {
            $data['video_url'] = "https://www.youtube.com/embed/{$videoId}";
            $data['video_thumbnail'] ??= "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg";
        }

        return $data;
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
