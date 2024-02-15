<?php

namespace App\Models;

use Ariaieboy\LaravelSafeBrowsing\Facades\LaravelSafeBrowsing;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShortLinks extends Model
{
    use HasFactory;

    const LINK_HASH_LENGTH = 6;
    const LINK_MAX_LENGTH = 2047;

    public $timestamps = false;
    protected $fillable = [
        'id',
        'link',
        'safe_status_bool', # null, true, false
        'safe_status_text', # '', 'status'
    ];

    /**
     * Generate Short Link and add to DB.
     */
    static function generateAndAdd(string $link): array
    {
        $hash = static::hashGet($link);
        try {
            $safe_status = LaravelSafeBrowsing::isSafeUrl($link, true);
            // case when a record exists, but the service was not available previously
            $exists_record = static::find($hash);
            if ($exists_record &&
                $exists_record->safe_status_bool === null &&
                $exists_record->safe_status_text === null) {
                $exists_record->delete();
            }
            // adding record
            $data = [
                'id'               => $hash,
                'link'             => $link,
                'safe_status_bool' => is_string($safe_status) ? false        : true,
                'safe_status_text' => is_string($safe_status) ? $safe_status : '' ];
            static::insertOrIgnore($data);
            return $data;
        } catch (Exception $e) {
            // adding record anyway
            $data = [
                'id'               => $hash,
                'link'             => $link,
                'safe_status_bool' => null,
                'safe_status_text' => null ];
            static::insertOrIgnore($data);
            return $data;
        }
    }

    /**
     * Generate Short Link hash.
     */
    static function hashGet($link)
    {
        return substr(str_replace(['+', '/'], '', base64_encode(md5($link))), 0, static::LINK_HASH_LENGTH);
    }

}
