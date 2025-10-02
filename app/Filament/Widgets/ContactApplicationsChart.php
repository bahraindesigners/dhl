<?php

namespace App\Filament\Widgets;

use App\Models\Complaint;
use App\Models\Contact;
use App\Models\EventRegistration;
use Filament\Widgets\ChartWidget;

class ContactApplicationsChart extends ChartWidget
{
    protected ?string $heading = 'Contact & Communication Stats';

    protected function getData(): array
    {
        // Get the last 6 months for a cleaner view
        $months = collect(range(5, 0))->map(function ($monthsAgo) {
            return now()->subMonths($monthsAgo);
        });

        $monthLabels = $months->map(function ($date) {
            return $date->format('M Y');
        })->toArray();

        // Get monthly data for contact-related activities
        $contactsData = $this->getMonthlyData(Contact::class, $months);
        $complaintsData = $this->getMonthlyData(Complaint::class, $months);
        $eventRegistrationsData = $this->getMonthlyData(EventRegistration::class, $months);

        return [
            'datasets' => [
                [
                    'label' => 'Contact Messages',
                    'data' => $contactsData,
                    'borderColor' => 'rgb(59, 130, 246)',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.2)',
                    'fill' => true,
                ],
                [
                    'label' => 'Complaints',
                    'data' => $complaintsData,
                    'borderColor' => 'rgb(239, 68, 68)',
                    'backgroundColor' => 'rgba(239, 68, 68, 0.2)',
                    'fill' => true,
                ],
                [
                    'label' => 'Event Registrations',
                    'data' => $eventRegistrationsData,
                    'borderColor' => 'rgb(236, 72, 153)',
                    'backgroundColor' => 'rgba(236, 72, 153, 0.2)',
                    'fill' => true,
                ],
            ],
            'labels' => $monthLabels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'top',
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                ],
            ],
            'maintainAspectRatio' => false,
        ];
    }

    private function getMonthlyData(string $model, $months): array
    {
        $data = [];

        foreach ($months as $month) {
            $startOfMonth = $month->copy()->startOfMonth();
            $endOfMonth = $month->copy()->endOfMonth();

            $count = $model::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
            $data[] = $count;
        }

        return $data;
    }
}
