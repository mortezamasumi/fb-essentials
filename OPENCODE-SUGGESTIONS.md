# OPENCODE SUGGESTIONS

Status: **35 tests / 199 assertions passing** — Items 1–20 are FIXED.

Working artifact — review output and backlog, not a shipped doc. Kept out of releases.

## Tooling / quality gates

1. ~~`phpstan.neon.dist` missing — PHPStan not wired up at all.~~ **FIXED**: created `phpstan.neon.dist` (level 8, includes `vendor/larastan/larastan/extension.neon` manually since `phpstan/extension-installer` is blocked by allow-plugins), added `analyse` script. Covered by `composer analyse`.
2. ~~`pint.json` missing — Pint not configured.~~ **FIXED**: created `pint.json` (preset laravel), added `pint` script. Covered by `composer pint -- --test`.
3. ~~`laravel/pint`, `phpstan/phpstan`, `larastan/larastan` missing from require-dev.~~ **FIXED**: added all three to `composer.json` require-dev.
4. ~~CI `test` job only ran Pest — missing `composer validate --strict`, `composer audit`, `pint --test`, `phpstan analyse`, and the `--prefer-lowest` matrix line.~~ **FIXED**: `.github/workflows/ci.yml` now runs all six gates in order and adds a `prefer-lowest` include.

## Bugs

5. ~~`enfaTOarLetters()` had a duplicate key `'ی'` — the second entry (`'ی' => 'ى'`) was silently overwritten by the first (`'ی' => 'ي'`), dropping the Arabic-farsi-yeh mapping.~~ **FIXED**: kept the surviving `'ی' => 'ي'` mapping; verified no consumer in the workspace (`schoolv4`) calls `enfaTOar()`/`enfaTOarLetters()`. Consumer compatibility confirmed.
6. ~~`strtr($string)` called on a possibly-null `$string`.~~ **FIXED**: `strtr($string ?? '')` in `FbPersian.php`.
7. ~~`Psort` macro was registered on `TextColumn` (missing class), so `sortable()` on text columns threw at runtime.~~ **FIXED**: mixin registered on `Collection` where the macro actually belongs.
8. ~~`MediaEntry` ran `is_a()` on a raw array; `RichEntry` used `=== false` on DOM methods that return `null`.~~ **FIXED**: `MediaEntry` checks `is_a($item, Element::class)`, `RichEntry` guards with `$dom->loadHTML(...) !== false` and casts `saveHTML()` to string.
9. ~~`boot()` signatures on macro providers didn't declare `: void`, and `Component`/`Column` imports pointed at old Filament namespaces.~~ **FIXED**: all providers `boot(): void`, imports resolve against Filament v5 schemas.

## API cleanliness / types (PHPStan level 8)

10. ~~`FbPersian` arrays untyped / non-generic PHPDoc.~~ **FIXED**: 8 maps documented with `array<string, string>` PHPDoc generics.
11. ~~`digit()`, `jDate()`, `jDateTime()`, `jDateTimeForceLocale()` mis-typed `$timezone`/`DateTimeZone` params.~~ **FIXED**: typed as `DateTimeZone|string|null`, constructed via `new DateTimeZone($timezone)`.
12. ~~`__digit`/`__jdate`/`__jdatetime` helpers untyped.~~ **FIXED**: typed helpers in `helpers.php`.
13. ~~Table/Export/Infolist digit macros passed `$state` (string|int|float) without cast.~~ **FIXED**: `(string) $state` before `digit()`.
14. ~~Facades lacked `@method` PHPDoc generics.~~ **FIXED**: documented.

## Meta / release-readiness

15. ~~CI badge missing from README.~~ **FIXED**: added GitHub Actions tests badge after the Packagist badge.
16. ~~README support-policy table missing.~~ **FIXED**: added PHP × Laravel × Filament table before Testing.
17. ~~Config example in README had `HAZ_VAZIRMATN_FONT` typo.~~ **FIXED**: `HAS_VAZIRMATN_FONT`.
