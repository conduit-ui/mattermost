<x-filament-panels::page>
    <div class="space-y-4">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end">
            <div class="flex-1">
                <label for="channelId" class="fi-fo-field-wrp-label">Channel ID</label>
                <input
                    id="channelId"
                    type="text"
                    wire:model.live.debounce.500ms="channelId"
                    placeholder="Watched channel ID"
                    class="fi-input block w-full rounded-lg border-gray-300 shadow-sm"
                />
            </div>
            <div class="flex-1">
                <label for="sinceDate" class="fi-fo-field-wrp-label">Since (date)</label>
                <input
                    id="sinceDate"
                    type="date"
                    wire:model.live="sinceDate"
                    class="fi-input block w-full rounded-lg border-gray-300 shadow-sm"
                />
            </div>
        </div>

        @if (empty($messages))
            <div class="rounded-lg border border-dashed border-gray-300 p-6 text-center text-sm text-gray-500">
                @if (! $channelId)
                    No watch channel configured. Set <code>config('mattermost.filament.watch_channel_id')</code> or paste a channel ID above.
                @else
                    No messages found for this channel.
                @endif
            </div>
        @else
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left font-medium">Time (UTC)</th>
                            <th class="px-4 py-2 text-left font-medium">User</th>
                            <th class="px-4 py-2 text-left font-medium">Message</th>
                            <th class="px-4 py-2 text-left font-medium">Thread</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @foreach ($messages as $message)
                            <tr>
                                <td class="px-4 py-2 align-top font-mono text-xs">{{ $message['created_at_iso'] }}</td>
                                <td class="px-4 py-2 align-top font-mono text-xs">{{ $message['user_id'] }}</td>
                                <td class="px-4 py-2 align-top">{{ $message['message'] }}</td>
                                <td class="px-4 py-2 align-top font-mono text-xs">{{ $message['root_id'] ?: '—' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-filament-panels::page>
