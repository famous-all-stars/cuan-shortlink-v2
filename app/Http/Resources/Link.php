<?php

namespace App\Http\Resources;

use App\Actions\Statistics\ViewLinkStatistics;
use App\Helpers\Allstars;
use App\Models\LinkStatistic;
use Illuminate\Http\Resources\Json\JsonResource;

class Link extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'label' => $this->label,
            'slug' => $this->slug,
            'full_link' => $this->full_link,
            'secret' => Allstars::encrypt($this->secret),
            'description' => $this->description,
            'shortlink' => $this->shortlink,
            'clicks' => $this->statistics_count,
            'statistics' => $this->whenLoaded('statistics', new StatisticCollection($this->statistics), [])
        ];
    }
}
