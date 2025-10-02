<?php

namespace App\Filament\Widgets;

use App\Models\AlHasala;
use App\Models\Complaint;
use App\Models\Contact;
use App\Models\EventRegistration;
use App\Models\MemberProfile;
use App\Models\UnionLoan;
use Filament\Widgets\ChartWidget;

class FormApplicationsOverview extends ChartWidget
{
    protected ?string $heading = 'Form Applications Overview';

    protected function getData(): array
    {
        // Get the last 12 months
        $months = collect(range(11, 0))->map(function ($monthsAgo) {
            return now()->subMonths($monthsAgo);
        });

        $monthLabels = $months->map(function ($date) {
            return $date->format('M Y');
        })->toArray();

        // Get data for each form type by month
        $complaintsData = $this->getMonthlyData(Complaint::class, $months);
        $contactsData = $this->getMonthlyData(Contact::class, $months);
        $memberProfilesData = $this->getMonthlyData(MemberProfile::class, $months);
        $alHasalaData = $this->getMonthlyData(AlHasala::class, $months);
        $unionLoansData = $this->getMonthlyData(UnionLoan::class, $months);
        $eventRegistrationsData = $this->getMonthlyData(EventRegistration::class, $months);

        return [
            'datasets' => [
                [
                    'label' => 'Complaints',
                    'data' => $complaintsData,
                    'borderColor' => 'rgb(239, 68, 68)',
                    'backgroundColor' => 'rgba(239, 68, 68, 0.1)',
                ],
                [
                    'label' => 'Contact Messages',
                    'data' => $contactsData,
                    'borderColor' => 'rgb(59, 130, 246)',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                ],
                [
                    'label' => 'Member Profiles',
                    'data' => $memberProfilesData,
                    'borderColor' => 'rgb(34, 197, 94)',
                    'backgroundColor' => 'rgba(34, 197, 94, 0.1)',
                ],
                [
                    'label' => 'Al Hasala Applications',
                    'data' => $alHasalaData,
                    'borderColor' => 'rgb(168, 85, 247)',
                    'backgroundColor' => 'rgba(168, 85, 247, 0.1)',
                ],
                [
                    'label' => 'Union Loans',
                    'data' => $unionLoansData,
                    'borderColor' => 'rgb(245, 158, 11)',
                    'backgroundColor' => 'rgba(245, 158, 11, 0.1)',
                ],
                [
                    'label' => 'Event Registrations',
                    'data' => $eventRegistrationsData,
                    'borderColor' => 'rgb(236, 72, 153)',
                    'backgroundColor' => 'rgba(236, 72, 153, 0.1)',
                ],
            ],
            'labels' => $monthLabels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
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
