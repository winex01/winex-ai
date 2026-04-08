<?php

namespace App\Filament\Resources\Users;

use BackedEnum;
use App\Models\User;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Schemas\UserForm;
use App\Filament\Resources\Users\Tables\UsersTable;
use EslamRedaDiv\FilamentCopilot\Contracts\CopilotResource;
use App\Filament\Resources\Users\UserResource\CopilotTools\ListUsersTool;
use App\Filament\Resources\Users\UserResource\CopilotTools\SearchUsersTool;

class UserResource extends Resource implements CopilotResource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    // Required: Describe what this resource manages
    public static function copilotResourceDescription(): ?string
    {
        return 'Manages user accounts including names, emails, roles, and account status.';
    }

    // Required: Define tools the AI can use (can be empty for now)
    public static function copilotTools(): array
    {
        return [
            ListUsersTool::class,
            SearchUsersTool::class,
        ];
    }

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
