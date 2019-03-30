<?php
namespace App\Commands\Cart;

use App\Commands\Command;

use Illuminate\Contracts\Bus\SelfHandling;

class ShipmentMethod extends Command implements SelfHandling
{

    /**
     * Create a new instance.
     */
    public function __construct($shipment, $method)
    {
        $this->method     = $method;

        $this->shipment   = $shipment;
    }

    /**
     * Execute the command.
     */
    public function handle()
    {
        if($this->shipment && $this->shipment->id){

            $this->shipment->update([
                'method' => $this->method
            ]);

        }
    }

}
