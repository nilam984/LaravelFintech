<?php

namespace App\Services;

use App\Models\Menu;
use Illuminate\Support\Collection;

class MenuService
{
    /**
     * Get menus available for a specific role.
     *
     * default = visible to everyone
     * admin = admin users
     * user = normal users
     * reseller = reseller users
     * verification = verification users
     */
    public function getMenusForRole(string $role): Collection
    {
        $menus = Menu::query()
            ->active()
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->with([
                'children' => function ($query) use ($role) {
                    $query
                        ->active()
                        ->visibleForRole($role)
                        ->orderBy('sort_order');
                }
            ])
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Filter Parent Menus
        |--------------------------------------------------------------------------
        |
        | A parent should be displayed when:
        |
        | 1. The parent itself is visible for the role
        | OR
        |
        | 2. At least one of its children is visible for the role.
        |
        */

        return $menus->filter(function ($menu) use ($role) {

            $parentVisible = $this->isVisibleForRole(
                $menu->visible_for,
                $role
            );

            $hasVisibleChildren = $menu->children->isNotEmpty();

            return $parentVisible || $hasVisibleChildren;
        })->values();
    }


    /**
     * Get menus for currently authenticated user.
     */
    public function getMenusForCurrentUser(): Collection
    {
        $user = auth()->user();

        if (!$user) {
            return collect();
        }

        return $this->getMenusForRole($user->role);
    }


    /**
     * Check whether a menu is visible for a role.
     */
    protected function isVisibleForRole(?string $visibleFor,  string $role): bool
    {

        if (!$visibleFor) {
            return false;
        }

        // "default" means everyone can see it.
        if ($visibleFor === 'default') {
            return true;
        }

        return in_array(
            $role,
            explode(',', $visibleFor)
        );
    }
}
