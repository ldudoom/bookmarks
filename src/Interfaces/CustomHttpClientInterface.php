<?php

namespace App\Interfaces;

interface CustomHttpClientInterface
{
    public function getUrlCode(string $url): int;
    public function getErrorMessages(): array;
}