<?php

namespace App\Filament\Resources\AlHasalas\Pages;

use App\Filament\Resources\AlHasalas\AlHasalaResource;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Response;

class ViewAlHasala extends ViewRecord
{
    protected static string $resource = AlHasalaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            Action::make('downloadPdf')
                ->label('Download PDF')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->action(function () {
                    $alHasala = $this->record;
                    $user = $alHasala->user;
                    $memberProfile = $user->memberProfile;

                    $pdf = Pdf::loadView('pdf.al-hasala', [
                        'alHasala' => $alHasala,
                        'user' => $user,
                        'memberProfile' => $memberProfile,
                    ]);

                    $filename = 'al-hasala-' . $alHasala->id . '-' . now()->format('Y-m-d') . '.pdf';

                    return Response::streamDownload(function () use ($pdf) {
                        echo $pdf->output();
                    }, $filename, [
                        'Content-Type' => 'application/pdf',
                    ]);
                }),
        ];
    }
}
