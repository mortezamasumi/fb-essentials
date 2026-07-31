<?php

use Illuminate\Support\Facades\App;
use Mortezamasumi\FbEssentials\Components\RichEntry;

it('returns empty string for empty input', function () {
    expect(RichEntry::processRichContentHtml(''))->toBe('');
});

it('returns trimmed empty string for whitespace-only input', function () {
    expect(RichEntry::processRichContentHtml('   '))->toBe('   ');
});

it('keeps center alignment unchanged in Persian locale', function () {
    App::setLocale('fa');
    $html = '<p style="text-align: center;"><img src="foo.jpg"></p>';
    $result = RichEntry::processRichContentHtml($html);
    expect($result)->toContain('margin-left: auto; margin-right: auto;');
});

it('flips text-align right to left for Persian locale', function () {
    App::setLocale('fa');
    $html = '<p style="text-align: right;"><img src="foo.jpg"></p>';
    $result = RichEntry::processRichContentHtml($html);
    expect($result)->toContain('margin-left: 0; margin-right: auto;');
});

it('flips text-align left to right for Persian locale', function () {
    App::setLocale('fa');
    $html = '<p style="text-align: left;"><img src="foo.jpg"></p>';
    $result = RichEntry::processRichContentHtml($html);
    expect($result)->toContain('margin-left: auto; margin-right: 0;');
});

it('flips start to end for Persian locale', function () {
    App::setLocale('fa');
    $html = '<p style="text-align: start;"><img src="foo.jpg"></p>';
    $result = RichEntry::processRichContentHtml($html);
    expect($result)->toContain('margin-left: auto; margin-right: 0;');
});

it('flips end to start for Persian locale', function () {
    App::setLocale('fa');
    $html = '<p style="text-align: end;"><img src="foo.jpg"></p>';
    $result = RichEntry::processRichContentHtml($html);
    expect($result)->toContain('margin-left: 0; margin-right: auto;');
});

it('does not flip alignment for English locale', function () {
    App::setLocale('en');
    $html = '<p style="text-align: right;"><img src="foo.jpg"></p>';
    $result = RichEntry::processRichContentHtml($html);
    expect($result)->toContain('margin-left: auto; margin-right: 0;');
});

it('does not modify html without text-align style', function () {
    App::setLocale('fa');
    $html = '<p>some text</p><img src="bar.jpg">';
    $result = RichEntry::processRichContentHtml($html);
    expect($result)->toContain('some text');
});

it('handles multiple images in one paragraph', function () {
    App::setLocale('fa');
    $html = '<p style="text-align: right;"><img src="a.jpg"><img src="b.jpg"></p>';
    $result = RichEntry::processRichContentHtml($html);
    expect($result)->toContain('margin-left: 0; margin-right: auto;');
});

it('preserves existing image styles when applying alignment', function () {
    App::setLocale('fa');
    $html = '<p style="text-align: right;"><img src="a.jpg" style="border: 1px;"></p>';
    $result = RichEntry::processRichContentHtml($html);
    expect($result)->toContain('border: 1px');
});
