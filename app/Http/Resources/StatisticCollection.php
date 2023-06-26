<?php

namespace App\Http\Resources;

use App\Actions\Statistics\ViewLinkStatistics;
use App\Models\LinkStatistic;
use Illuminate\Http\Resources\Json\ResourceCollection;

class StatisticCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return fn ($collection) => app(ViewLinkStatistics::class)->get($this->collection);
        // return ViewLinkStatistics$this->collection;
        return $this->collection;
    }
}
