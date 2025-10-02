<?php

namespace App\Filament\Widgets;

use App\Models\MemberProfile;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MemberStatistics extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        // Get total members
        $totalMembers = MemberProfile::count();

        // Get new members this month
        $newMembersThisMonth = MemberProfile::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Get percentage change from last month
        $newMembersLastMonth = MemberProfile::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();

        $percentageChange = $newMembersLastMonth > 0
            ? (($newMembersThisMonth - $newMembersLastMonth) / $newMembersLastMonth) * 100
            : 0;

        // Get active members (members with at least one application)
        $activeMembers = MemberProfile::whereHas('user.alHasalas')
            ->orWhereHas('user.unionLoans')
            ->orWhereHas('user.complaints')
            ->distinct()
            ->count();

        // Get total registered users
        $totalUsers = User::count();

        // Get completion rate (users with member profiles)
        $completionRate = $totalUsers > 0 ? ($totalMembers / $totalUsers) * 100 : 0;

        return [
            Stat::make('Total Members', $totalMembers)
                ->description('Registered union members')
                ->descriptionIcon('heroicon-m-users')
                ->color('success')
                ->chart($this->getMemberTrend()),

            Stat::make('New Members This Month', $newMembersThisMonth)
                ->description($percentageChange > 0 ? "↗ {$percentageChange}% increase" : ($percentageChange < 0 ? '↘ '.abs($percentageChange).'% decrease' : 'No change'))
                ->descriptionIcon($percentageChange > 0 ? 'heroicon-m-arrow-trending-up' : ($percentageChange < 0 ? 'heroicon-m-arrow-trending-down' : 'heroicon-m-minus'))
                ->color($percentageChange > 0 ? 'success' : ($percentageChange < 0 ? 'danger' : 'warning')),

            Stat::make('Active Members', $activeMembers)
                ->description('Members with applications')
                ->descriptionIcon('heroicon-m-bolt')
                ->color('info'),

            Stat::make('Profile Completion', round($completionRate, 1).'%')
                ->description('Users with completed profiles')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('warning')
                ->chart($this->getCompletionTrend()),
        ];
    }

    private function getMemberTrend(): array
    {
        // Get member registrations for the last 7 days
        $trend = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $count = MemberProfile::whereDate('created_at', $date)->count();
            $trend[] = $count;
        }

        return $trend;
    }

    private function getCompletionTrend(): array
    {
        // Get completion rate for the last 7 days
        $trend = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $totalUsers = User::whereDate('created_at', '<=', $date)->count();
            $membersWithProfiles = MemberProfile::whereDate('created_at', '<=', $date)->count();
            $rate = $totalUsers > 0 ? ($membersWithProfiles / $totalUsers) * 100 : 0;
            $trend[] = round($rate, 1);
        }

        return $trend;
    }
}
