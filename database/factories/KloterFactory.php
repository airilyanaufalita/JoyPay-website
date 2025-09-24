<?php
// database/factories/KloterFactory.php

namespace Database\Factories;

use App\Models\Kloter;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class KloterFactory extends Factory
{
    protected $model = Kloter::class;

    public function definition()
    {
        $categories = ['harian', 'mingguan', 'bulanan'];
        $category = $this->faker->randomElement($categories);
        
        // Set duration based on category
        switch ($category) {
            case 'harian':
                $durationValue = $this->faker->numberBetween(5, 14);
                $durationUnit = 'hari';
                $nominal = $this->faker->randomElement([25000, 50000, 75000, 100000]);
                break;
            case 'mingguan':
                $durationValue = $this->faker->numberBetween(6, 12);
                $durationUnit = 'minggu';
                $nominal = $this->faker->randomElement([100000, 200000, 250000, 300000]);
                break;
            case 'bulanan':
                $durationValue = $this->faker->numberBetween(10, 24);
                $durationUnit = 'bulan';
                $nominal = $this->faker->randomElement([500000, 1000000, 1500000, 2000000]);
                break;
        }

        $totalSlots = $durationValue;
        $filledSlots = $this->faker->numberBetween(0, $totalSlots);
        
        $adminFeePercentage = $this->faker->randomFloat(2, 0.5, 3.0);
        $adminFeeAmount = $nominal * ($adminFeePercentage / 100);
        
        // Determine status based on filled slots
        if ($filledSlots == 0) {
            $status = 'open';
        } elseif ($filledSlots < $totalSlots) {
            $status = $this->faker->randomElement(['open', 'open', 'open']); // Bias toward open
        } elseif ($filledSlots == $totalSlots) {
            $status = $this->faker->randomElement(['full', 'running']);
        } else {
            $status = 'running';
        }

        $currentPeriod = $status === 'running' ? $this->faker->numberBetween(1, $totalSlots) : 0;

        return [
            'name' => $this->faker->randomElement([
                'Arisan Berkah',
                'Arisan Mandiri',
                'Arisan Sejahtera',
                'Arisan Harmoni',
                'Arisan Barokah',
                'Arisan Keluarga',
                'Arisan Santai',
                'Arisan Premium',
                'Arisan Elite',
                'Arisan Gold'
            ]) . ' ' . ucfirst($category),
            'description' => $this->faker->sentence(10),
            'category' => $category,
            'nominal' => $nominal,
            'duration_value' => $durationValue,
            'duration_unit' => $durationUnit,
            'total_slots' => $totalSlots,
            'filled_slots' => $filledSlots,
            'admin_fee_percentage' => $adminFeePercentage,
            'admin_fee_amount' => $adminFeeAmount,
            'status' => $status,
            'payment_schedule' => $this->getPaymentSchedule($category),
            'draw_schedule' => $this->getDrawSchedule($category),
            'start_date' => $this->faker->dateTimeBetween('now', '+30 days'),
            'current_period' => $currentPeriod,
            'manager_name' => $this->faker->name,
            'payment_method' => 'Transfer Bank',
        ];
    }

    private function getPaymentSchedule($category)
    {
        switch ($category) {
            case 'harian':
                return 'Setiap hari jam ' . $this->faker->randomElement(['09:00', '10:00', '11:00']);
            case 'mingguan':
                return 'Setiap hari ' . $this->faker->randomElement(['Senin', 'Selasa', 'Rabu']);
            case 'bulanan':
                return 'Setiap tanggal ' . $this->faker->numberBetween(1, 10);
            default:
                return 'Belum ditentukan';
        }
    }

    private function getDrawSchedule($category)
    {
        switch ($category) {
            case 'harian':
                return 'Setiap hari jam ' . $this->faker->randomElement(['19:00', '20:00', '21:00']);
            case 'mingguan':
                return 'Setiap hari ' . $this->faker->randomElement(['Jumat', 'Sabtu', 'Minggu']);
            case 'bulanan':
                return 'Setiap tanggal ' . $this->faker->numberBetween(10, 20);
            default:
                return 'Belum ditentukan';
        }
    }
}