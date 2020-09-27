<?php

namespace App\Message\Query;

use App\Enum\HttpMetaKeyEnum;

class AbstractListQuery
{
    const DEFAULT_IPP = 15;

    /**
     * @var int
     */
    protected int $limit;

    /**
     * @var int
     */
    protected int $offset;

    public function __construct(array $params)
    {
        foreach ($params as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }

        $this->limit = $params[HttpMetaKeyEnum::LIMIT] ?? self::DEFAULT_IPP;
        $this->offset = $params[HttpMetaKeyEnum::OFFSET] ?? 0;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }
}
