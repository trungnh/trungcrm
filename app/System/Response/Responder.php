<?php

namespace App\System\Response;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

class Responder
{
    /**
     * Response Service unauthorized.
     * @param string $message
     * @param array $header
     * @return ResponseFactory|Response
     */
    public static function unauthorized ($message = 'unauthorized', array $header = [])
    {
        return self::response($message, 401, $header);
    }

    /**
     * Response Service timeout.
     * @param string $message
     * @param array $header
     * @return ResponseFactory|Response
     */
    public static function timeout ($message = 'request_timeout', array $header = [])
    {
        return self::response($message, 408, $header);
    }

    /**
     * Response Service methodFalse.
     * @param string $message
     * @param array $header
     * @return ResponseFactory|Response
     */
    public static function methodFalse ($message = 'method_not_allowed', array $header = [])
    {
        return self::response($message, 405, $header);
    }

    /**
     * Response Service forbidden.
     * @param string $message
     * @param array $header
     * @return ResponseFactory|Response
     */
    public static function forbidden ($message = 'forbidden', array $header = [])
    {
        return self::response($message, 403, $header);
    }

    /**
     * Response Service unavailable.
     * @param string $message
     * @param array $header
     * @return ResponseFactory|Response
     */
    public static function unavailable ($message = 'service_unavailable', array $header = [])
    {
        return self::response($message, 503, $header);
    }

    /**
     * Response Internal Server Error.
     * @param string $message
     * @param array $header
     * @return ResponseFactory|Response
     */
    public static function error ($message = 'internal_server_error', array $header = [])
    {
        return self::response($message, 500, $header);
    }

    /**
     * Response 404 not found.
     * @param string $message
     * @param array $header
     * @return ResponseFactory|Response
     */
    public static function notFound ($message = 'not_found', array $header = [])
    {
        return self::response($message, 404, $header);
    }

    /**
     * Response invalid.
     * @param array $errors
     * @param array $header
     * @return ResponseFactory|Response
     */
    public static function invalid (array $errors,  array $header = [])
    {
        return self::response(['code' => 422, 'message' => $errors], 400, $header);
    }

    /**
     * Response data.
     * @param array|object $data
     * @param array $header
     * @return ResponseFactory|Response
     */
    public static function data ($data, array $header = [])
    {
        return self::response($data, 200, $header);
    }

    /**
     * Auto content type response by Accept header request.
     * @param array|object $data
     * @param int $status
     * @param array $header
     * @return ResponseFactory|Response
     */
    public static function response ($data = [], $status = 200, array $header = [])
    {
        // Cast object to array.
        if ($data instanceof Collection or $data instanceof Model) {
            $data =  $data->toArray();
        }

        // Format body response.
        $content = static::body($data);

        // Add more header response info.
        $header = static::header($header);

        // Response as access defined.
        foreach (request()->getAcceptableContentTypes() as $type) {
            switch ($type) {
                case 'application/xml':
                case 'text/xml':
                case 'xml':
                    // Not support.
                    break;

                case 'text/html':
                    // Not support.
                    break;

                case 'application/json':
                case 'application/x-javascript':
                case 'text/json':
                case 'text/x-json':
                case 'text/javascript':
                case 'text/x-javascript':
                case 'json':
                default:
                    return response()->json($content, $status, $header);
                    break;
            }
        }

        return response()->json($content, $status, $header);
    }

    /**
     * Format body response.
     * @param mixed $data
     * @return array
     */
    private static function body ($data = [])
    {
        // Do nothing. Sometimes life is very simple :>
        return $data;
    }

    /**
     * Update header before response.
     * @param $header
     * @return array
     */
    private static function header ($header)
    {
        // TODO: updating...
        $header['Content-Language'] = app()->getLocale();
        $header['X-Powered-By'] = config('main.api_auth');
        $header['X-Version'] = config('main.api_version');

        return $header;
    }
}
