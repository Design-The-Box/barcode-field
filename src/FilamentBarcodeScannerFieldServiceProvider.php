<?php

namespace DesignTheBox\BarcodeField;

use DesignTheBox\BarcodeField\Forms\Components\BarcodeInput;
use Filament\Forms\Components\Field;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentBarcodeScannerFieldServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-barcode-field';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasViews(); // Tell Laravel that this package has views
    }

    public function boot(): void
    {
        // You can safely call package methods here as it's already initialized
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'barcode-field'); // Register the views path

        // Publish the barcode scanner view
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/barcode-field'),
        ],'barcode-scanner-views');
        
        // Publish the barcode scanner script
        $this->publishes([
            __DIR__.'/../resources/js/barcode-scanner.js' => public_path('vendor/barcode-field/barcode-scanner.js'),
        ], 'barcode-scanner-assets');
    }

    public function register(): void
    {
        // Register the BarcodeInput component as a macro on the Field class
        Field::macro('barcodeInput', function ($name) {
            return BarcodeInput::make($name); // Use the 'make' method
        });
    }
}
