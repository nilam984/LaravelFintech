<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    protected $fillable = ['parent_id', 'name', 'slug', 'route', 'icon', 'visible_for', 'sort_order', 'is_active'];

    // Parent Menu 
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }


    // Child/Submenu  
    public function children(): HasMany
    {
        return $this->hasMany(Menu::class, 'parent_id')
            ->orderBy('sort_order');
    }


    public function scopeVisibleForRole(Builder $query,  string $role): Builder
    {
        return $query->where(function (Builder $query) use ($role) {
            $query->where('visible_for', 'default')->orWhereRaw('FIND_IN_SET(?, visible_for)', [$role]);
        });
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
