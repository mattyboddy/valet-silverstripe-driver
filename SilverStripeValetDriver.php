<?php

namespace Valet\Drivers\Custom;

use Valet\Drivers\ValetDriver;

class SilverStripeValetDriver extends ValetDriver
{
    /**
     * Determine if the driver serves the request.
     *
     * @param  string  $sitePath
     * @param  string  $siteName
     * @param  string  $uri
     * @return bool
     */
    public function serves(string $sitePath, string $siteName, string $uri): bool
    {
        if (file_exists($sitePath.'/cms') && file_exists($sitePath.'/framework')) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the incoming request is for a static file.
     *
     * @param  string  $sitePath
     * @param  string  $siteName
     * @param  string  $uri
     * @return string|false
     */
    public function isStaticFile(string $sitePath, string $siteName, string $uri)/*: string|false */
    {
        if (file_exists($sitePath.$uri) &&
            ! is_dir($sitePath.$uri) &&
            pathinfo($sitePath.$uri)['extension'] != 'php') {
            return $sitePath.$uri;
        }

        return false;
    }

    /**
     * Get the fully resolved path to the application's front controller.
     *
     * @param  string  $sitePath
     * @param  string  $siteName
     * @param  string  $uri
     * @return string
     */
    public function frontControllerPath(string $sitePath, string $siteName, string $uri): string
    {
        if (file_exists($sitePath.$uri) && ! is_dir($sitePath.$uri)) {
            return $sitePath.$uri;
        }

        $_SERVER['PHP_SELF'] = '/framework/main.php';
        $_SERVER['SCRIPT_NAME'] = '/framework/main.php';
        $_SERVER['SCRIPT_FILENAME'] = $sitePath.'/framework/main.php';
        $_SERVER['QUERY_STRING'] = 'url='.$uri;
        $_SERVER['DOCUMENT_URI'] = $uri;
        $_SERVER['DOCUMENT_ROOT'] = $sitePath;
        $_GET['url'] = $uri;

        return $sitePath.'/framework/main.php';
    }
}
