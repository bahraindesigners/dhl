<?php

namespace App\Filament\Widgets;

use App\LoanStatus;
use App\Models\AlHasala;
use App\Models\UnionLoan;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;

class LoanApplicationsChart extends ChartWidget
{
    protected ?string $heading = 'Loan Applications - Approval Analytics';

    protected ?string $description = 'Monthly trends and approval rates for Al Hasala and Union Loan applications';

    protected static ?int $sort = 3;

    public ?string $filter = 'last_6_months';

    protected function getFilters(): ?array
    {
        return [
            'last_3_months' => 'Last 3 months',
            'last_6_months' => 'Last 6 months',
            'this_year' => 'This year',
            'status_breakdown' => 'Status Breakdown',
        ];
    }

    protected function getData(): array
    {
        $filter = $this->filter;

        if ($filter === 'status_breakdown') {
            return $this->getStatusBreakdownData();
        }

        return $this->getTrendData($filter);
    }

    private function getStatusBreakdownData(): array
    {
        // Get Al Hasala applications by status
        $alHasalaPending = AlHasala::where('status', LoanStatus::Pending)->count();
        $alHasalaApproved = AlHasala::where('status', LoanStatus::Approved)->count();
        $alHasalaRejected = AlHasala::where('status', LoanStatus::Rejected)->count();

        // Get Union Loan applications by status
        $unionLoanPending = UnionLoan::where('status', LoanStatus::Pending)->count();
        $unionLoanApproved = UnionLoan::where('status', LoanStatus::Approved)->count();
        $unionLoanRejected = UnionLoan::where('status', LoanStatus::Rejected)->count();

        // Calculate totals for percentages
        $alHasalaTotal = $alHasalaPending + $alHasalaApproved + $alHasalaRejected;
        $unionLoanTotal = $unionLoanPending + $unionLoanApproved + $unionLoanRejected;

        return [
            'datasets' => [
                [
                    'label' => 'Al Hasala Applications',
                    'data' => [$alHasalaApproved, $alHasalaPending, $alHasalaRejected],
                    'backgroundColor' => [
                        'rgba(34, 197, 94, 0.8)',   // Green for approved
                        'rgba(245, 158, 11, 0.8)',  // Amber for pending
                        'rgba(239, 68, 68, 0.8)',   // Red for rejected
                    ],
                    'borderColor' => [
                        'rgb(34, 197, 94)',
                        'rgb(245, 158, 11)',
                        'rgb(239, 68, 68)',
                    ],
                    'borderWidth' => 2,
                ],
                [
                    'label' => 'Union Loan Applications',
                    'data' => [$unionLoanApproved, $unionLoanPending, $unionLoanRejected],
                    'backgroundColor' => [
                        'rgba(6, 182, 212, 0.8)',   // Cyan for approved
                        'rgba(168, 85, 247, 0.8)',  // Purple for pending
                        'rgba(244, 63, 94, 0.8)',   // Pink for rejected
                    ],
                    'borderColor' => [
                        'rgb(6, 182, 212)',
                        'rgb(168, 85, 247)',
                        'rgb(244, 63, 94)',
                    ],
                    'borderWidth' => 2,
                ],
            ],
            'labels' => ['Approved', 'Pending', 'Rejected'],
        ];
    }

    private function getTrendData(string $filter): array
    {
        $months = match ($filter) {
            'last_3_months' => 3,
            'last_6_months' => 6,
            'this_year' => 12,
            default => 6,
        };

        $monthsCollection = collect(range($months - 1, 0))->map(function ($monthsAgo) {
            return now()->subMonths($monthsAgo);
        });

        $monthLabels = $monthsCollection->map(function ($date) {
            return $date->format('M Y');
        })->toArray();

        // Get monthly data for approved applications
        $alHasalaApprovedData = $this->getMonthlyStatusData(AlHasala::class, LoanStatus::Approved, $monthsCollection);
        $unionLoanApprovedData = $this->getMonthlyStatusData(UnionLoan::class, LoanStatus::Approved, $monthsCollection);

        // Get monthly data for pending applications
        $alHasalaPendingData = $this->getMonthlyStatusData(AlHasala::class, LoanStatus::Pending, $monthsCollection);
        $unionLoanPendingData = $this->getMonthlyStatusData(UnionLoan::class, LoanStatus::Pending, $monthsCollection);

        return [
            'datasets' => [
                [
                    'label' => 'Al Hasala - Approved',
                    'data' => $alHasalaApprovedData,
                    'borderColor' => 'rgb(34, 197, 94)',
                    'backgroundColor' => 'rgba(34, 197, 94, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
                [
                    'label' => 'Union Loans - Approved',
                    'data' => $unionLoanApprovedData,
                    'borderColor' => 'rgb(6, 182, 212)',
                    'backgroundColor' => 'rgba(6, 182, 212, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
                [
                    'label' => 'Al Hasala - Pending',
                    'data' => $alHasalaPendingData,
                    'borderColor' => 'rgb(245, 158, 11)',
                    'backgroundColor' => 'rgba(245, 158, 11, 0.1)',
                    'fill' => false,
                    'borderDash' => [5, 5],
                    'tension' => 0.4,
                ],
                [
                    'label' => 'Union Loans - Pending',
                    'data' => $unionLoanPendingData,
                    'borderColor' => 'rgb(168, 85, 247)',
                    'backgroundColor' => 'rgba(168, 85, 247, 0.1)',
                    'fill' => false,
                    'borderDash' => [5, 5],
                    'tension' => 0.4,
                ],
            ],
            'labels' => $monthLabels,
        ];
    }

    protected function getType(): string
    {
        return $this->filter === 'status_breakdown' ? 'doughnut' : 'line';
    }

    protected function getOptions(): array
    {
        if ($this->filter === 'status_breakdown') {
            return [
                'plugins' => [
                    'legend' => [
                        'display' => true,
                        'position' => 'bottom',
                    ],
                    'tooltip' => [
                        'callbacks' => [
                            'label' => RawJs::make('function(context) {
                                const label = context.dataset.label || "";
                                const value = context.parsed;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                                return label + ": " + value + " (" + percentage + "%)";
                            }'),
                        ],
                    ],
                ],
                'responsive' => true,
                'maintainAspectRatio' => false,
            ];
        }

        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'top',
                ],
                'tooltip' => [
                    'mode' => 'index',
                    'intersect' => false,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'grid' => [
                        'display' => true,
                        'color' => 'rgba(0, 0, 0, 0.1)',
                    ],
                ],
                'x' => [
                    'grid' => [
                        'display' => false,
                    ],
                ],
            ],
            'interaction' => [
                'mode' => 'nearest',
                'axis' => 'x',
                'intersect' => false,
            ],
            'elements' => [
                'point' => [
                    'radius' => 4,
                    'hoverRadius' => 6,
                ],
            ],
            'responsive' => true,
            'maintainAspectRatio' => false,
        ];
    }

    private function getMonthlyStatusData(string $model, LoanStatus $status, $months): array
    {
        $data = [];

        foreach ($months as $month) {
            $startOfMonth = $month->copy()->startOfMonth();
            $endOfMonth = $month->copy()->endOfMonth();

            $count = $model::where('status', $status)
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->count();
            $data[] = $count;
        }

        return $data;
    }
}
