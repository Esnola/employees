<?php

namespace App\Enums\Concerns;

use Collator;
use Illuminate\Support\Facades\App;

trait HasLocalizedCases
{
    /**
     * @return list<static>
     */
    public static function localizedCases(): array
    {
        $cases = static::cases();
        $collator = new Collator(App::currentLocale());

        usort(
            $cases,
            function (self $first, self $second) use ($collator): int {
                $comparison = $collator->compare($first->label(), $second->label());

                return $comparison === false
                    ? strcmp($first->label(), $second->label())
                    : $comparison;
            }
        );

        return $cases;
    }
}
