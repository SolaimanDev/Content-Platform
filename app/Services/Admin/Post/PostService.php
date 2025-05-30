<?php

namespace App\Services\Admin\Post;

use Throwable;
use App\Models\Tag;
use App\Models\Post;
use App\Helpers\ImageHelper;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Notifications\PostStatusChanged;
use Illuminate\Support\Facades\Notification;

class PostService extends BaseService
{
    public function __construct(Post $model)
    {
        parent::__construct($model);
    }

public function createOrUpdate($data, $id = null)
{
    try {
        DB::beginTransaction();

        $newImage = $data['image'] ?? null;
        $existingImage = null;
        $post = null;
        $statusChanged = false;
        $oldStatus = null;

        if ($id !== null) {
            $post = $this->getPostById($id);
            $oldStatus = $post->status;
            $existingImage = $post->image;

            if ($newImage && $existingImage) {
                $this->deleteMedia($existingImage);
            }
        }

        if ($newImage instanceof \Illuminate\Http\UploadedFile) {
            $uploadResult = ImageHelper::uploadWithThumbnail($newImage, 'uploads');
            $data['image'] = $uploadResult['original'] ?? null;
        } else {
            $data['image'] = $existingImage;
        }

        // Check if status is being changed to active (1) or inactive (2)
        if (isset($data['status']) && $id !== null && in_array($data['status'], [1, 2])) {
            $statusChanged = ($data['status'] != $oldStatus);
        }

        // Handle tags
        $tagNames = $data['tags'] ?? [];
        unset($data['tags']);

        if (is_string($tagNames)) {
            $tagNames = explode(',', $tagNames);
        }

        // Create or update post
        if ($id === null) {
            $post = $this->model->create($data);
        } else {
            $post->update($data);
        }

        // Sync tags using morph relationship
        $tags = [];
        foreach ($tagNames as $tagName) {
            $tagName = trim($tagName);
            if ($tagName !== '') {
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                $tags[] = $tag->id;
            }
        }
        $post->tags()->sync($tags);

        // Send notification if status changed to active/inactive
        if ($statusChanged && in_array($post->status, [1, 2])) {
            $this->notifyStatusChange($post);
        }

        DB::commit();

        return $post;
    } catch (\Throwable $th) {
        DB::rollBack();
        
        if (isset($uploadResult)) {
            ImageHelper::delete([$uploadResult['original'], $uploadResult['thumbnail']]);
        }
        
        throw $th;
    }
}

protected function notifyStatusChange($post)
{
    // Get the post author (assuming post belongs to a user)
    $user = $post->user;
    
    // Send notification via queue
    Notification::send($user, new PostStatusChanged($post, $post->status));
}
    public function delete($id)
    {
        try {
            $item = $this->getPostById($id);
            if ($item->image) {
                try {
                    $this->deleteMedia($item->image);
                } catch (Throwable $th) {
                    logger($th);
                }
            }

            return $item->delete();
        } catch (Throwable $th) {
            logger($th);
        }
    }

    public function deleteMedia($path = null)
    {
        return Storage::disk('public')->delete($path);
    }
    public function getPostById($id)
    {
        return Post::findOrFail($id);
    }



}

