<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use SoftDeletes;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'email',
        'password',
        'personal_id',
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
    protected $appends = [
        'profile_photo_url',
    ];

    public function getIsPersonalAttribute(){
        return (Boolean) $this->personal_id;
    }
    public function getNameAttribute(){
        return optional(optional($this->personal)->persona)->nombre_completo;
    }
    public function getOficinasAttribute(){
        return [optional($this->personal)->oficina];
    }
    public function getUserNameAttribute()
    {
        return Str::before($this->email, '@');
    }

    public function personal(): BelongsTo { return $this->belongsTo(Personal::class); }
    public function scopeSearchFilter($q, String $search){
        return $q->orWhereHas("personal", function($q) use ($search){
            return $q->whereHas("persona", function($q) use ($search){
                return $q->whereNombreLike($search);
            });
        })
        ->orWhere("email", 'ilike', $search);
    }
    // public function caja(): HasOne { return $this->hasOne(Caja::class, 'cajero_id', 'id'); }

    public function user_created(): BelongsTo { return $this->belongsTo(User::class, 'user_created_id', 'id')->withTrashed(); }
    public function user_updated(): BelongsTo { return $this->belongsTo(User::class, 'user_updated_id', 'id')->withTrashed(); }
    public function user_deleted(): BelongsTo { return $this->belongsTo(User::class, 'user_deleted_id', 'id')->withTrashed(); }
    public static function booted(){
        parent::booted();
        static::creating(function($model) {
            $model->user_created_id = optional(Auth::user())->id ?? null;
        });
        static::updating(function($model) {
            $model->user_updated_id = optional(Auth::user())->id ?? null;
        });
        static::restoring(function($model) {
            $model->user_deleted_id = null;
        });
        self::deleting(function($model){
            $model->user_deleted_id = optional(Auth::user())->id ?? null;
            $model->save();
        });
    }

}
