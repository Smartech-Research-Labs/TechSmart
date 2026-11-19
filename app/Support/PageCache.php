<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\Response;

/**
 * Saves the HTML of public pages so public/index.php can send it back without starting
 * Laravel. Every visitor gets the same page shell (the app signs in with API tokens),
 * so one saved copy per address serves everyone.
 *
 * public/index.php reads these files with its own copy of key() and folder(); keep the
 * three in step.
 */
class PageCache
{
    /** Seconds a saved page is served before it is rendered again. */
    public const TTL = 3600;

    /** Saved pages live in a folder named after the current build, so a deploy starts fresh. */
    public static function folder(): string
    {
        $build = @filemtime(public_path('build/manifest.json')) ?: 0;

        return storage_path('framework/page-cache/' . $build);
    }

    public static function key(string $host, string $path): string
    {
        return md5(strtolower($host) . '|' . $path);
    }

    public static function store(Request $request, Response $response): void
    {
        if (! app()->isProduction()
            || ! $request->isMethod('GET')
            || $request->server('QUERY_STRING', '') !== ''
            || $response->getStatusCode() !== 200
            || file_exists(public_path('hot'))) {
            return;
        }

        $path = (string) parse_url((string) $request->server('REQUEST_URI', '/'), PHP_URL_PATH);
        if (! preg_match('#^/[A-Za-z0-9/_-]{0,200}$#', $path)) {
            return;
        }

        try {
            $folder = self::folder();
            if (! is_dir($folder)) {
                // First page of a new build: remove pages saved for older builds
                foreach (glob(dirname($folder) . '/*', GLOB_ONLYDIR) ?: [] as $old) {
                    File::deleteDirectory($old);
                }
                File::ensureDirectoryExists($folder);
            }

            $file = $folder . '/' . self::key((string) $request->server('HTTP_HOST', ''), $path) . '.html';
            $tmp = $file . '.' . getmypid() . '.tmp';
            file_put_contents($tmp, $response->getContent());
            rename($tmp, $file);
        } catch (\Throwable) {
            // Saving is only a speed-up; the page has already been rendered
        }
    }

    /** Forget every saved page, after content that appears in page titles or descriptions changes. */
    public static function flush(): void
    {
        File::deleteDirectory(storage_path('framework/page-cache'));
    }
}
