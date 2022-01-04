<?php
namespace CeddyG\ClaraPim;

use Illuminate\Support\ServiceProvider;

use Event;
use CeddyG\ClaraPim\Listeners\AttributeCategoryTextSubscriber;
use CeddyG\ClaraPim\Listeners\AttributeTextSubscriber;
use CeddyG\ClaraPim\Listeners\ChannelPriceSubscriber;
use CeddyG\ClaraPim\Listeners\ChannelTextSubscriber;
use CeddyG\ClaraPim\Listeners\ImageVariantSubscriber;
use CeddyG\ClaraPim\Listeners\ImageVariantTextSubscriber;
use CeddyG\ClaraPim\Listeners\PriceCategoryTextSubscriber;
use CeddyG\ClaraPim\Listeners\ProductCategoryTextSubscriber;
use CeddyG\ClaraPim\Listeners\ProductTextSubscriber;
use CeddyG\ClaraPim\Listeners\VariantSupplierSubscriber;
use CeddyG\ClaraPim\Listeners\VariantTextSubscriber;

/**
 * Description of EntityServiceProvider
 *
 * @author CeddyG
 */
class PimServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishesConfig();
		$this->publishesTranslations();
        $this->loadRoutesFrom(__DIR__.'/routes.php');
		$this->publishesView();
        
        Event::subscribe(AttributeCategoryTextSubscriber::class);
        Event::subscribe(AttributeTextSubscriber::class);
        Event::subscribe(ChannelPriceSubscriber::class);
        Event::subscribe(ChannelTextSubscriber::class);
        Event::subscribe(ImageVariantSubscriber::class);
        Event::subscribe(ImageVariantTextSubscriber::class);
        Event::subscribe(PriceCategoryTextSubscriber::class);
        Event::subscribe(ProductCategoryTextSubscriber::class);
        Event::subscribe(ProductTextSubscriber::class);
        Event::subscribe(VariantSupplierSubscriber::class);
        Event::subscribe(VariantTextSubscriber::class);
    }
    
    /**
	 * Publish config file.
	 * 
	 * @return void
	 */
	private function publishesConfig()
	{
		$sConfigPath = __DIR__ . '/../config';
        if (function_exists('config_path')) 
		{
            $sPublishPath = config_path();
        } 
		else 
		{
            $sPublishPath = base_path();
        }
		
        $this->publishes([$sConfigPath => $sPublishPath], 'clara.pim.config');  
	}
	
	private function publishesTranslations()
	{
		$sTransPath = __DIR__.'/../resources/lang';

        $this->publishes([
			$sTransPath => resource_path('lang/vendor/clara-pim'),
			'clara.pim.trans'
		]);
        
		$this->loadTranslationsFrom($sTransPath, 'clara-pim');
    }

	private function publishesView()
	{
        $sResources = __DIR__.'/../resources/views';

        $this->publishes([
            $sResources => resource_path('views/vendor/clara-pim'),
        ], 'clara.pim.views');
        
        $this->loadViewsFrom($sResources, 'clara-pim');
	}

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/clara.attribute-category.php', 'clara.attribute-category'
        );
        
        $this->mergeConfigFrom(
            __DIR__ . '/../config/clara.attribute.php', 'clara.attribute'
        );
        
        $this->mergeConfigFrom(
            __DIR__ . '/../config/clara.channel.php', 'clara.channel'
        );
        
        $this->mergeConfigFrom(
            __DIR__ . '/../config/clara.image-variant.php', 'clara.image-variant'
        );
        
        $this->mergeConfigFrom(
            __DIR__ . '/../config/clara.navbar.php', 'clara.navbar'
        );
        
        $this->mergeConfigFrom(
            __DIR__ . '/../config/clara.price-category.php', 'clara.price-category'
        );
        
        $this->mergeConfigFrom(
            __DIR__ . '/../config/clara.product-category.php', 'clara.product-category'
        );
        
        $this->mergeConfigFrom(
            __DIR__ . '/../config/clara.product.php', 'clara.product'
        );
        
        $this->mergeConfigFrom(
            __DIR__ . '/../config/clara.supplier.php', 'clara.supplier'
        );
        
        $this->mergeConfigFrom(
            __DIR__ . '/../config/clara.variant.php', 'clara.variant'
        );
    }
}
