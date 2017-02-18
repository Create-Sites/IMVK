<?php

namespace CreateSites\IMVK\Models;

use \Illuminate\Database\Eloquent\Model;
use App\User;

class IMVKMessages extends Model
{
    protected $table = 'im_vk_messages';
    public $fillable = ['text', 'for_user_id', 'from_user_id', 'pm_read', 'folder', 'attach'];

    public function dialog()
    {
        return $this->belongsTo(IMVK::class, 'i_m_v_k_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsTo(User::class, 'for_user_id');
    }

    /**
     * @param $for_user_id
     * @param $from_user_id
     * @return mixed
     */
    public function userMessages($for_user_id, $from_user_id)
    {
        return $this->fromUser($for_user_id, $from_user_id)
            ->get();
    }

    public function scopeFromUser($query, $for_user_id, $from_user_id)
    {
        $query->where(['for_user_id' => $for_user_id, 'from_user_id' => $from_user_id]);
    }
}