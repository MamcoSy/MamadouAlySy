<?php

declare(strict_types=1);

namespace MamcoSy\Http\Interfaces;

interface BagInterface
{
    public function all(): array;

    public function get(string $key);

    public function set(string $key, $value):BagInterface;

    public function has(string $key): bool;

    public function remove(string $key): BagInterface;
}
