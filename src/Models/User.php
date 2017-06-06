<?php

namespace NAdminPanel\Blog\Models;

use NAdminPanel\AdminPanel\Models\User as AdminPanelUser;

class User extends AdminPanelUser
{
    public function posts()
    {
        return $this->belongsToMany('NAdminPanel\Blog\Models\Post');
    }
}
