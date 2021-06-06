<?php

namespace Trainner\Models;

use Stalker\Models\Photo as PhotoBase;

/**
 * Class Photo.
 *
 * @property int id
 * @property int created_by_user_id
 * @property int localization_id
 * @property string path
 * @property string avg_color
 * @property array metadata
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property User createdByUser
 * @property User location
 * @property Collection thumbnails
 * @property Post post
 * @property Collection posts
 * @package  App\Models
 */
class Photo extends PhotoBase
{
    
}
