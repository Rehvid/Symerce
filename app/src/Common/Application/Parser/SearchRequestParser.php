<?php

declare (strict_types = 1);

namespace App\Common\Application\Parser;

use App\Common\Application\Builder\SearchCriteriaBuilder;
use App\Common\Application\Contracts\RequestParserInterface;
use App\Common\Application\Dto\Filter\SearchCriteria;
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
