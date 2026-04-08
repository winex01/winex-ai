<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use Filament\Pages\Dashboard;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Filament\Http\Middleware\AuthenticateSession;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use EslamRedaDiv\FilamentCopilot\FilamentCopilotPlugin;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;

class AppPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('app')
            ->path('/')
            ->viteTheme('resources/css/filament/app/theme.css')
            ->login()
            ->registration()
            ->plugin(
                FilamentCopilotPlugin::make()
                    // ->provider('ollama')
                    // ->model('phi3:latest')
                    ->systemPrompt('You are a helpful admin assistant.')
                    ->globalTools([
                        // SearchEverythingTool::class,
                    ])
                    ->quickActions([
                        'Show stats'   => 'Show me a summary of today\'s statistics.',
                        'Recent users' => 'List the 10 most recently created users.',
                    ])
                    ->managementEnabled()
                    // ->managementGuard('admin')
                    ->rateLimitEnabled()
                    ->tokenBudgetEnabled()
                    ->dailyTokenBudget(50000)
                    ->monthlyTokenBudget(1000000)
                    ->memoryEnabled()
                    ->maxMemoriesPerUser(200)
                    ->respectAuthorization()
                    ->authorizeUsing(fn ($user) => true)
            )
            ->colors([
                'primary' => Color::Sky,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
