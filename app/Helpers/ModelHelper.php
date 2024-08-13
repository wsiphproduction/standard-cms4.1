<?php


namespace App\Helpers;

use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class ModelHelper
{
    public static function convert_to_slug($model, $url, $parentPages = []){
        $url = Str::slug($url, '-');
        $urls = [];
        
        if($parentPages) {
            foreach ($parentPages as $parentId) {
                $parentPage = $model::find($parentId);
                if ($parentPage) {
                    $parentSlug = $parentPage->slug;
                    $urls[] = $parentSlug . '/' . $url;
                }
            }
        }

        $uniqueUrls = [];
        foreach ($urls as $url) {
            if (in_array($url, $uniqueUrls)) {
                $counter = 2;
                $tempUrl = $url . '-' . $counter;
                while (in_array($tempUrl, $uniqueUrls)) {
                    $tempUrl = $url . '-' . $counter;
                    $counter += 1;
                }
                $url = $tempUrl;
            }
            $uniqueUrls[] = $url;
        }

        if($uniqueUrls){
            return $uniqueUrls;
        } else {
            return [$url];
        }
    }

    private static function check_if_slug_exists($model, $slug){
        return ($model::withTrashed()->where('slug', '=', $slug)->exists());
    }

    public static function date_str($date) {
        return date('M d, Y', strtotime($date));
    }

    public static function date_time_str($date) {
        return date('M d, Y h:i A', strtotime($date));
    }
}
