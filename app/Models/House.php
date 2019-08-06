<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class House
 * @package App\Models
 */
class House extends Model
{
    /**
     * @const integer
     */
    const PER_PAGE = 5;

    /**
     * @var string
     */
    protected $table = 'houses';

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @param array $queryData
     * @return Collection
     */
    public function fetchFoundData(array $queryData): Collection
    {
        $query = self::newQuery();

        $this->checkPriceExistence($queryData);

        foreach ($queryData as $field => $value) {
            if ($field === 'name') {
                $query->where('name', 'iLike', '%' . $value . '%');
            } else if ($field === 'price') {
                $query->whereBetween('price', [$value['from'], $value['to']]);
            } else {
                $query->where($field, $value);
            }
        }

        return $query->get();
    }

    /**
     * @param array $queryData
     */
    protected function checkPriceExistence(array &$queryData) : void
    {
        if (empty($queryData['price']['from']) && empty($queryData['price']['to'])) {
            unset($queryData['price']);
        }
    }
}
