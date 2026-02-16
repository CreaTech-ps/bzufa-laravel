<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutPage extends Model
{
    protected $table = 'about_page';

    protected $fillable = ['story_video_url', 'team_video_url'];

    public static function get(): self
    {
        $row = static::first();
        if ($row) {
            return $row;
        }
        return static::create([]);
    }
}
