<?php

namespace Moox\Permission\Policies;

use Illuminate\Support\Facades\Auth;

class DefaultPolicy
{
    protected $user;

    public function __construct($guard = null)
    {
        $guard = $guard ?? Auth::getDefaultDriver();

        $this->user = Auth::guard($guard)->user();

        if (! method_exists($this->user, 'hasPermissionTo')) {
            throw new \Exception("The user object does not have the method 'hasPermissionTo'.");
        }
    }

    protected function hasPermission($permission)
    {
        /** @disregard Undefined method 'hasPermissionTo'.intelephense(P1013) */
        return $this->user->hasPermissionTo($permission);
    }

    public function view()
    {
        return $this->hasPermission('view');
    }

    public function edit()
    {
        return $this->hasPermission('edit');
    }

    public function create()
    {
        return $this->hasPermission('create');
    }

    public function delete()
    {
        return $this->hasPermission('delete');
    }

    public function restore()
    {
        return $this->hasPermission('restore');
    }

    public function publish()
    {
        return $this->hasPermission('publish');
    }

    public function viewOwn($model)
    {
        return $this->hasPermission('view own') && $model->user_id === $this->user->id;
    }

    public function editOwn($model)
    {
        return $this->hasPermission('edit own') && $model->user_id === $this->user->id;
    }

    public function deleteOwn($model)
    {
        return $this->hasPermission('delete own') && $model->user_id === $this->user->id;
    }

    public function publishOwn($model)
    {
        return $this->hasPermission('publish own') && $model->user_id === $this->user->id;
    }

    public function bulkModify()
    {
        return $this->hasPermission('bulk modify');
    }

    public function timeTravel()
    {
        return $this->hasPermission('time travel');
    }

    public function forceDelete()
    {
        return $this->hasPermission('force delete');
    }
}