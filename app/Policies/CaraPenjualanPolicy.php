<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CaraPenjualan;
use Illuminate\Auth\Access\HandlesAuthorization;

class CaraPenjualanPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_cara::penjualan');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CaraPenjualan $caraPenjualan): bool
    {
        return $user->can('view_cara::penjualan');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_cara::penjualan');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CaraPenjualan $caraPenjualan): bool
    {
        return $user->can('update_cara::penjualan');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CaraPenjualan $caraPenjualan): bool
    {
        return $user->can('delete_cara::penjualan');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_cara::penjualan');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, CaraPenjualan $caraPenjualan): bool
    {
        return $user->can('force_delete_cara::penjualan');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_cara::penjualan');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, CaraPenjualan $caraPenjualan): bool
    {
        return $user->can('restore_cara::penjualan');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_cara::penjualan');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, CaraPenjualan $caraPenjualan): bool
    {
        return $user->can('replicate_cara::penjualan');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_cara::penjualan');
    }
}
