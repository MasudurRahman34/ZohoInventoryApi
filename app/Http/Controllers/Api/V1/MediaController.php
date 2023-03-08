<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\MediaRequest;
use App\Http\Services\V1\MediaService;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MediaController extends Controller
{
    use ApiResponse;
    private $mediaService;
    public function __construct(MediaService $mediaService = null)
    {
        $this->mediaService = $mediaService;
    }

    public function index()
    {
        $media = Media::get();
        return $this->success($media);
    }

    public function store(MediaRequest $request)
    {
        //return $request;

        try {
            DB::BeginTransaction();
            $request = $request->all();
            // foreach ($request['media'] as $key => $item) {
            $newMedia = $this->mediaService->store($request);
            // }

            DB::commit();
            return $this->success($newMedia);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->error($th->getMessage(), 422);
        }
    }


    public function storeMediaAttachement(Request $request)
    {
        //return $request;

        try {
            DB::BeginTransaction();
            $request = $request->all();
            if ($request['source'] === 'invoice') {
                $request['attachmentable_type'] = Media::$MEDIA_REFERENCE_TABLE['invoice'];
            }
            foreach ($request['media_id'] as $key => $item) {
                $attachement = [];
                $attachement['attachmentable_id'] = $request['attachmentable_id'];
                $attachement['attachmentable_type'] = $request['attachmentable_type'];
                $attachement['media_id'] = $item;
                $newAttachement = $this->mediaService->storeMediaAttachement($attachement);
            }

            DB::commit();
            return $this->success($newAttachement);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->error($th->getMessage(), 422);
        }
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }



    public function destroy($media_id, $attachement_id = \null)

    {


        return $this->mediaService->destroy($media_id, $attachement_id);
    }
}
