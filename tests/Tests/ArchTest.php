<?php

// test

it('will not use debugging functions')
    ->expect(['dd', 'dump', 'ray'])
    ->each
    ->not
    ->toBeUsed();
