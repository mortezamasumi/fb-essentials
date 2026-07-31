# FB Essentials — Filament Persian Toolkit

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mortezamasumi/fb-essentials.svg?style=flat-square)](https://packagist.org/packages/mortezamasumi/fb-essentials)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/mortezamasumi/fb-essentials/ci.yml?branch=main&label=tests&style=flat-square)](https://github.com/mortezamasumi/fb-essentials/actions?query=branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/mortezamasumi/fb-essentials.svg?style=flat-square)](https://packagist.org/packages/mortezamasumi/fb-essentials)
[![License](https://img.shields.io/packagist/l/mortezamasumi/fb-essentials.svg?style=flat-square)](LICENSE.md)

A Filament v5 plugin that brings **Persian (Farsi) language support** to your Laravel admin panel. It bundles digit & script conversion, Jalali date formatting, Persian-aware sorting, localized export/import notifications, and convenient Filament Shield helpers — along with a set of optional community plugin integrations.

---

## Features

- **Digit & script conversion** — Persian, Arabic, and English digit/letter normalization (input and display)
- **Jalali date pickers** — `DatePicker` and `DateTimePicker` with Persian calendar support
- **Jalali display macros** — format dates on `TextEntry`, `TextColumn`, and `ExportColumn` as Jalali dates
- **Persian-aware sorting** — sort collections by Persian alphabet via `Collection::pSort()`
- **Filament Shield helpers** — register resources, pages, and widgets for authorization with a single call
- **Unicode-safe JSON** — trait to preserve Persian/Arabic characters in JSON casting
- **Localized notifications** — export/import completion messages in Persian and English
- **Optional plugin bundle** — LanguageSwitch, Shield, Spatie Translatable, Environment Indicator, Vazirmatn font, SPA mode (all toggleable via config)

---

## Installation

```bash
composer require mortezamasumi/fb-essentials
```

Publish the config file:

```bash
php artisan vendor:publish --tag="fb-essentials-config"
```

Publish the assets (media icons used by the `MediaEntry` component):

```bash
php artisan vendor:publish --tag="fb-essentials-assets"
```

> The app works without this step — a fallback route serves the images from the package directory. Publishing is recommended for production to avoid the PHP route overhead.

Optionally publish the views:

```bash
php artisan vendor:publish --tag="fb-essentials-views"
```

---

## Configuration

```php
// config/fb-essentials.php
return [
    'has_language_switcher' => env('HAS_LANGUAGE_SWITCHER', true),
    'has_translatable'      => env('HAS_TRANSLATABLE', false),
    'used_languages'        => env('USED_LANGUAGES', 'en,fa'),
    'has_shield'            => env('HAS_SHIELD', true),
    'shield_resource_sort'  => env('SHIELD_RESOURCE_SORT', 15),
    'has_environment_indicator' => env('HAS_ENVIRONMENT_INDICATOR', true),
    'app_as_spa'            => env('APP_AS_SPA', true),
    'has_vazirmatn_font'    => env('HAS_VAZIRMATN_FONT', true),
];
```

---

## Usage

### Register the plugin in a panel

```php
use Mortezamasumi\FbEssentials\FbEssentialsPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugin(FbEssentialsPlugin::make());
}
```

### Digit & script conversion

```php
use Mortezamasumi\FbEssentials\Facades\FbPersian;

FbPersian::faTOen('۱۲۳');        // '123'
FbPersian::enTOfa('123');        // '۱۲۳'
FbPersian::arfaTOen('١٢٣');     // '123'
FbPersian::digit('۱۲۳', 'en');  // '123'
```

### Form input conversion

```php
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;

TextInput::make('phone')->toEN()       // Persian/Arabic → English digits on save
TextInput::make('price')->toFA()       // English/Arabic → Persian digits on save

DatePicker::make('created_at')->jDate()
DateTimePicker::make('published_at')->jDateTime()
```

### Jalali date display

```php
// Infolists
TextEntry::make('created_at')->jDate()
TextEntry::make('published_at')->jDateTime()

// Tables
TextColumn::make('created_at')->jDate()
TextColumn::make('published_at')->jDateTime()

// Exports
ExportColumn::make('created_at')->jDate()

// Locale digit formatting
TextColumn::make('price')->localeDigit()
```

### Persian-aware collection sorting

```php
collect(['ز', 'ا', 'ب', 'پ'])->pSort();
// ['ا', 'ب', 'پ', 'ز']

collect([
    ['name' => 'محمد'],
    ['name' => 'احمد'],
    ['name' => 'بابک'],
])->pSort('name');
```

### Filament Shield helpers

```php
use Mortezamasumi\FbEssentials\Facades\FbEssentials;

// Register a resource with custom permissions
FbEssentials::filamentShieldAddResource(
    UserResource::class,
    ['viewAny', 'create']
);

// Exclude resources, pages, or widgets from Shield
FbEssentials::filamentShieldExcludeResource(SomeResource::class);
FbEssentials::filamentShieldExcludePage(Dashboard::class);
FbEssentials::filamentShieldExcludeWidget(StatsWidget::class);
```

### Localized export/import notifications

```php
use Mortezamasumi\FbEssentials\Traits\ExportCompletedNotificationBody;
use Mortezamasumi\FbEssentials\Traits\ImportCompletedNotificationBody;
use Filament\Actions\Exports\ExportColumn;

class UserExporter extends \Filament\Actions\Exports\Exporter
{
    use ExportCompletedNotificationBody;  // or ImportCompletedNotificationBody

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('name'),
            ExportColumn::make('created_at')->jDate(),
        ];
    }
}
```

### Unicode-safe JSON trait

```php
use Mortezamasumi\FbEssentials\Traits\TranslatableUnicodeJson;

class YourModel extends Model
{
    use TranslatableUnicodeJson;
}
```

### Global helper functions

```php
__f_date();          // 'Y/m/d'
__f_datetime();      // 'Y/m/d H:i'
__f_datefull();      // 'l j F Y'
__f_datetimefull();  // 'l j F Y  H:i'
__digit('۱۲۳');      // locale-aware digit conversion
__jdate('Y/m/d', $date);      // Jalali date
__jdatetime('Y/m/d H:i', $date); // Jalali datetime
```

---

## Support policy

| PHP | Laravel | Filament |
| --- | --- | --- |
| 8.3 | 12 | 5.x |

---

## Testing

```bash
composer test
```

---

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security

If you discover a security vulnerability, please review our [security policy](.github/SECURITY.md) on how to report it.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for recent changes.

---

## License

The MIT License (MIT). See [LICENSE.md](LICENSE.md) for details.
