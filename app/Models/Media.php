<?php

namespace App\Models;

use Illuminate\Http\UploadedFile;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
class Media extends \Plank\Mediable\Media
{

    protected $table = 'media';

    public function scopeQueryFilter(Builder $query, $search): Builder
    {
        if (!isset($search) && $search === "") {
            return $query;
        }

        return $query->likeWhere(['filename'], $search);
    }


    public function scopeFiletype(Builder $query, $val): Builder
    {
        if (empty($val)) {
            return $query;
        }

        if ($val === "video") {
            return $query->where(column: 'aggregate_type', value: self::TYPE_VIDEO);
        }
        if ($val === "audio") {
            return $query->where(column: 'aggregate_type', value: self::TYPE_AUDIO);
        }
        if ($val === "image/svg xml") {
            return $query->where(column: 'aggregate_type', value: self::TYPE_IMAGE_VECTOR);
        }

        if ($val === "image") {
            return $query->where(column: 'aggregate_type', value: self::TYPE_IMAGE);
        }

        if ($val === "attachment") {
            return $query->whereIn('aggregate_type', [
                self::TYPE_DOCUMENT,
                self::TYPE_PDF,
                self::TYPE_SPREADSHEET,
                self::TYPE_PRESENTATION,
            ]);
        }

        return $query;

    }


    public function photo(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return $this->getUrl();
            },
            set: function ($value) {
                $value instanceof UploadedFile ? $value->storeAs(
                    $this->getDiskPath(),
                    $this->getBaseName(),
                    $this->disk
                ) : $value;
            }
        );
    }

    public function setFile(UploadedFile $file): void
    {
        $file->storePubliclyAs(
            $this->getDiskPath(),
            $this->getBaseName(),
            $this->disk
        );
    }
}
