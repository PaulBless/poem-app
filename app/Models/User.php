<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
    */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
    */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
    */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * 
    */
    public function checkUserExist($email){
        try {
            $result = $this->where('email',$email)->exists();
            if ($result){
                return true;
            }
            return false;

        }catch (QueryException $ex){
            return false;
        }
    }

    public function registerAuth($name,$email,$password){
        try{
            $this->name = $name;
            $this->email = $email;
            $this->password = $password;
            if ($this->save()){
                return true;
            }
            return false;
        }catch (QueryException $ex){
            return false;
        }
    }

    public function updateConformKey($email,$key){
        try {
            $result = $this->where('email',$email)->where('confirmed',0)
                           ->update(['confirmation_code'=>$key]);
            if ($result){
                return true;
            }
            return false;
        }catch (QueryException $ex){
            return false;
        }
    }
    public function loginAuth($email){
        try {
            $result = $this->where('email',$email)->where('status',1)->first();
            if (isset($result) && !empty($result)){
                return $result;
            }
            return null;
        }catch (QueryException $ex){
            return null;
        }
    }
    public function conformMail($key){
        try {
            $result = $this->where('confirmation_code',$key)->where('confirmed',0)
                ->update(['confirmed'=>1]);
            if ($result){
                return true;
            }
            return false;
        }catch (QueryException $ex){
            return false;
        }
    }
    public function getProfile($email)
    {
        try {
            $result = $this->where('email', $email)->first();
            if ($result) {
                return $result;
            }
            return null;
        } catch (QueryException $ex) {
            Log::info('UserModel Error', ['getProfile' => $ex->getMessage(), 'line' => $ex->getLine()]);
            return null;
        }
    }

    public function updateProfileInformation($email,$name,$headline,$about_me,$address,$phone_number)
    {
        try {

            $result = $this->where('email', $email)
                ->update([
                    'name' => $name,
                    'headline' => $headline,
                    'about_me' => $about_me,
                    'address' => $address,
                    'phone_number' => $phone_number,
                ]);

            if ($result) {
                return true;
            }
            return false;
        } catch (QueryException $ex) {
            Log::info('UserModel Error', ['updateProfileInformation' => $ex->getMessage(), 'line' => $ex->getLine()]);
            return false;
        }
    }

    public function getSingleUser($email)
    {
        try {
            $user_email = $this->where('email', $email)->first();
            if ($user_email) {
                return $user_email;
            }
            return null;
        } catch (QueryException $ex) {
            Log::info('UserModel Error', ['getSingleUser' => $ex->getMessage(), 'line' => $ex->getLine()]);
            return null;
        }
    }

    public function updatePassword($email, $hashPassword)
    {
        try {
            $result = $this->where('email', $email)
                ->update(['password' => $hashPassword]);
            if ($result) {
                return true;
            }
            return false;
        } catch (QueryException $ex) {
            Log::info('UserModel Error', ['resetPassword' => $ex->getMessage(), 'line' => $ex->getLine()]);
            return false;
        }
    }

    public function updateNotification($email, $setting_name, $setting_value)
    {
        try {
            $query = $this->newQuery();
            $query->where('email', $email);
            if ($setting_name == "mobile_notification") {
                $query->update(['mobile_notification' => $setting_value]);
            } elseif ($setting_name == "email_notification") {
                $query->update(['email_notification' => $setting_value]);
            } else {
                return false;
            }
            if ($query) {
                return true;
            }
            return false;
        } catch (QueryException $ex) {
            Log::info('UserModel Error', ['updateNotification' => $ex->getMessage(), 'line' => $ex->getLine()]);
            return false;
        }
    }

    public function updateProfilePic($email,$image_name)
    {
        try {
            $result = $this->where('email', $email)->update(["profile_pic"=>$image_name]);
            if ($result){
                return true;
            }
            return false;
        } catch (QueryException $ex) {
            Log::info('UserModel Error', ['updateProfilePic' => $ex->getMessage(), 'line' => $ex->getLine()]);
            return false;
        }
    }

    public function getNotification($email)
    {
        try {
            $result = $this->select("mobile_notification","email_notification")->where('email', $email)->first();
            if ($result) {
                return $result;
            }
            return null;
        } catch (QueryException $ex) {
            Log::info('UserModel Error', ['getProfile' => $ex->getMessage(), 'line' => $ex->getLine()]);
            return null;
        }
    }

    public function getProfileInfo($email)
    {
        try {
            $result = $this->select("name","profile_pic","email")->where('email', $email)->first();
            if ($result) {
                return $result;
            }
            return null;
        } catch (QueryException $ex) {
            Log::info('UserModel Error', ['getProfile' => $ex->getMessage(), 'line' => $ex->getLine()]);
            return null;
        }
    }
    public function getUserInfo($email){
        try {
            $result = $this->select('name','email','confirmed')->where('email',$email)->where('status',1)->first();
            if ($result){
                return $result;
            }
            return null;
        }catch (QueryException $ex){
            return null;
        }
    }
    public function getUserdetail($email_id){
        try {
            $user_name = $this->select('name')->where('email',$email_id)->get();
            if (count($user_name)){
                return $user_name[0]->name;
            }
            return null;
        }catch (QueryException $ex){
            Log::info('UserModel Error',['getUserdetail'=>$ex->getMessage(),'line'=>$ex->getLine()]);
            return null;
        }
    }

    public function resetPassword($email,$password){
        try {
            $result = $this->where('email',$email)
                ->update(['password'=>Hash::make($password)]);
            if ($result){
                return true;
            }
            return false;
        }catch (QueryException $ex){
            Log::info('UserModel Error',['resetPassword'=>$ex->getMessage(),'line'=>$ex->getLine()]);
            return false;
        }
    }

    /**
     * Get the poems for the user.
    */
    public function poems(): HasMany
    {
        return $this->hasMany(Poem::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

}
