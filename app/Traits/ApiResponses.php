<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponses
{
    /**
     * Build a successful JSON response with a consistent envelope.
     *
     * @param  mixed  $data
     * @param  int  $status
     * @return \Illuminate\Http\JsonResponse
     */
    protected function success($data = null, int $status = 200): JsonResponse
    {
        $payload = [
            'success' => true,
        ];

        if (!is_null($data)) {
            $resolved = method_exists($data, 'resolve')
                ? $data->resolve(request())
                : $data;

            if (is_array($resolved) && array_key_exists('data', $resolved)) {
                $payload['data'] = $resolved['data'];

                if (array_key_exists('links', $resolved)) {
                    $payload['links'] = $resolved['links'];
                }

                if (array_key_exists('meta', $resolved)) {
                    $payload['meta'] = $resolved['meta'];
                }
            } else {
                $payload['data'] = $resolved;
            }
        }

        return response()->json($payload, $status);
    }

    /**
     * Build an error JSON response with a consistent envelope.
     *
     * @param  string  $message
     * @param  int  $status
     * @param  array  $extra
     * @return \Illuminate\Http\JsonResponse
     */
    protected function error(string $message, int $status = 400, array $extra = []): JsonResponse
    {
        return response()->json(array_merge([
            'success' => false,
            'message' => $message,
        ], $extra), $status);
    }
}
