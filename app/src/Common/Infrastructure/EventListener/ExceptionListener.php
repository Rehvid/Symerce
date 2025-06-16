<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\EventListener;

use Symfony\Component\HttpKernel\Event\ExceptionEvent;

final readonly class ExceptionListener
{
    public function __construct(
        private ExceptionJsonListener $exceptionJsonListener,
    ) {
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $request = $event->getRequest();

        if ('json' === $request->getContentTypeFormat()) {
            $this->exceptionJsonListener->handle($event);
        }
    }
}
