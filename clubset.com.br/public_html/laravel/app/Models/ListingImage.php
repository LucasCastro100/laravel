<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * An image attached to a listing.
 *
 * @property int $id
 * @property int $listing_id
 * @property string $path
 * @property int $sort_order
 * @property-read string $url
 * @property-read Listing $listing
 */
#[Fillable(['listing_id', 'path', 'sort_order'])]
class ListingImage extends Model
{
    /**
     * Get the listing that owns this image.
     *
     * @return BelongsTo<Listing, $this>
     */
    public function listing(): BelongsTo
    {
        return $this->belongsTo(Listing::class);
    }

    /**
     * Get the full URL for this image.
     */
    protected function url(): Attribute
    {
        return Attribute::get(
            fn (): string => asset('storage/'.$this->path),
        );
    }
}
