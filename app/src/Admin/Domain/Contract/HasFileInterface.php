<?php

declare(strict_types=1);

namespace App\Admin\Domain\Contract;

use App\Entity\File;

interface HasFileInterface
{
    public function setFile(File $file): void;
    public function getFile(): ?File;
}
