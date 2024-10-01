<?php declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection<int, Media> $media
 */
class User extends Authenticatable implements HasMedia
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, InteractsWithMedia;

    public const string COLLECTION_PHOTOS = 'photos';
    public const string CONVERSION_THUMB = 'thumb';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    #[\Override]
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    #[\Override]
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::COLLECTION_PHOTOS);
    }

    #[\Override]
    public function registerMediaConversions(Media|null $media = null): void
    {
        $this->addMediaConversion(self::CONVERSION_THUMB)
            ->performOnCollections([self::COLLECTION_PHOTOS])
            ->width(100)
            ->height(100);
    }
}
