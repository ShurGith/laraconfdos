<?php

    namespace App\Providers\Filament;

    use Agencetwogether\HooksHelper\HooksHelperPlugin;
    use Filament\Http\Middleware\Authenticate;
    use Filament\Http\Middleware\AuthenticateSession;
    use Filament\Http\Middleware\DisableBladeIconComponents;
    use Filament\Http\Middleware\DispatchServingFilamentEvent;
    use Filament\Navigation\MenuItem;
    use Filament\Pages;
    use Filament\Panel;
    use Filament\PanelProvider;
    use Filament\Support\Colors\Color;
    use Filament\Support\Facades\FilamentView;
    use Filament\Widgets;
    use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
    use Illuminate\Cookie\Middleware\EncryptCookies;
    use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
    use Illuminate\Routing\Middleware\SubstituteBindings;
    use Illuminate\Session\Middleware\StartSession;
    use Illuminate\Support\Facades\Blade;
    use Illuminate\View\Middleware\ShareErrorsFromSession;
    use Saasykit\FilamentOops\FilamentOopsPlugin;

    class AdminPanelProvider extends PanelProvider
    {
        public function panel(Panel $panel): Panel
        {
            return $panel
                ->default()
                ->id('admin')
                ->path('/')
                ->sidebarWidth('19rem')
                ->sidebarCollapsibleOnDesktop()
                //  ->sidebarFullyCollapsibleOnDesktop()
                ->login()
                ->colors([
                    'primary' => Color::Amber,
                    'gray' => Color::Slate,
                    'warning' => Color::Orange,
                ])
                ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
                ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
                ->pages([
                    Pages\Dashboard::class,
                ])
                ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
                ->widgets([
                    Widgets\AccountWidget::class,
                    Widgets\FilamentInfoWidget::class,
                ])
                ->plugins([
                    FilamentOopsPlugin::make()->addEnvironment('local', 'Local', '#008000'),
                    HooksHelperPlugin::make(),
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
                ->userMenuItems([
                    MenuItem::make()
                        ->label('Settings')
                        ->url(fn(): string => '/user/users/' . auth()->user()->id . '/edit')
                        ->icon('heroicon-o-cog-6-tooth'),
                    // ...
                ])
                ->spa()
                ->authMiddleware([
                    Authenticate::class,
                ]);
        }

        public function register(): void
        {
            parent::register();
            FilamentView::registerRenderHook('panels::body.end', fn(): string => Blade::render("@vite('resources/js/app.js')"));
        }
    }
