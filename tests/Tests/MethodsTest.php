<?php

use Illuminate\Support\Facades\App;
use Mortezamasumi\FbEssentials\Facades\FbPersian;

it('test faTOen method', function () {
    expect(FbPersian::faTOen('۱۲۳۴۵۶۷۸۹۰'))->toBe('1234567890');
});

it('test enTOfa method', function () {
    expect(FbPersian::enTOfa('1234567890'))->toBe('۱۲۳۴۵۶۷۸۹۰');
});

it('test enarTOfa method', function () {
    expect(FbPersian::enarTOfa('1234567890١٢٣٤٥٦٧٨٩٠كيىـ'))->toBe('۱۲۳۴۵۶۷۸۹۰۱۲۳۴۵۶۷۸۹۰کیی-');
});

it('test enTOar method', function () {
    expect(FbPersian::enTOar('1234567890'))->toBe('١٢٣٤٥٦٧٨٩٠');
});

it('test arTOfa method', function () {
    expect(FbPersian::arTOfa('١٢٣٤٥٦٧٨٩٠كيىـ'))->toBe('۱۲۳۴۵۶۷۸۹۰کیی-');
});

it('test arfaTOen method', function () {
    expect(FbPersian::arfaTOen('١٢٣٤٥٦٧٨٩٠۱۲۳۴۵۶۷۸۹۰'))->toBe('12345678901234567890');
});

it('test digit method', function () {
    expect(FbPersian::digit('1234567890'))->toBe('1234567890');

    App::setLocale('fa');
    expect(FbPersian::digit('1234567890'))->toBe('۱۲۳۴۵۶۷۸۹۰');

    App::setLocale('en');
    expect(FbPersian::digit('1234567890', 'fa'))->toBe('۱۲۳۴۵۶۷۸۹۰');

    expect(FbPersian::digit('1234567890', 'fr'))->toBe('1234567890');

    expect(FbPersian::digit('1234567890', 'ar'))->toBe('١٢٣٤٥٦٧٨٩٠');
});

it('test jDateTime methods', function () {
    expect(FbPersian::jDateTime('Y-m-d', '2017-12-13'))->toBe('2017-12-13');

    expect(FbPersian::jDateTime('Y-m-d', ''))->toBe('');

    expect(FbPersian::jDateTimeForceLocale('Y-m-d H:i:s', '2017-12-13 01:02:03'))->toBe('2017-12-13 01:02:03');

    expect(FbPersian::jDateTime('Y-m-d H:i:s', '2017-12-13 01:02:03', null, 'fa'))->toBe('۲۰۱۷-۱۲-۱۳ ۰۱:۰۲:۰۳');

    expect(FbPersian::jDateTimeForceLocale('Y-m-d H:i:s', '2017-12-13 01:02:03', null, 'fa'))->toBe('۱۳۹۶-۰۹-۲۲ ۰۱:۰۲:۰۳');

    App::setLocale('fa');
    expect(FbPersian::jDateTime('Y-m-d', '2017-12-13'))->toBe('۱۳۹۶-۰۹-۲۲');
});
