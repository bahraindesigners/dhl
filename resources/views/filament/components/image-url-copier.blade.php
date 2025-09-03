@php
    $record = $getRecord();
    $mediaItems = $record ? $record->getMedia('content_images') : collect();
@endphp

@if($mediaItems->count() > 0)
    <div class="space-y-3 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg border">
        <div class="flex items-center gap-2">
            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
            </svg>
            <h4 class="font-medium text-gray-900 dark:text-gray-100">Image URLs - Click to Copy</h4>
        </div>
        
        @foreach($mediaItems as $media)
            <div class="flex items-center gap-3 p-3 bg-white dark:bg-gray-700 rounded border">
                <!-- Thumbnail -->
                <img src="{{ $media->getUrl('thumb') }}" 
                     alt="{{ $media->name }}" 
                     class="w-12 h-12 object-cover rounded border">
                
                <!-- URL Display -->
                <div class="flex-1 min-w-0">
                    <div class="text-xs text-gray-500 dark:text-gray-400 mb-1">{{ $media->name }}</div>
                    <input type="text" 
                           value="{{ $media->getUrl() }}" 
                           readonly 
                           class="w-full text-sm font-mono bg-gray-100 dark:bg-gray-600 border border-gray-300 dark:border-gray-500 rounded px-2 py-1 text-gray-700 dark:text-gray-300"
                           id="url-{{ $media->id }}">
                </div>
                
                <!-- Copy Button -->
                <button type="button" 
                        onclick="copyToClipboard('url-{{ $media->id }}', this)"
                        class="px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white text-xs rounded transition-colors duration-200 flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                    Copy
                </button>
            </div>
        @endforeach
        
        <div class="text-xs text-gray-500 dark:text-gray-400 mt-3">
            💡 <strong>Tip:</strong> After copying a URL, use the "Link" button in the content editor to insert the image.
        </div>
    </div>

    <script>
        function copyToClipboard(inputId, button) {
            const input = document.getElementById(inputId);
            input.select();
            input.setSelectionRange(0, 99999); // For mobile devices
            
            try {
                document.execCommand('copy');
                
                // Visual feedback
                const originalText = button.innerHTML;
                button.innerHTML = '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Copied!';
                button.classList.remove('bg-blue-500', 'hover:bg-blue-600');
                button.classList.add('bg-green-500');
                
                setTimeout(() => {
                    button.innerHTML = originalText;
                    button.classList.remove('bg-green-500');
                    button.classList.add('bg-blue-500', 'hover:bg-blue-600');
                }, 2000);
                
            } catch (err) {
                console.error('Failed to copy text: ', err);
            }
        }
    </script>
@else
    <div class="text-sm text-gray-500 dark:text-gray-400 italic">
        Upload images above to see their URLs for copying.
    </div>
@endif
