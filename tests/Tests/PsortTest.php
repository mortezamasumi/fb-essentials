<?php

it('test collection psort macro', function () {
    expect(collect(['علی', 'یاور', 'نقی', 'تقی', 'آدم', 'حوا'])->shuffle()->pSort()->toArray())
        ->toMatchArray(collect(['آدم', 'تقی', 'حوا', 'علی', 'نقی', 'یاور'])->toArray());

    expect(collect([['name' => 'علی'], ['name' => 'یاور'], ['name' => 'نقی'], ['name' => 'تقی'], ['name' => 'آدم'], ['name' => 'حوا']])->shuffle()->pSort('name')->values()->toArray())
        ->toMatchArray(collect([['name' => 'آدم'], ['name' => 'تقی'], ['name' => 'حوا'], ['name' => 'علی'], ['name' => 'نقی'], ['name' => 'یاور']])->values()->toArray());
});
