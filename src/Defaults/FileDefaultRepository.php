<?php

namespace Leeovery\LaravelSettings\Defaults;

use function DeepCopy\deep_copy;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Leeovery\LaravelSettings\Exceptions\InvalidSettingsKey;

class FileDefaultRepository implements DefaultRepository
{
    private $entityName;

    /**
     * FileDefaultRepository constructor.
     * @param $entityName
     */
    public function __construct($entityName)
    {
        $this->entityName = $entityName;
    }

    public function get(string $key): Collection
    {
        $defaults = collect(
            $this->ensureSubSetsAreProperlyKeyed(
                $key, config($this->makeKey($key))
            )
        );

        throw_if($defaults->isEmpty(), InvalidSettingsKey::class);

        return deep_copy($defaults);
    }

    private function ensureSubSetsAreProperlyKeyed(string $key, $defaults)
    {
        // ensure results are fully keyed when only fetching a subset of data...
        if (Str::contains($key, '.')) {
            $key = Str::after($key, '.');
            foreach (Arr::dot($defaults) as $dottedKey => $value) {
                Arr::set($defaults, $key.'.'.$dottedKey, $value);
                Arr::forget($defaults, $dottedKey);
            }
            $defaults = array_filter($defaults);
        }

        return $defaults;
    }

    private function makeKey($key)
    {
        return config('laravel-settings.'.$this->entityName.'.config-pre-key').'-'.$key;
    }
}
