<?php

namespace App\Filament\Resources;

use App\Models\SeoData;
use Filament\Resources\Resource;

class SeoDataResource extends Resource
{
    protected static ?string $model = SeoData::class;

    protected static ?string $navigationLabel = 'SEO Management';
    protected static ?string $pluralLabel = 'SEO Pages';
    protected static ?int $navigationSort = 1;

    public static function canAccess(): bool
    {
        $user = auth()->user();
        if (!$user) {
            return false;
        }
        return $user->hasAnyRole(['admin', 'superadmin', 'editor']);
    }

    public static function canCreate(): bool
    {
        $user = auth()->user();
        if (!$user) {
            return false;
        }
        return $user->hasAnyRole(['admin', 'superadmin']);
    }

    public static function canDelete($record): bool
    {
        $user = auth()->user();
        if (!$user) {
            return false;
        }
        return $user->hasAnyRole(['admin', 'superadmin']);
    }

    public static function canDeleteAny(): bool
    {
        $user = auth()->user();
        if (!$user) {
            return false;
        }
        return $user->hasAnyRole(['admin', 'superadmin']);
    }
}
