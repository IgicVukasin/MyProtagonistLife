<?php

namespace App;


use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable implements JWTSubject
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
        'password', 'remember_token', 'email_verified_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function activities(){
        return $this->hasMany(Activity::class);
    }

    public function posts(){
        return $this->hasMany(Post::class);
    }

    public function followers()
    {
        return $this->belongsToMany('App\User', 'users_following', 'user_id', 'following_id')->as('follow');
    }

    public function follow($userId)
    {
        $this->followers()->attach($userId);
    }

    public function unfollow($userId)
    {
        $this->followers()->detach($userId);
    }

    public function following()
    {
        $following = DB::table('users')
            ->leftJoin('users_following', 'users.id', '=', 'users_following.user_id')
            ->where('users.id', '=', $this->id)
            ->select('users_following.following_id')
            ->get();
        $followingIds = [];
        foreach($following as $follow){
            array_push($followingIds, $follow->following_id);
        }
        return $followingIds;
    }
}
