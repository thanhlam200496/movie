<?php

  

namespace App\Models;

  

use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Notifications\Notifiable;

use Laravel\Fortify\TwoFactorAuthenticatable;

use Laravel\Jetstream\HasProfilePhoto;

use Laravel\Sanctum\HasApiTokens;

  

class User extends Authenticatable

{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**

     * The attributes that are mass assignable.

     *

     * @var string[]

     */

    protected $fillable = [

        'name',

        'email',

        'password',

        'google_id'

    ];

  

    /**

     * The attributes that should be hidden for serialization.

     *

     * @var array

     */

    protected $hidden = [

        'password',

        'remember_token',

        'two_factor_recovery_codes',

        'two_factor_secret',

    ];

  

    /**

     * The attributes that should be cast.

     *

     * @var array

     */

    protected $casts = [

        'email_verified_at' => 'datetime',

    ];
    /**

     * The accessors to append to the model's array form.

     *

     * @var array

     */

    // protected $appends = [

    //     'profile_photo_url',

    // ];
    public function viewHistories()
    {
        return $this->hasMany(ViewHistory::class);
    }

    public function searchLogs()
    {
        return $this->hasMany(SearchLog::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

}