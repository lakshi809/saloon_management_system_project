<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class User extends Authenticatable
{
    use Notifiable;
    protected $table = 'master_user';
    protected $primaryKey = 'idmaster_user';
    public $timestamps = false;
    protected $fillable = [
    'user_name',
    'password',
    'role',
    'status',
    'first_name',
    'last_name',
    'dob',
    'contact_number',
    'gender'
];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function getRememberTokenName()
{
    return null;
}
public function UserRole()
{
    return $this->belongsTo(\App\UserRole::class, 'user_role_iduser_role', 'iduser_role');
}

}