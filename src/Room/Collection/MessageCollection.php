<?php

declare(strict_types=1);

namespace App\Room\Collection;

use Doctrine\Common\Collections\ArrayCollection;

class MessageCollection extends ArrayCollection
{
    public function sort(): self
    {
        $elements = parent::toArray();

        sort($elements);

        return new self($elements);
    }
}