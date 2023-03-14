<?php

namespace App\Http\Services\V1;

use App\Jobs\V1\QueuedMediaUpload;
use App\Models\Accounts;
use App\Models\Attachment;
use App\Models\Media;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Controllers\Api\V1\Helper\ApiResponse;

class MediaService
{
    use ApiResponse;


    public function update($request, $user)
    {
    }
    public function store($request)
    {
        //return $request;
        $file = $request['file'];
        $newMediaData = [
            'mime_type' => $file->getMimeType(),
            'name' => $file->getClientOriginalName(),
            'short_link' => $this->fileUpload($request['file']),
            'description' => isset($request['description']) ? $request['description'] : NULL,
            'meta_description' => isset($request['description']) ? $request['meta_description'] : NULL,
            'status' => isset($request['status']) ? $request['status'] : 0,
        ];
        $newMedia = Media::create($newMediaData);
        return $newMedia;
    }

    public function fileUpload($file): string
    {
        $save_pdf_path = Media::$MEDIA_UPLOAD_PATH . date("Ym");
        if (!Storage::directoryExists($save_pdf_path)) {
            Storage::makeDirectory($save_pdf_path, 0777, true, true); //making direcotry
        }
        $file = Storage::put($save_pdf_path, $file);
        $savePath = Storage::url($file);
        // $savePath= QueuedMediaUpload::dispatch($file,$save_pdf_path);
        return $savePath;
    }

    public function storeMediaAttachement($request)
    {

        $attachementData = [
            'media_id' => $request['media_id'],
            'attachmentable_type' => $request['attachmentable_type'],
            'attachmentable_id' => $request['attachmentable_id'],
            'short_link' => isset($request['short_link']) ? $request['short_link'] : NULL,
            'file_name' => isset($request['file_name']) ? $request['file_name'] : NULL,
            'description' => isset($request['description']) ? $request['description'] : NULL,
            'meta_data' => isset($request['meta_data']) ? $request['meta_data'] : NULL,
            'status' => isset($request['status']) ? $request['status'] : 0,

        ];

        $newAttachement = Attachment::create($attachementData);
        return $newAttachement;
    }

    public function destroy($media_id, $attachment_id = \null)
    {
        try {
            DB::beginTransaction();
            $attachement = Attachment::where('media_id', $media_id)->get();

            if (count($attachement) > 0) {
                $getOneAttachment = Attachment::find($attachment_id);

                if ($getOneAttachment) {
                    $getOneAttachment->delete();
                    DB::commit();
                    return $this->success();
                }
                return $this->error('Attachement Not Found', 404);
            }
            // elseif (count($attachement) == 1) {
            //     $media = Media::find($media_id);
            //     if (($media)) {
            //         $this->deleteExistingFile($media->short_link);
            //         $media->delete();
            //     }

            //     $attachement[0]->delete();

            //     DB::commit();
            //     return $this->success(null);
            // }
            else {
                $media = Media::find($media_id);
                if (($media)) {
                    $this->deleteExistingFile($media->short_link);
                    $media->delete();
                    DB::commit();
                    return $this->success();
                } else {
                    return $this->error('Media Not Found', 404);
                }
            }
            return $this->error('data not found', 404);
        } catch (\Exception $th) {
            DB::rollBack();
            return $this->error($th->getMessage(), $th->getCode());
        }
    }

    public function deleteExistingFile($fileLink)
    {
        if ($fileLink != null) {
            $currentLink = str_replace('/storage', '/public', $fileLink);


            if (Storage::exists($currentLink)) {
                Storage::delete($currentLink);
            }
        }
    }
}
