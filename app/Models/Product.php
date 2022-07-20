<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $uuid
 * @property string $title
 * @property string $description
 * @property string $description_html
 * @property float $price
 * @property string $asin
 * @property string|null $seller_by
 * @property string|null $sender_on_store
 * @property string|null $currency
 * @property string|null $publish_date
 * @property string|null $evaluation
 * @property string|null $best_seller_rank
 * @property string|null $link_concurrent_product
 * @property string|null $categories
 * @property mixed|null $concurrent_products
 * @property mixed|null $images
 * @property mixed|null $related_products
 * @property mixed|null $product_bought_together
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\ProductFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereAsin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereBestSellerRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCategories($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereConcurrentProducts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDescriptionHtml($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereEvaluation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereLinkConcurrentProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereProductBoughtTogether($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePublishDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereRelatedProducts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSellerBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSenderOnStore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUuid($value)
 * @mixin \Eloquent
 */
class Product extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $guarded = [];
    protected $casts = [
        'concurrent_products' => 'array',
        'images' => 'array',
        'related_products' => 'array',
        'product_bought_together' => 'array'
    ];
}
