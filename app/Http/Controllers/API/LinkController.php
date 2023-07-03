<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Concerns\Helper;
use App\Http\Requests\LinkStoreRequest;
use App\Http\Requests\LinkUpdateRequest;
use App\Http\Resources\Link as ResourcesLink;
use App\Http\Resources\LinkCollection;
use App\Models\Link;
use App\Models\LinkStatistic;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LinkController extends Controller
{
    use Helper;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request->user()->tokenCan('read')) {
            return $this->responseError('Forbidden', Response::HTTP_FORBIDDEN);
        }
        $links = ($search = $request->search) ? Link::search($search)->paginate() : Link::latest()->paginate();
        $links->loadCount('statistics');
        return $this->responseSuccess(new LinkCollection($links), 'OK', Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LinkStoreRequest $request)
    {
        if (!$request->user()->tokenCan('create')) {
            return $this->responseError('Forbidden', Response::HTTP_FORBIDDEN);
        }
        $link = Link::create($request->validated());
        return $this->responseSuccess(new ResourcesLink($link), 'OK', Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if (!$request->user()->tokenCan('read')) {
            return $this->responseError('Forbidden', Response::HTTP_FORBIDDEN);
        }
        try {
            $link = Link::findOrFail((int)$id);
        } catch (\Throwable $th) {
            return $this->responseError('Link not found', Response::HTTP_FORBIDDEN);
        }
        $link->loadCount('statistics');
        return $this->responseSuccess(new ResourcesLink($link), 'OK', Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LinkUpdateRequest $request, $id)
    {
        if (!$request->user()->tokenCan('update')) {
            return $this->responseError('Forbidden', Response::HTTP_FORBIDDEN);
        }
        try {
            $link = Link::findOrFail((int)$id);
        } catch (\Throwable $th) {
            return $this->responseError('Link not found', Response::HTTP_FORBIDDEN);
        }
        $link->update($request->validated());
        return $this->responseSuccess(new ResourcesLink($link), 'OK', Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if (!$request->user()->tokenCan('delete')) {
            return $this->responseError('Forbidden', Response::HTTP_FORBIDDEN);
        }
        try {
            $link = Link::findOrFail((int)$id);
        } catch (Exception $th) {
            return $this->responseError('Link not found', Response::HTTP_FORBIDDEN);
        }
        $link->delete();
        return $this->responseSuccess(null, 'OK', Response::HTTP_OK);
    }

    // /**
    //  * Get links with statistics
    //  */
    // public function statistics(Request $request, $id)
    // {
    //     if (!$request->user()->tokenCan('read')) {
    //         return $this->responseError('Forbidden', Response::HTTP_FORBIDDEN);
    //     }
    //     try {
    //         $link = Link::with(['statistics'])->where('id', $id)->first();
    //     } catch (Exception $th) {
    //         return $this->responseError('Link not found', Response::HTTP_FORBIDDEN);
    //     }
    //     return $this->responseSuccess(new ResourcesLink($link), 'OK', Response::HTTP_OK);
    // }
}
