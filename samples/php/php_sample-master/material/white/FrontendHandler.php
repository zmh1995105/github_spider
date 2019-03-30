<?php
namespace App\Handlers\Layout;

use App\Cart;
use App\Store;
use Illuminate\Support\Facades\Auth;

class FrontendHandler
{

    protected $cart;

    protected $store;

    public function __construct(Cart $cart, Store $store)
    {
        $this->cart = $cart;

        $this->store = $store;
    }

    /**
     * Base layout applied to all views
     *
     * @param $event
     */
    public function handle($event)
    {
        $this->header();

        $this->footer();

        $this->navigation();

        $this->layouts();
    }

    protected function layouts()
    {
        view()->composer('page.partials.header.logo', function($view){

            $view->with('url', url('/'));

        });
    }

    protected function footer()
    {
        $bottom_links = menu('footer.links');

        $bottom_links->add('contact', [
            'href' => url(config('url.contact')),
            'text' => 'Contact us',
        ]);

        $bottom_links->add('backend', [
            'href' => url('backend'),
            'text' => 'Go to backend',
        ]);

        $bottom_links->add('copyright', [
            'text' => '&copy; ' . date('Y') . ' ' . config('store.name'),
        ]);
    }

    protected function header()
    {
        $top_links = menu('header.links');

        $top_links->add('cart', [
            'href' => url('cart'),
            'text' => 'Cart #'.$this->cart->id.' - '.$this->cart->getSummary().' item(s)',
        ]);

        if(Auth::customer()->check()){

            $top_links->add('account', [
                'href' => url('customer/dashboard'),
                'text' => 'My Account',
            ]);

            $top_links->add('logout', [
                'href' => url('customer/logout'),
                'text' => 'Logout',
            ]);

        } else {

            $top_links->add('login', [
                'href' => url('customer/login'),
                'text' => 'Login/Register',
            ]);

        }
    }

    protected function navigation()
    {
        if($root = $this->store->getRootCategory()){

            foreach($root->children as $category){

                menu('top.navigation')->add('cat-' . $category->id, [
                    'href'     => $category->url(),
                    'text'     => $category->name(),
                    'children' => $this->children($category)
                ]);

            }

        }
    }

    private function children($item)
    {
        $children = [];

        foreach($item->children as $child){

            $children[] = [
                'href' => $child->url(),
                'text' => $child->name(),
                'children' => $this->children($child)
            ];

        }

        return $children;
    }
}