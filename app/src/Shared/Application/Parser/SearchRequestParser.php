<?php

declare (strict_types = 1);

namespace App\Shared\Application\Parser;

use App\Shared\Application\Builder\SearchCriteriaBuilder;
use App\Shared\Application\Contract\RequestParserInterface;
use App\Shared\Application\DTO\Filter\SearchCriteria;
use Symfony\Component\HttpFoundation\Request;

final readonly class SearchRequestParser
{
    /**
     * @var RequestParserInterface[]
     */
    private array $parsers;

    public function __construct(array $parsers)
    {
        $this->parsers = $parsers;
    }

    public function parse(Request $request): SearchCriteria
    {
        $builder = new SearchCriteriaBuilder();

        foreach ($this->parsers as $parser) {
            $parser->parse($request, $builder);
        }

        return $builder->build();
    }
}
