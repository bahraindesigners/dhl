<?php

namespace App\Filament\Widgets;

use App\Models\AlHasala;
use App\Models\Complaint;
use App\Models\Contact;
use App\Models\EventRegistration;
use App\Models\UnionLoan;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ApplicationsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        // Get total applications counts
        $totalComplaints = Complaint::count();
        $totalContacts = Contact::count();
        $totalAlHasala = AlHasala::count();
        $totalUnionLoans = UnionLoan::count();
        $totalEventRegistrations = EventRegistration::count();

        // Get this month's counts
        $complaintsThisMonth = Complaint::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $contactsThisMonth = Contact::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $alHasalaThisMonth = AlHasala::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $unionLoansThisMonth = UnionLoan::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        return [
            Stat::make('Total Complaints', $totalComplaints)
                ->description("$complaintsThisMonth new this month")
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('danger')
                ->chart($this->getMonthlyTrend(Complaint::class)),

            Stat::make('Contact Messages', $totalContacts)
                ->description("$contactsThisMonth new this month")
                ->descriptionIcon('heroicon-m-chat-bubble-left-right')
                ->color('info')
                ->chart($this->getMonthlyTrend(Contact::class)),

            Stat::make('Al Hasala Applications', $totalAlHasala)
                ->description("$alHasalaThisMonth new this month")
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('warning')
                ->chart($this->getMonthlyTrend(AlHasala::class)),

            Stat::make('Union Loans', $totalUnionLoans)
                ->description("$unionLoansThisMonth new this month")
                ->descriptionIcon('heroicon-m-credit-card')
                ->color('success')
                ->chart($this->getMonthlyTrend(UnionLoan::class)),

            Stat::make('Event Registrations', $totalEventRegistrations)
                ->description('Total registrations')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('purple')
                ->chart($this->getMonthlyTrend(EventRegistration::class)),
        ];
    }

    private function getMonthlyTrend(string $model): array
    {
        // Get trend for the last 7 days
        $trend = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $count = $model::whereDate('created_at', $date)->count();
            $trend[] = $count;
        }

        return $trend;
    }
}
