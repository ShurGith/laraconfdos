<?php

    namespace App\Providers\Filament;

    use Filament\Http\Middleware\Authenticate;
    use Filament\Http\Middleware\AuthenticateSession;
    use Filament\Http\Middleware\DisableBladeIconComponents;
    use Filament\Http\Middleware\DispatchServingFilamentEvent;
    use Filament\Navigation\MenuItem;
    use Filament\Pages;
    use Filament\Panel;
    use Filament\PanelProvider;
    use Filament\Support\Colors\Color;
    use Filament\Widgets;
    use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
    use Illuminate\Cookie\Middleware\EncryptCookies;
    use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
    use Illuminate\Routing\Middleware\SubstituteBindings;
    use Illuminate\Session\Middleware\StartSession;
    use Illuminate\View\Middleware\ShareErrorsFromSession;


    class UserPanelProvider extends PanelProvider
    {
        public function panel(Panel $panel): Panel
        {
            return $panel
                ->id('user')
                ->path('user')
                ->colors([
                    'primary' => Color::Amber,
                    'gray' => '#7b5f3f',
                ])
                ->discoverResources(in: app_path('Filament/User/Resources'), for: 'App\\Filament\\User\\Resources')
                ->discoverPages(in: app_path('Filament/User/Pages'), for: 'App\\Filament\\User\\Pages')
                ->pages([
                    Pages\Dashboard::class,
                ])
                ->discoverWidgets(in: app_path('Filament/User/Widgets'), for: 'App\\Filament\\User\\Widgets')
                ->widgets([
                    Widgets\AccountWidget::class,
                    Widgets\FilamentInfoWidget::class,
                ])->userMenuItems([
                    MenuItem::make()
                        ->label('Settings')
                        ->url(fn(): string => '/user/users/' . auth()->user()->id . '/edit')
                        ->icon('heroicon-o-cog-6-tooth'),
                    // ...
                ])
                ->middleware([
                    EncryptCookies::class,
                    AddQueuedCookiesToResponse::class,
                    StartSession::class,
                    AuthenticateSession::class,
                    ShareErrorsFromSession::class,
                    VerifyCsrfToken::class,
                    SubstituteBindings::class,
                    DisableBladeIconComponents::class,
                    DispatchServingFilamentEvent::class,
                ])
                ->authMiddleware([
                    Authenticate::class,
                ]);
        }
    }