<?php declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaPolicy
{
    public function view(User $user, Media $media): Response
    {
        return Response::allow();
    }
}
