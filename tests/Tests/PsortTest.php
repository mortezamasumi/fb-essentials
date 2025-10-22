<?php

it('test collection psort macro', function () {
    // Type 1: Simple - collect(['a', 'b', 'c'])
    expect(collect([
        'علی',
        'یاور',
        'نقی',
        'تقی',
        'آدم',
        'حوا'
    ])
            ->pSort()
            ->toArray())
        ->toMatchArray(collect([
            'آدم',
            'تقی',
            'حوا',
            'علی',
            'نقی',
            'یاور'
        ])
            ->toArray());

    // Type 2: Dictionary - collect(['111' => 'a', '222' => 'b']);
    expect(collect([
        'key01' => 'علی',
        'key02' => 'یاور',
        'key03' => 'نقی',
        'key04' => 'تقی',
        'key05' => 'آدم',
        'key06' => 'حوا'
    ])
            ->pSort()
            ->toArray())
        ->toMatchArray(collect([
            'key05' => 'آدم',
            'key04' => 'تقی',
            'key06' => 'حوا',
            'key01' => 'علی',
            'key03' => 'نقی',
            'key02' => 'یاور'
        ])
            ->toArray());

    // Type 3: List of Structs - collect([['key' => '111', 'value' => 'a'], ['key' => '222', 'value' => 'b']])
    expect(collect([
        ['name' => 'علی', 'another-attribute' => 'another-value'],
        ['name' => 'یاور', 'another-attribute' => 'another-value'],
        ['name' => 'نقی', 'another-attribute' => 'another-value'],
        ['name' => 'تقی', 'another-attribute' => 'another-value'],
        ['name' => 'آدم', 'another-attribute' => 'another-value'],
        ['name' => 'حوا', 'another-attribute' => 'another-value']
    ])
            ->pSort('name')
            ->values()
            ->toArray())
        ->toMatchArray(collect([
            ['name' => 'آدم', 'another-attribute' => 'another-value'],
            ['name' => 'تقی', 'another-attribute' => 'another-value'],
            ['name' => 'حوا', 'another-attribute' => 'another-value'],
            ['name' => 'علی', 'another-attribute' => 'another-value'],
            ['name' => 'نقی', 'another-attribute' => 'another-value'],
            ['name' => 'یاور', 'another-attribute' => 'another-value']
        ])->values()->toArray());
});
