<?php
declare(strict_types=1);

namespace App\Service;

use App\Enum\Direction;
use App\Repository\VocableRepository;

class VocableService
{
    public function createTest(
        Direction $direction,
        int $vocablesCount,
        bool $includeKnown,
        VocableRepository $repository
    )
    {
        $repository->getVocableInRandomOrder();
    }
}
