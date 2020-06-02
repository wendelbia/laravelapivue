<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
//pegos os users para a JWT
use Tymon\JWTAuth\Contracts\JWTSubject;



/*vou em quick star e pego implements JWTSubject*/
class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    
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
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        //essa função é dos identificadores que é passado pelo getkey()
        //podemos substituir também pelo id 
        //e para testar vamos no postman novamente
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
}
