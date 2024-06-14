<?php 

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Rental;

class EditRentalPrices extends Command
{
    protected $signature = 'rental:edit';
    protected $description = 'Edit the seat capacity and cost of rental sizes]';

    public function handle()
    {

        $size = $this->ask('Select the rental size to edit:(Small,Medium,Large)');
        $newSeat = $this->ask('Enter the new seat capacity:');
        $newCost = $this->ask('Enter the new cost (PHP):');

     
        if (!is_numeric($newSeat) || $newSeat <= 0 || !is_numeric($newCost) || $newCost <= 0) {
            $this->error('Invalid input. Please enter positive numbers.');
            return;
        }

        $rental = Rental::where('size', 'ilike', $size)->firstOrFail();

        $rental->capacity = $newSeat;
        $rental->cost = $newCost;
        $rental->save();

        $this->info("Rental size '{$size}' updated successfully!");
    }
}
