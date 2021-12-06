<?php

namespace App\Faker\Provider;

use App\Entity\Task;
use Faker\Provider\Base as BaseProvider;

final class RandomStateProvider extends BaseProvider
{
    public function RandomState()
    {
        return self::randomElement([
            Task::STATE_CREATED,
            Task::STATE_INPROGRESS,
            Task::STATE_CLOSED
        ]);
    }
}
