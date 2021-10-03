<?php

namespace Trainner\Models;

use Croppa;
use Support\Template\Markup\ImageElement;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Polymorphic one to many class that stores images for any model.
 */
class Image extends Model
{

    /**
     * JSON serialization
     *
     * @var array
     */
    protected $visible = [
        'icon',
        'xs', 'xs2x',
        's', 's2x',
        'm', 'm2x',
        'l', 'l2x',
        'xl', 'xl2x',
        'bkgd_pos',
        'title',
    ];

    /**
     * @var array
     */
    protected $appends = [
        'icon',
        'xs', 'xs2x',
        's', 's2x',
        'm', 'm2x',
        'l', 'l2x',
        'xl', 'xl2x',
        'bkgd_pos',
        'url',
        'js_url',
        'data_url',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'file_size'   => 'integer',
        'width'       => 'integer',
        'height'      => 'integer',
        'crop_box'    => 'object',
        'focal_point' => 'object',
    ];

    /**
     * Validation rules
     *
     * @return array
     */
    public static $rules = [
        'file' => 'image',
        'location' => 'mimes:jpeg,jpg,bmp,png,gif',
    ];

    /**
     * Uploadable attributes
     *
     * @var array
     */
    protected $upload_attributes = ['file'];

    /**
     * Target aspect ratios for the different break points
     *
     * @var array
     */
    protected $sizes = [
        'icon' => [64, 64],    // Icon size
        'xs' => [480, 768],    // Phone portrait
        's'  => [768, 1024],   // Tablet portrait
        'm'  => [1024, 768],   // Tablet landscape
        'l'  => [1366, 768],   // Laptop
        'xl' => [1920, 1080],  // Desktop
    ];

    /**
     * Laptop width is the default size that is used to produce scale percentages
     *
     * @var number
     */
    protected $bench = 1366;

    /**
     * Stores config from chained transformations while a url or tag is generated
     *
     * @var array
     */
    private $config = [];


    /**
     * Register events
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        // Convert input strings to objects for casted attributes
        static::saving(
            function (Image $image) {
                $image->convertCastedJson();
            }
        );

        // Need to process file meta before Upchuck converts the UploadFile object
        // to a URL string.  If the image file attribute has been set to empty,
        // stop the save and immediately delete.
        static::saving(
            function (Image $image) {
                if ($image->deletedBecauseEmpty()) {
                    return false;
                }
                $image->populateFileMeta();
            }
        );

        // If the image is deleted, delete Croppa crops
        static::updating(
            function (Image $image) {
                if ($image->isDirty('file')) {
                    $image->deleteCrops();
                }
            }
        );
        static::deleted(
            function (Image $image) {
                $image->deleteCrops();
            }
        );
    }

    /**
     * Polymorphic relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function imageable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Convert strings that may have been `fill()`ed but need to be objects to
     * work with Laravel casting
     *
     * @return void
     */
    public function convertCastedJson()
    {
        foreach ($this->casts as $attribute => $cast) {
            if ($cast != 'object') {
                continue;
            }
            if (($val = $this->getAttributeValue($attribute))
                && is_string($val)
            ) {
                $this->setAttribute($attribute, json_decode($val));
            }
        }
    }

    /**
     * If the file attribtue is empty, this Image has been marked for deletion.
     * Return true to signal the image was deleted
     *
     * @return bool
     */
    public function deletedBecauseEmpty()
    {
        if ($file = $this->getAttributeValue('file')) {
            return false;
        }

        if ($this->exists) {
            $this->delete();
        }

        return true;
    }

    /**
     * Store file meta info in the database if a new File object is present
     *
     * @return void
     */
    public function populateFileMeta()
    {
        $file = $this->getAttributeValue('file');
        if (!is_a($file, UploadedFile::class)) {
            return;
        }
        $size = getimagesize($file->getPathname());
        $this->fill(
            [
            'file_type' => $this->guessFileType($file),
            'file_size' => $file->getSize(),
            'width'     => $size[0],
            'height'    => $size[1],
            ]
        );
    }

    /**
     * Delete the crops that Croppa has made for the image
     *
     * @return void
     */
    public function deleteCrops()
    {
        // Get at the file path using "original" so this function can be called as
        // part of an "updating" callback
        $file = $this->getOriginal('file');

        // Tell Croppa to delete the crops.  The actual file will be deleted by
        // Upchuck automatically.
        Croppa::reset($file);
    }

    /**
     * Get file type
     *
     * @param UploadedFile
     *
     * @return null|string
     */
    protected function guessFileType(UploadedFile $file): ?string
    {
        $type = $file->guessClientExtension();
        switch ($type) {
        case 'jpeg': 
            return 'jpg';
        default: 
            return $type;
        }
    }

    /**
     * Set the crop dimenions
     *
     * @param  integer $width
     * @param  integer $height
     * @param  array   $options Croppa options array
     * @return $this
     */
    public function crop($width = null, $height = null, $options = null)
    {
        $this->config = [
            'width'   => $width,
            'height'  => $height,
            'options' => $options,
        ];

        return $this;
    }

    /**
     * Get the config, merging defaults in so that all keys in the array are
     * present.  This also applies the crop choices from the DB.
     *
     * @return array
     */
    public function getConfig()
    {
        // Create default keys for the config
        $config = array_merge(
            [
            'width'   => null,
            'height'  => null,
            'options' => null,
            ], $this->config
        );

        // Add crops
        if ($crop = $this->getAttributeValue('crop_box')) {
            if (!is_array($config['options'])) {
                $config['options'] = [];
            }
            $config['options']['trim_perc'] = [
                round($crop->x1, 4),
                round($crop->y1, 4),
                round($crop->x2, 4),
                round($crop->y2, 4),
            ];
        }

        // Return config
        return $config;
    }

    /**
     * Output the image URL with any queued Croppa transformations.  Note, it's
     * possible that "file" is empty, in which case this returns an empty string.
     * This clears the stored config on every call.
     *
     * @return null|string
     */
    public function getUrlAttribute(): ?string
    {
        // Figure out the URL
        $url = $this->getLAttribute(); // The benchmark

        // Clear the instance config so that subsequent calls don't inherit anything
        $this->config = [];

        // Return the url
        return $url;
    }

    // /**
    //  * Get the images url location. (Da outra classe, antiga) @todo
    //  *
    //  * @param string $value
    //  *
    //  * @return string
    //  */
    // public function getUrlAttribute()
    // {
    //     return $this->remember('url', function () {
    //         if ($this->isLocalFile()) {
    //             return url(str_replace('public/', 'storage/', $this->location));
    //         }

    //         return FileService::fileAsPublicAsset($this->location);
    //     });
    // }

    /**
     * Output image for background style
     *
     * @return string
     */
    public function getBkgdAttribute()
    {
        return sprintf('background-image: url(\'%s\');', $this->getUrlAttribute())
            .$this->getBackgroundPositionAttribute();
    }

    /**
     * Output an image tag.  The ?: was necessary because HtmlObject sets NULL
     * values to "true" in the rendered attribute.
     *
     * @return Element
     */
    public function getTagAttribute()
    {
        return ImageElement::img()
            ->isSelfClosing()
            ->src($this->getUrlAttribute() ?: false)
            ->alt($this->getAttribute('title') ?: false);
    }

    /**
     * Output a div tag.
     *
     * @link https://www.w3.org/TR/wai-aria/roles#img
     *
     * @return Element
     */
    public function getDivAttribute()
    {
        return ImageElement::div()
            ->style($this->getBkgdAttribute())
            ->role('img')
            ->ariaLabel($this->getAltAttribute());
    }

    /**
     * Convert the focal_point attribute to a CSS background-position.
     *
     * @return null|string
     */
    public function getBackgroundPositionAttribute()
    {
        if (!$value = $this->getBkgdPosAttribute()) {
            return;
        }

        return sprintf('background-position: %s;', $value);
    }

    /**
     * Convert the focal point to the VALUE portion of the CSS
     * background-position.  This is also used in the serialization conversion
     * and is named to be friendly to that format.
     *
     * @return null|string
     */
    public function getBkgdPosAttribute()
    {
        if (!$point = $this->getAttributeValue('focal_point')) {
            return;
        }

        return sprintf('%s%% %s%%', $point->x*100, $point->y*100);
    }

    /**
     * Convenience accessor for the title attribute
     *
     * @return string
     */
    public function getAltAttribute()
    {
        return $this->getAttributeValue('title');
    }

    /**
     * Accessors for different sizes.  They are calculated has percentages of
     * 1366, which we take to be the 1x "desktop" resolution.  1366 is currently
     * the most popular desktop resolution.
     *
     * @return null|string
     */
    public function getIconAttribute(): ?string
    {
        return $this->urlify('icon');
    }

    /**
     * @return null|string
     */
    public function getXsAttribute(): ?string
    {
        return $this->urlify('xs');
    }

    /**
     * @return null|string
     */
    public function getXs2xAttribute(): ?string
    {
        return $this->urlify('xs', 2);
    }

    /**
     * @return null|string
     */
    public function getSAttribute(): ?string
    {
        return $this->urlify('s');
    }

    /**
     * @return null|string
     */
    public function getS2xAttribute(): ?string
    {
        return $this->urlify('s', 2);
    }

    /**
     * @return null|string
     */
    public function getMAttribute(): ?string
    {
        return $this->urlify('m');
    }

    /**
     * @return null|string
     */
    public function getM2xAttribute(): ?string
    {
        return $this->urlify('m', 2);
    }

    /**
     * @return null|string
     */
    public function getLAttribute(): ?string
    {
        return $this->urlify('l');
    }

    /**
     * @return null|string
     */
    public function getL2xAttribute(): ?string
    {
        return $this->urlify('l', 2);
    }

    /**
     * @return null|string
     */
    public function getXlAttribute(): ?string
    {
        return $this->urlify('xl');
    }

    /**
     * @return null|string
     */
    public function getXl2xAttribute(): ?string
    {
        return $this->urlify('xl', 2);
    }

    /**
     * Make paths full URLs so these can be used directly in APIs or for Open
     * Graph tags, for example.
     *
     * @param string $size
     * @param number $scale
     * @param int $multiplier
     *
     * @return null|string url
     */
    public function urlify($size, int $multiplier = 1): ?string
    {
        // Get fluent config
        $config = $this->getConfig();

        // Setup vars
        $size = $this->sizes[$size];
        $scale = $size[0] / $this->bench;
        $width = $height = null;

        // Figure out percentage sizes.  First one of the dimensnios is tested
        // to see if it looks a percentage.  If so, make it a percentage of one of
        // the hard coded sizes.  Otherwise, scale the dimension by comaring the
        // size to a the benchmark (laptop).
        if ($perc = $this->perc($config['width'])) {
            $width = $perc * $size[0] * $multiplier;
        } elseif ($config['width']) {
            $width = $config['width'] * $scale * $multiplier;
        }
        if ($perc = $this->perc($config['height'])) {
            $height = $perc * $size[1] * $multiplier;
        } elseif ($config['height']) {
            $height = $config['height'] * $scale * $multiplier;
        }

        // Produce the Croppa URL
        $path = Croppa::url(
            $this->getAttributeValue('file'),
            $width,
            $height,
            $config['options']
        );
        if ($path) {
            return asset($path);
        }
    }

    /**
     * Get a percent number from a string
     *
     * @param string|number val
     *
     * @return float|null
     */
    protected function perc($val): ?float
    {
        if (preg_match('#([\d\.]+)%$#', $val, $matches)) {
            return floatval($matches[1])/100;
        }
    }

    /**
     * Don't log changes since they aren't really the result of admin input
     *
     * @param  string $action
     * @return boolean
     */
    public function shouldLogChange($action)
    {
        return false;
    }




    /***
     * Adicionei do outro Image Class
     */
    /**
     * Get the images url location.
     *
     * @param string $value
     *
     * @return string
     */
    public function getJsUrlAttribute()
    {
        return $this->remember(
            'js_url', function () {
                if ($this->isLocalFile()) {
                    $file = url(str_replace('public/', 'storage/', $this->location));
                } else {
                    $file = FileService::fileAsPublicAsset($this->location);
                }

                return str_replace(url('/'), '', $file);
            }
        );
    }

    /**
     * Get the images url location.
     *
     * @param string $value
     *
     * @return string
     */
    public function getDataUrlAttribute()
    {
        return $this->remember(
            'data_url', function () {
                if ($this->isLocalFile()) {
                    $imagePath = storage_path('app/'.$this->location);
                } else {
                    $imagePath = Storage::disk(\Illuminate\Support\Facades\Config::get('gpower.storage-location', 'local'))->url($this->location);
                }

                $image = InterventionImage::make($imagePath)->resize(800, null);

                return (string) $image->encode('data-url');
            }
        );
    }

    /**
     * @param string $attribute
     * @param \Closure $closure
     */
    public function remember(string $attribute, \Closure $closure)
    {
        $key = $attribute.'_'.$this->location;

        if (!Cache::has($key)) {
            $expiresAt = Carbon::now()->addMinutes(15);
            Cache::put($key, $closure(), $expiresAt);
        }

        return Cache::get($key);
    }

    /**
     * Check the location of the file.
     *
     * @return bool
     */
    private function isLocalFile()
    {
        try {
            $headers = @get_headers(url(str_replace('public/', 'storage/', $this->location)));

            if (strpos($headers[0], '200')) {
                return true;
            }
        } catch (Exception $e) {
            Log::debug('Could not find the image');

            return false;
        }

        return false;
    }
}
