<?php

namespace App\Traits;

// شكل موحد لردود الـ API
trait ApiResponseTrait
{
    public function success($data = null, string $message = 'success', int $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data,
            'errors'  => null,
        ], $code);
    }

    // الرسالة الأول ثم الكود (كان الترتيب غلط وبيرجع 400 دايماً)
    public function error(string $message = 'error', int $code = 400, $errors = null)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data'    => null,
            'errors'  => $errors,
        ], $code);
    }
}
