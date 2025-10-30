<?php

namespace App\Filament\Resources\MemberProfiles\Pages;

use App\Filament\Resources\MemberProfiles\MemberProfileResource;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Response;

class ViewMemberProfile extends ViewRecord
{
    protected static string $resource = MemberProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            Action::make('downloadPdf')
                ->label('Download PDF')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->action(function () {
                    $memberProfile = $this->record;
                    $user = $memberProfile->user;

                    $pdf = Pdf::loadView('pdf.member-profile', [
                        'memberProfile' => $memberProfile,
                        'user' => $user,
                    ]);

                    $filename = 'member-profile-' . $memberProfile->staff_number . '-' . now()->format('Y-m-d') . '.pdf';

                    return Response::streamDownload(function () use ($pdf) {
                        echo $pdf->output();
                    }, $filename, [
                        'Content-Type' => 'application/pdf',
                    ]);
                }),
        ];
    }
}
