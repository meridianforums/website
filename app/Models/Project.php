<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Project extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'short_description', 'description', 'image_path', 'forum_url', 'is_active', 'license_key',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'license_key',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function image(): ?string
    {
        if ($this->image_path)
        {
            return Storage::url($this->image_path);
        }

        return 'https://eu.ui-avatars.com/api/?name='.$this->name.'&size=200';
    }

    public function owner(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function deleteImage()
    {
        Storage::delete($this->image_path);
        $this->image_path = null;
        $this->save();
    }
}
