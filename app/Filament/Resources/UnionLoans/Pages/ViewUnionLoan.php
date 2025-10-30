<?php

namespace App\Filament\Resources\UnionLoans\Pages;

use App\Filament\Resources\UnionLoans\UnionLoanResource;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Response;

class ViewUnionLoan extends ViewRecord
{
    protected static string $resource = UnionLoanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            Action::make('downloadPdf')
                ->label('Download PDF')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->action(function () {
                    $unionLoan = $this->record;
                    $user = $unionLoan->user;
                    $memberProfile = $user->memberProfile;

                    $pdf = Pdf::loadView('pdf.union-loan', [
                        'unionLoan' => $unionLoan,
                        'user' => $user,
                        'memberProfile' => $memberProfile,
                    ]);

                    $filename = 'union-loan-' . $unionLoan->id . '-' . now()->format('Y-m-d') . '.pdf';

                    return Response::streamDownload(function () use ($pdf) {
                        echo $pdf->output();
                    }, $filename, [
                        'Content-Type' => 'application/pdf',
                    ]);
                }),
        ];
    }
}
