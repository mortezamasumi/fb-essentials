<?php

namespace Mortezamasumi\FbEssentials\Components;

use Filament\Infolists\Components\Entry;
use Illuminate\Support\Collection;
use Closure;
use DOMDocument;
use DOMElement;
use DOMXPath;
use Exception;

class MediaEntry extends Entry
{
    protected string $view = 'fb-essentials::media-entry';
    protected ?Closure $filterMediaUsing = null;

    public function getState(): mixed
    {
        $media = $this->getConstantState();

        if (empty($media)) {
            return collect([]);
        }

        throw_unless(get_class($media) === 'Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection', new Exception('state must be instance of spatie MediaCollection'));

        return $media;
    }

    public function filterMediaUsing(?Closure $callback): static
    {
        $this->filterMediaUsing = $callback;

        return $this;
    }

    public function filterMedia(?Collection $media): Collection
    {
        if (! $media) {
            return collect([]);
        }

        return $this->evaluate($this->filterMediaUsing, [
            'media' => $media,
        ]) ?? $media;
    }
}
