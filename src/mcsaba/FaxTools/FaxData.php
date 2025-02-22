<?php

namespace mcsaba\FaxTools;

class FaxData implements \Iterator
{
    public string $parentDirectory;
    public array $directories;
    private int $index;

    public function __construct(string $parentDirectory)
    {
        $this->parentDirectory = $parentDirectory;
        $this->directories = $this->scandirFiltered($this->parentDirectory);
        $this->index = 0;
    }

    public function rewind(): void
    {
        $this->index = 0;
    }

    public function key(): string
    {
        return $this->directories[$this->index];
    }

    public function current(): array
    {
        return $this->scandirFiltered($this->parentDirectory . '/' . $this->directories[$this->index]);
    }

    public function valid(): bool
    {
        return isset($this->directories[$this->index]);
    }

    public function next(): void
    {
        $this->index++;
    }

    private function scandirFiltered($path): false|array
    {
        return array_values(array_filter(scandir($path, SCANDIR_SORT_ASCENDING), function ($a) {
            return ($a != '.' && $a != '..');
        }));
    }

}

