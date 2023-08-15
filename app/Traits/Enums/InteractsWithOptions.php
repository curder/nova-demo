<?php

namespace App\Traits\Enums;

use Illuminate\Support;

trait InteractsWithOptions
{
    public static function asSelectOptions(): Support\Collection
    {
        return collect(self::cases())->mapWithKeys(fn (self $enum) => [$enum->value => $enum->label()]);
    }

    public function label(): string
    {
        $str = Support\Str::of('enums')
            ->append('.')
            ->append($this::class)
            ->append('.')
            ->append($this->value)
            ->toString();

        return __($str);
    }
}
