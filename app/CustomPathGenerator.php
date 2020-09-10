<?php

namespace App;

use App\User;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

class CustomPathGenerator implements PathGenerator {

    public function getPath(Media $media): string
    {
        $date = date('m.Y');
        if ($media->model_type == User::class)
        {
            return "users/$date/$media->id" . '/';
        } else if ($media->model_type == Course::class)
        {
            return "courses/$date/$media->id" . '/';
        } else if ($media->model_type == Bundle::class)
        {
            return "bundles/$date/$media->id" . '/';
        } else if ($media->model_type == Material::class)
        {
            return "materials/$date/$media->id" . '/';
        } else if ($media->model_type == Topic::class)
        {
            return "topics/$date/$media->id" . '/';
        }
    }

    public function getPathForConversions(Media $media): string
    {
        return $this->getPath($media) . 'conversions/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getPath($media) . 'responsive/';
    }

}
