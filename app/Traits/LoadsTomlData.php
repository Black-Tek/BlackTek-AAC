<?php

namespace App\Traits;

use App\Services\TomlService;
use Illuminate\Support\Collection;

trait LoadsTomlData
{
    protected TomlService $tomlService;

    protected array $data = [];

    protected string $dataKey = 'id';

    /**
     * Get or initialize the TomlService instance
     */
    protected function getTomlService(): TomlService
    {
        if (! isset($this->tomlService)) {
            $this->tomlService = app(TomlService::class);
        }

        return $this->tomlService;
    }

    /**
     * Load data from path (auto-detects file vs directory)
     */
    protected function loadTomlData(string $path): void
    {
        $this->data = [];
        $tomlService = $this->getTomlService();

        if (is_file($path) || str_ends_with(strtolower($path), '.toml')) {
            $fileData = $tomlService->load($path);
            foreach ($fileData as $dataName => $dataContent) {
                $this->data[$dataName] = (object) $dataContent;
            }
        } else {
            $allData = $tomlService->loadDirectory($path);
            foreach ($allData as $fileName => $fileData) {
                foreach ($fileData as $dataName => $dataContent) {
                    $this->data[$dataName] = (object) $dataContent;
                }
            }
        }
    }

    /**
     * Get all data
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Get data indexed by a specific key (default: id)
     */
    public function getDataIndexed(?string $indexKey = null): array
    {
        $indexKey = $indexKey ?: $this->dataKey;
        $indexed = [];

        foreach ($this->data as $item) {
            if (isset($item->{$indexKey})) {
                $indexed[$item->{$indexKey}] = $item;
            }
        }

        ksort($indexed);

        return $indexed;
    }

    /**
     * Get a single item by key and value
     */
    public function getByField(string $field, $value): ?object
    {
        return collect($this->data)->firstWhere($field, $value);
    }

    /**
     * Get an item by ID
     */
    public function getById(int $id): ?object
    {
        return $this->getByField('id', $id);
    }

    /**
     * Get an item by name
     */
    public function getByName(string $name): ?object
    {
        return $this->data[$name] ?? null;
    }

    /**
     * Get items that match a condition
     */
    public function getWhere(string $field, $value): Collection
    {
        return collect($this->data)->where($field, $value);
    }

    /**
     * Get items where field exists
     */
    public function getWhereNotNull(string $field): Collection
    {
        return collect($this->data)->whereNotNull($field);
    }

    /**
     * Get items where field doesn't exist
     */
    public function getWhereNull(string $field): Collection
    {
        return collect($this->data)->whereNull($field);
    }

    /**
     * Get items within a range
     */
    public function getWhereBetween(string $field, array $range): Collection
    {
        return collect($this->data)->whereBetween($field, $range);
    }

    /**
     * Filter items by custom callback
     */
    public function filter(callable $callback): Collection
    {
        return collect($this->data)->filter($callback);
    }

    /**
     * Search items by name (case insensitive)
     */
    public function search(string $term): Collection
    {
        return collect($this->data)->filter(function ($item) use ($term) {
            return stripos($item->name ?? '', $term) !== false;
        });
    }

    /**
     * Get items paginated
     */
    public function paginate(int $perPage = 15, int $page = 1): array
    {
        $collection = collect($this->data);
        $total = $collection->count();
        $items = $collection->slice(($page - 1) * $perPage, $perPage)->values();

        return [
            'data' => $items,
            'total' => $total,
            'per_page' => $perPage,
            'current_page' => $page,
            'last_page' => ceil($total / $perPage),
        ];
    }

    /**
     * Count items
     */
    public function count(): int
    {
        return count($this->data);
    }

    /**
     * Check if item exists
     */
    public function exists(string $field, $value): bool
    {
        return $this->getByField($field, $value) !== null;
    }

    /**
     * Get all unique values for a field
     */
    public function getUniqueValues(string $field): array
    {
        return collect($this->data)
            ->pluck($field)
            ->filter()
            ->unique()
            ->sort()
            ->values()
            ->toArray();
    }

    /**
     * Clear cache for path (auto-detects file vs directory)
     */
    public function clearTomlCache(string $path): void
    {
        $tomlService = $this->getTomlService();

        if (is_file($path) || str_ends_with(strtolower($path), '.toml')) {
            $tomlService->clearCache($path);
        } else {
            $tomlService->clearDirectoryCache($path);
        }
    }

    /**
     * Get statistics about the data
     */
    public function getStats(): array
    {
        $collection = collect($this->data);

        return [
            'total_items' => $collection->count(),
            'has_id' => $collection->whereNotNull('id')->count(),
            'has_name' => $collection->whereNotNull('name')->count(),
            'unique_types' => $collection->pluck('type')->filter()->unique()->count(),
        ];
    }
}
