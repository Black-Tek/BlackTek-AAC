<?php

namespace App\Services;

use App\Traits\LoadsTomlData;
use Illuminate\Support\Collection;

class VocationService
{
    use LoadsTomlData;

    public function __construct()
    {
        $this->loadTomlData(server_root().'/data/vocations');
    }

    /**
     * Get all vocations indexed by ID
     */
    public function getVocations(): array
    {
        return $this->getDataIndexed('id');
    }

    /**
     * Get all vocations as a collection
     */
    public function getAllVocations(): array
    {
        $vocations = $this->getVocations();
        $available = [];

        foreach ($vocations as $vocation) {
            if (isset($vocation->id) && isset($vocation->name)) {
                $available[$vocation->id] = $vocation->name;
            }
        }

        return $available;
    }

    /**
     * Get vocation names indexed by ID
     */
    public function getVocationNames(): array
    {
        $names = [];
        foreach ($this->data as $vocation) {
            if (isset($vocation->id)) {
                $names[$vocation->id] = $vocation->name ?? 'Unknown';
            }
        }
        ksort($names);

        return $names;
    }

    /**
     * Get vocation name by ID
     */
    public function getVocationName(int $vocationId): string
    {
        $vocation = $this->getById($vocationId);

        return $vocation ? $vocation->name : 'Unknown Vocation';
    }

    /**
     * Get promoted vocations
     */
    public function getPromotedVocations(): Collection
    {
        return $this->getWhereNotNull('promotedfrom');
    }

    /**
     * Get base vocations (non-promoted)
     */
    public function getBaseVocations(): Collection
    {
        return $this->getWhereNull('promotedfrom');
    }

    /**
     * Get vocation by ID (alias for getById)
     */
    public function getVocation(int $vocationId): ?object
    {
        return $this->getById($vocationId);
    }
}
