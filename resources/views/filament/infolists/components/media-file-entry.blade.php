@php
    $record = $getRecord();
    $collection = $getCollection();
    $mediaItems = $record->hasMedia($collection) ? $record->getMedia($collection) : collect();
@endphp

<x-dynamic-component
    :component="$getEntryWrapperView()"
    :entry="$entry"
>
    <div {{ $getExtraAttributeBag() }}>
        @if($mediaItems->isEmpty())
            <div style="color: #6b7280; font-size: 14px;">
                No files uploaded
            </div>
        @else
            <div style="display: flex; flex-direction: column; gap: 6px;">
                @foreach($mediaItems as $media)
                    @php
                        $downloadUrl = $media->getUrl();
                        $fileName = $media->name . '.' . $media->extension;
                        $mimeType = $media->mime_type;
                        $fileSize = $media->human_readable_size;
                    @endphp
                    
                    @if(str_starts_with($mimeType, 'image/'))
                        {{-- Image Preview --}}
                        <div style="display: flex; align-items: center; gap: 8px; padding: 4px 8px; background-color: #f9fafb; border-radius: 4px; border: 1px solid #e5e7eb; cursor: pointer; transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='#f3f4f6'" onmouseout="this.style.backgroundColor='#f9fafb'">
                            <img 
                                src="{{ $downloadUrl }}" 
                                alt="{{ $fileName }}"
                                style="width: 20px; height: 20px; object-fit: cover; border-radius: 2px; cursor: pointer;"
                                onclick="window.open('{{ $downloadUrl }}', '_blank')"
                            />
                            <div style="flex: 1; min-width: 0;">
                                <div style="display: flex; align-items: center; gap: 4px;">
                                    <svg style="width: 10px; height: 10px; color: #059669;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span style="font-size: 11px; font-weight: 500; color: #111827; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $fileName }}</span>
                                </div>
                                <div style="font-size: 10px; color: #6b7280;">{{ $fileSize }}</div>
                            </div>
                            <button 
                                onclick="window.open('{{ $downloadUrl }}', '_blank')"
                                style="color: #9ca3af; border: none; background: none; cursor: pointer; padding: 0;"
                                onmouseover="this.style.color='#4b5563'" onmouseout="this.style.color='#9ca3af'"
                            >
                                <svg style="width: 10px; height: 10px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                            </button>
                        </div>
                    @else
                        {{-- Document/File Card --}}
                        <div 
                            style="display: flex; align-items: center; gap: 8px; padding: 4px 8px; background-color: #f9fafb; border-radius: 4px; border: 1px solid #e5e7eb; cursor: pointer; transition: background-color 0.2s;"
                            onclick="window.open('{{ $downloadUrl }}', '_blank')"
                            onmouseover="this.style.backgroundColor='#f3f4f6'" onmouseout="this.style.backgroundColor='#f9fafb'"
                        >
                            @if($mimeType === 'application/pdf')
                                {{-- PDF Icon --}}
                                <svg style="width: 12px; height: 12px; color: #dc2626; flex-shrink: 0;" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z" />
                                </svg>
                            @elseif(str_contains($mimeType, 'word'))
                                {{-- Word Document Icon --}}
                                <svg style="width: 12px; height: 12px; color: #2563eb; flex-shrink: 0;" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z" />
                                </svg>
                            @elseif(str_contains($mimeType, 'excel') || str_contains($mimeType, 'spreadsheet'))
                                {{-- Excel Icon --}}
                                <svg style="width: 12px; height: 12px; color: #059669; flex-shrink: 0;" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z" />
                                </svg>
                            @else
                                {{-- Generic Document Icon --}}
                                <svg style="width: 12px; height: 12px; color: #4b5563; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            @endif
                            
                            <div style="flex: 1; min-width: 0;">
                                <div style="font-size: 11px; color: #2563eb; font-weight: 500; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    {{ $fileName }}
                                </div>
                                <div style="font-size: 10px; color: #6b7280;">
                                    {{ $fileSize }} • {{ strtoupper($media->extension) }}
                                </div>
                            </div>
                            
                            <div style="flex-shrink: 0;">
                                <svg style="width: 10px; height: 10px; color: #9ca3af;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
</x-dynamic-component>
