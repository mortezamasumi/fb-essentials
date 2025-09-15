<?php

namespace Mortezamasumi\FbEssentials\Components;

use Filament\Infolists\Components\Entry;
use Illuminate\Support\Collection;
use Closure;
use Exception;

class MediaEntry extends Entry
{
    protected string $view = 'fb-essentials::media-entry';
    protected ?Closure $filterMediaUsing = null;
    protected Closure|bool $mediaText = true;
    protected Closure|string $mediaTextSize = 'sm';  // xs, sm, md, lg
    protected Closure|string $mediaIconSize = 'sm';  // xs, sm, md, lg

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

    public function mediaText(Closure|bool $callback = true): static
    {
        $this->mediaText = $callback;

        return $this;
    }

    public function hasMediaText(): bool
    {
        return $this->evaluate($this->mediaText);
    }

    public function mediaTextSize(Closure|string $callback = 'sm'): static
    {
        $this->mediaTextSize = $callback;

        return $this;
    }

    public function getMediaTextSize(): mixed
    {
        return $this->evaluate($this->mediaTextSize);
    }

    public function mediaIconSize(Closure|string $callback = 'sm'): static
    {
        $this->mediaIconSize = $callback;

        return $this;
    }

    public function getMediaIconSize(): mixed
    {
        return $this->evaluate($this->mediaIconSize);
    }
}
