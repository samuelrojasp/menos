<?php

namespace App;

class Taxon extends \Vanilo\Category\Models\Taxon
{
    public function orderItems()
    {
        return $this->morphedByMany(
            OrderItem::class,
            'model',
            'model_taxons',
            'taxon_id',
            'model_id'
        );
    }
}
