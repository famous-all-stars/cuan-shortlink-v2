<?php

namespace App\Http\Resources;

use App\Actions\Statistics\ViewLinkStatistics;
use App\Models\LinkStatistic;
use Illuminate\Http\Resources\Json\JsonResource;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Str;

class Statistic extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $agent = $this->createAgent($this->resource);
        return [
            'referer'    => $this->referer,
            'shortlink'  => Str::finish(config('app.url'), '/') . $this->slug,
            'to'         => $this->to,
            'ip_address' => $this->ip_address,
            'success'    => $this->success,
            'agent'      => [
                'platform' => [
                    'name'    => $agent->platform(),
                    'version' => $agent->version($agent->platform())
                ],
                'browser'  => [
                    'name'    => $agent->browser(),
                    'version' => $agent->version($agent->browser(),)
                ],
                'device'   => [
                    'name'    => $agent->device(),
                    'type' => $agent->deviceType()
                ],
            ],
        ];
    }

    /**
     * Create a new agent instance from the given session.
     *
     * @param LinkStatistic $statistic
     *
     * @return \Jenssegers\Agent\Agent
     */
    protected function createAgent(LinkStatistic $statistic)
    {
        return tap(new Agent, function (Agent $agent) use ($statistic) {
            $agent->setUserAgent($statistic->user_agent);
        });
    }
}
