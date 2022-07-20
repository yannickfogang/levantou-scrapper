<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Asin
 *
 * @property int $id
 * @property string $uuid
 * @property string $asin
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\AsinFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Asin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Asin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Asin query()
 * @method static \Illuminate\Database\Eloquent\Builder|Asin whereAsin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Asin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Asin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Asin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Asin whereUuid($value)
 * @mixin \Eloquent
 */
class Asin extends Model
{
    use HasFactory;

    protected  $guarded = [];
    protected  $fillable = [];
}
