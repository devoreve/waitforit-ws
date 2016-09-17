<?php

namespace App;

use Canis\Lumen\Jwt\Contracts\Subject;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    Subject
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Gets the ID for the subject
     *
     * @return mixed
     */
    public function getJWTSubject()
    {
        return $this->getKey();
    }

    /**
     * Get the claims
     *
     * @return array
     */
    public function getJWTClaims()
    {
        return [];
    }

    /**
     * Get the claim validation
     *
     * @return array
     */
    public function getJWTClaimValidation()
    {
        return [];
    }
}
