<?php 

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Rental;

class CalculateRentalCost extends Command
{
    protected $signature = 'rental:calculate';
    protected $description = 'Calculate optimized rental cost based on seat capacity.';

    public function handle()
    {
        $seatCapacity = $this->ask('Please input number (seat):');

        if (!is_numeric($seatCapacity) || $seatCapacity <= 0) {
            $this->error('Invalid input. Please enter a positive number.');
            return;
        }

        $rentals = Rental::all()->sortBy('seat'); 

        $optimalCombination = $this->findOptimalCombination($rentals, $seatCapacity);

        if ($optimalCombination) {
            $this->info("Optimal Rental Combination:");
            foreach ($optimalCombination as $rentalId => $count) {
                $rental = Rental::find($rentalId); 
                $this->line("{$rental->size} x {$count} (PHP {$rental->cost} each)");
            }
            $this->line("Total: PHP " . $this->calculateTotalCost($optimalCombination));
        } else {
            $this->error("No suitable rental combination found for {$seatCapacity} seats.");
        }
    }

    private function findOptimalCombination($rentals, $remainingSeats)
    {
        foreach ($rentals as $rental) {
            if ($rental->capacity >= $remainingSeats) { 
                return [$rental->id => 1]; 
            }
        }
    
        return null; 
    }
    
    

    private function calculateTotalCost($combination)
    {
        $totalCost = 0;
        foreach ($combination as $rentalId => $count) {
            $rental = Rental::find($rentalId);
            $totalCost += $rental->cost * $count;
        }
        return $totalCost;
    }
}
