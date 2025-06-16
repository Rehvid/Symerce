<?php

declare(strict_types=1);

namespace App\Common\Application\Search\Parser;

use App\Common\Application\Search\Builder\SearchCriteriaBuilder;
use App\Common\Application\Search\Contracts\SearchParserInterface;
use App\Common\Application\Search\Dto\SearchCriteria;
use App\Common\Application\Search\Dto\SearchData;

final readonly class SearchRequestParser
{
    /**
     * @var SearchParserInterface[]
     */
    private array $parsers;

    public function __construct(array $parsers)
    {
        $this->parsers = $parsers;
    }

    public function parse(SearchData $data): SearchCriteria
    {
        $builder = new SearchCriteriaBuilder();

        foreach ($this->parsers as $parser) {
            $parser->parse($data, $builder);
        }

        return $builder->build();
    }
}
