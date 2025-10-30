<?php

namespace App\Filament\Resources\Complaints\Pages;

use App\Filament\Resources\Complaints\ComplaintResource;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Response;

class ViewComplaint extends ViewRecord
{
    protected static string $resource = ComplaintResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            Action::make('downloadPdf')
                ->label('Download PDF')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->action(function () {
                    $complaint = $this->record;
                    $user = $complaint->user;
                    $memberProfile = $complaint->memberProfile;

                    $pdf = Pdf::loadView('pdf.complaint', [
                        'complaint' => $complaint,
                        'user' => $user,
                        'memberProfile' => $memberProfile,
                    ]);

                    $filename = 'complaint-' . $complaint->ticket_id . '-' . now()->format('Y-m-d') . '.pdf';

                    return Response::streamDownload(function () use ($pdf) {
                        echo $pdf->output();
                    }, $filename, [
                        'Content-Type' => 'application/pdf',
                    ]);
                }),
        ];
    }
}
