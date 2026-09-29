<?php

namespace App\Repositories\Contracts;

use App\Models\Setting;
use Illuminate\Support\Collection;

interface SettingRepositoryInterface extends BaseRepositoryInterface
{
    public function keyed(): Collection;

    public function updateByKey(string $key, mixed $value, string $type, string $group): Setting;
}
