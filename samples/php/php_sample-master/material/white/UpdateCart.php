<?php
namespace App\Commands\Cart;

use App\Cart;
use App\Commands\Command;

use Illuminate\Contracts\Bus\SelfHandling;

class UpdateCart extends Command implements SelfHandling
{

    protected $cart_id;

    /**
     * Create a new command instance.
     *
     * @param $cart_id
     * @param $item_id
     * @param $qty
     * @throws \Exception
     */
    public function __construct($cart_id, $item_id, $qty)
    {
        if(!$cart_id || !$item_id) throw new \Exception("Invalid UpdateCart request.");

        $this->cart_id = $cart_id;

        $this->item_id = $item_id;

        $this->qty = (integer)$qty;
    }

    /**
     * Execute the command.
     */
    public function handle()
    {
        if($cart = entity('cart')->find($this->cart_id)){

            if($cart_item = $cart->findItem($this->item_id)){

                if($this->qty){

                    $cart_item->update([
                        'qty' => $this->qty
                    ]);

                } else{

                    $cart_item->delete();

                }
            }

        }
    }

}
