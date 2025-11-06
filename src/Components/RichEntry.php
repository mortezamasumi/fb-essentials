<?php

namespace Mortezamasumi\FbEssentials\Components;

use Filament\Forms\Components\RichEditor\RichContentRenderer;
use Filament\Infolists\Components\Entry;
use Illuminate\Support\Facades\App;
use DOMDocument;
use DOMElement;
use DOMXPath;

class RichEntry extends Entry
{
    protected string $view = 'fb-essentials::rich-entry';

    public function getState(): mixed
    {
        return static::processRichContentHtml($this->getConstantState());
    }

    public static function processRichContentHtml(string|array $html): string
    {
        if (is_array($html)) {
            $html = RichContentRenderer::make($html)->toHtml();
        }

        if (trim($html) === '') {
            return $html;
        }

        $dom = new DOMDocument();
        // Load the HTML fragment, suppressing warnings and specifying UTF-8
        @$dom->loadHTML('<?xml encoding="UTF-8">'.$html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $xpath = new DOMXPath($dom);

        // Find all <p> tags that have a "text-align" style property
        $paragraphs = $xpath->query("//p[contains(@style, 'text-align')]");

        /** @var DOMElement $p */
        foreach ($paragraphs as $p) {
            $styleAttribute = $p->getAttribute('style');
            $imgStyle = '';

            // Use regex to find the value of 'text-align'
            if (preg_match('/text-align:\s*([^;]+)/', $styleAttribute, $matches)) {
                $textAlign = trim($matches[1]);

                if (App::getLocale() === 'fa') {
                    $textAlign = match ($textAlign) {
                        'right' => 'left',
                        'left' => 'right',
                        'start' => 'end',
                        'end' => 'start',
                        default => $textAlign,
                    };
                }

                // Determine the correct CSS for the <img> based on the <p> alignment
                switch ($textAlign) {
                    case 'center':
                        $imgStyle = 'display: block; margin-left: auto; margin-right: auto;';
                        break;
                    case 'right':
                    case 'end':  // 'end' is the logical equivalent of 'right'
                        $imgStyle = 'display: block; margin-left: auto; margin-right: 0;';
                        break;
                    case 'left':
                    case 'start':  // 'start' is the logical equivalent of 'left'
                        $imgStyle = 'display: block; margin-left: 0; margin-right: auto;';
                        break;
                }
            }

            // If a valid alignment was found, apply the style to all descendant images
            if (! empty($imgStyle)) {
                // The '.' in the query means we search relative to the current node ($p)
                $images = $xpath->query('.//img', $p);
                /** @var DOMElement $img */
                foreach ($images as $img) {
                    $currentStyle = $img->getAttribute('style');
                    // Prepend the new alignment styles to any existing styles
                    $newStyle = $imgStyle.' '.$currentStyle;
                    $img->setAttribute('style', trim($newStyle));
                }
            }
        }

        return $dom->saveHTML();
    }
}
