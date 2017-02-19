<?php

namespace CreateSites\IMVK\Models;

use App\User;
use \Illuminate\Database\Eloquent\Model;

class IMVK extends Model
{
    protected $table = 'im_vk';
    public $fillable = ['all_msg_num', 'user_id', 'im_user_id', 'msg_num'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(IMVKMessages::class);
    }

    public function user()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * @param $for_user_id
     * @return mixed
     */
    public function allMessages($for_user_id)
    {
        return $this->forUser($for_user_id)
            ->orderBy('updated_at', 'desc')
            ->get();
    }

    /**
     * @param $query
     * @param $for_user_id
     */
    public function scopeForUser($query, $for_user_id)
    {
        $query->where(['user_id' => $for_user_id]);
    }

}