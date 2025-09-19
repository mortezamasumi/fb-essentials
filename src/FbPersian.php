<?php

namespace Mortezamasumi\FbEssentials;

use Ariaieboy\Jalali\Jalali;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;

class FbPersian
{
    public function arfaTOenDigits(): array
    {
        return ['۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9', '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4', '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9'];
    }

    public function enTOfaDigits(): array
    {
        return ['0' => '۰', '1' => '۱', '2' => '۲', '3' => '۳', '4' => '۴', '5' => '۵', '6' => '۶', '7' => '۷', '8' => '۸', '9' => '۹'];
    }

    public function enarTOfaLetters(): array
    {
        return ['0' => '۰', '1' => '۱', '2' => '۲', '3' => '۳', '4' => '۴', '5' => '۵', '6' => '۶', '7' => '۷', '8' => '۸', '9' => '۹', '٠' => '۰', '١' => '۱', '٢' => '۲', '٣' => '۳', '٤' => '۴', '٥' => '۵', '٦' => '۶', '٧' => '۷', '٨' => '۸', '٩' => '۹', 'ك' => 'ک', 'ي' => 'ی', 'ى' => 'ی', 'ـ' => '-'];
    }

    public function enfaTOarLetters(): array
    {
        return ['0' => '٠', '1' => '١', '2' => '٢', '3' => '٣', '4' => '٤', '5' => '٥', '6' => '٦', '7' => '٧', '8' => '٨', '9' => '٩', '۰' => '٠', '۱' => '١', '۲' => '٢', '۳' => '٣', '۴' => '٤', '۵' => '٥', '۶' => '٦', '۷' => '٧', '۸' => '٨', '۹' => '٩', 'ک' => 'ك', 'ی' => 'ي', 'ی' => 'ى'];
    }

    public function arTOfaLetters(): array
    {
        return ['٠' => '۰', '١' => '۱', '٢' => '۲', '٣' => '۳', '٤' => '۴', '٥' => '۵', '٦' => '۶', '٧' => '۷', '٨' => '۸', '٩' => '۹', 'ك' => 'ک', 'ي' => 'ی', 'ى' => 'ی', 'ـ' => '-'];
    }

    public function enTOarDigits(): array
    {
        return ['0' => '٠', '1' => '١', '2' => '٢', '3' => '٣', '4' => '٤', '5' => '٥', '6' => '٦', '7' => '٧', '8' => '٨', '9' => '٩'];
    }

    public function persianLetters(): array
    {
        return ['آ', 'ا', 'ب', 'پ', 'ت', 'ث', 'ج', 'چ', 'ح', 'خ', 'د', 'ذ', 'ر', 'ز', 'ژ', 'س', 'ش', 'ص', 'ض', 'ط', 'ظ', 'ع', 'غ', 'ف', 'ق', 'ک', 'گ', 'ل', 'م', 'ن', 'و', 'ه', 'ی'];
    }

    public function persianConvert(): array
    {
        return [
            'آ' => 'A',
            'ا' => 'B',
            'ب' => 'C',
            'پ' => 'D',
            'ت' => 'E',
            'ث' => 'F',
            'ج' => 'G',
            'چ' => 'H',
            'ح' => 'I',
            'خ' => 'J',
            'د' => 'K',
            'ذ' => 'L',
            'ر' => 'M',
            'ز' => 'N',
            'ژ' => 'O',
            'س' => 'P',
            'ش' => 'Q',
            'ص' => 'R',
            'ض' => 'S',
            'ط' => 'T',
            'ظ' => 'U',
            'ع' => 'V',
            'غ' => 'W',
            'ف' => 'X',
            'ق' => 'Y',
            'ک' => 'Z',
            'گ' => 'a',
            'ل' => 'b',
            'م' => 'c',
            'ن' => 'd',
            'و' => 'e',
            'ه' => 'f',
            'ی' => 'g',
        ];
    }

    public function faTOen(?string $string): string
    {
        return strtr($string, $this->arfaTOenDigits());
    }

    public function enTOfa(?string $string): string
    {
        return strtr($string, $this->enTOfaDigits());
    }

    public function enarTOfa(?string $string): string
    {
        return strtr($string, $this->enarTOfaLetters());
    }

    public function enTOar(?string $string): string
    {
        return strtr($string, $this->enTOarDigits());
    }

    public function arTOfa(?string $string): string
    {
        return strtr($string, $this->arTOfaLetters());
    }

    public function arfaTOen(?string $string): string
    {
        return strtr($string, $this->arfaTOenDigits());
    }

    public function enfaTOar(?string $string): string
    {
        return strtr($string, $this->enfaTOarLetters());
    }

    public function digit(?string $string, $forceLocale = null): string
    {
        return match ($forceLocale ?? App::getLocale()) {
            'fa' => strtr($string, $this->enarTOfaLetters()),
            'ar' => strtr($string, $this->enfaTOarLetters()),
            default => strtr($string, $this->arfaTOenDigits()),
        };
    }

    public function jDate(?string $format, $datetime = null, ?string $timezome = null, $forceLocale = null): string
    {
        if (empty($datetime)) {
            return '';
        }

        return $this->digit(
            match (App::getLocale()) {
                'fa' => Jalali::forge($datetime)->format($format ?? __('fb-essentials::fb-essentials.date_format.full')),
                default => Carbon::parse($datetime)->format($format ?? __('fb-essentials::fb-essentials.date_format.full')),
            },
            $forceLocale
        );
    }

    public function jDateTime(?string $format, $datetime = null, ?string $timezome = null, $forceLocale = null): string
    {
        if (empty($datetime)) {
            return '';
        }

        return $this->digit(
            match (App::getLocale()) {
                'fa' => Jalali::forge($datetime)->format($format ?? __('fb-essentials::fb-essentials.date_format.time_full')),
                default => Carbon::parse($datetime)->format($format ?? __('fb-essentials::fb-essentials.date_format.time_full')),
            },
            $forceLocale
        );
    }

    public function jDateTimeForceLocale(?string $format, $datetime = null, ?string $timezome = null, $forceLocale = null): string
    {
        if (empty($datetime)) {
            return '';
        }

        return $this->digit(
            match ($forceLocale ?? App::getLocale()) {
                'fa' => Jalali::forge($datetime)->format($format ?? __('fb-essentials::fb-essentials.date_format.full')),
                default => Carbon::parse($datetime)->format($format ?? __('fb-essentials::fb-essentials.date_format.full')),
            },
            $forceLocale
        );
    }
}
