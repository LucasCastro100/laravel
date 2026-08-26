<?php

it('clears all caches and reports success', function () {
    Cache::put('testing-key', 'testing-value');

    $this->artisan('app:clear-all-caches')->assertSuccessful();

    expect(Cache::has('testing-key'))->toBeFalse();
});
