<?php

declare(strict_types=1);

namespace App\Common\Domain\Contracts;

use App\Common\Domain\Entity\File;

interface FileEntityInterface
{
    public function setFile(File $file): void;

    public function getFile(): ?File;
}
