<?php

namespace App\Filament\Infolists\Components;

use Closure;
use Filament\Infolists\Components\Entry;

class MediaFileEntry extends Entry
{
    protected string $view = 'filament.infolists.components.media-file-entry';
    
    protected string | Closure | null $collection = null;

    public function collection(string | Closure | null $collection): static
    {
        $this->collection = $collection;

        return $this;
    }

    public function getCollection(): ?string
    {
        return $this->evaluate($this->collection);
    }
}
