<?php

namespace App\Services;

use Devium\Toml\Toml;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class TomlService
{
    /**
     * Load a TOML file and cache the result
     *
     * @return array
     */
    public function load(string $filePath): mixed
    {
        $cacheKey = 'toml_'.md5($filePath);

        return Cache::remember($cacheKey, 3600, function () use ($filePath) {
            if (! File::exists($filePath)) {
                throw new \Exception("TOML file not found: {$filePath}");
            }

            $content = File::get($filePath);

            return Toml::decode($content);
        });
    }

    /**
     * Load all TOML files from a directory and cache the results
     */
    public function loadDirectory(string $directory): array
    {
        $cacheKey = 'toml_dir_'.md5($directory);

        return Cache::remember($cacheKey, 3600, function () use ($directory) {
            $files = File::glob($directory.'/*.toml');
            $result = [];

            foreach ($files as $file) {
                $fileName = pathinfo($file, PATHINFO_FILENAME);
                $result[$fileName] = $this->load($file);
            }

            return $result;
        });
    }

    /**
     * Get a specific value from a TOML file
     *
     * @param  mixed  $default
     * @return mixed
     */
    public function get(string $filePath, ?string $key = null, $default = null)
    {
        $data = $this->load($filePath);

        if ($key === null) {
            return $data;
        }

        return data_get($data, $key, $default);
    }

    /**
     * Clear the cache for a specific TOML file
     */
    public function clearCache(?string $filePath = null): void
    {
        if ($filePath) {
            $cacheKey = 'toml_'.md5($filePath);
            Cache::forget($cacheKey);
        } else {
            Cache::flush();
        }
    }

    /**
     * Clear directory cache
     */
    public function clearDirectoryCache(string $directory): void
    {
        $cacheKey = 'toml_dir_'.md5($directory);
        Cache::forget($cacheKey);
    }
}
