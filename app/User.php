<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Guide;
use App\Group;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function guides()
    {
        return $this->hasMany(Guide::class, 'id', 'guide_id');
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }

    public function isAdmin()
    {
        return in_array('Admin', $this->groups->pluck('title')->toArray());
    }

    public function hasGroup($group)
    {
        if (auth()->user()->isAdmin()) {
            return true;
        }
        return in_array($group, $this->groups->pluck('title')->toArray());
    }

    public function scopeRecentGuides()
    {
        $recentViewed = Guide::whereIn(
            'id',
            Recent::select('recentable_id')->where('user_id', auth()->user()->id)->where('recentable_type', 'App\Guide')->orderBy('updated_at', 'desc')->take(2)->get()
        )->simplePaginate(2);
        //return $this->morphToMany('App\Guide', 'recentable', 'recents', 'user_id', 'recentable_id', 'id', 'recentable_id');
        return $recentViewed;
    }
}