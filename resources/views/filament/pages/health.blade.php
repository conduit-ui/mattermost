<x-filament-panels::page>
    <div class="space-y-6">
        <section>
            <h2 class="text-lg font-semibold">API connectivity</h2>
            <dl class="mt-2 grid grid-cols-1 gap-2 sm:grid-cols-3">
                <div class="rounded-lg border border-gray-200 p-4">
                    <dt class="text-xs uppercase text-gray-500">Reachable</dt>
                    <dd class="mt-1 text-sm">{{ $api['reachable'] ? 'Yes' : 'No' }}</dd>
                </div>
                <div class="rounded-lg border border-gray-200 p-4">
                    <dt class="text-xs uppercase text-gray-500">Latency</dt>
                    <dd class="mt-1 text-sm">{{ $api['latency_ms'] !== null ? $api['latency_ms'].' ms' : '—' }}</dd>
                </div>
                <div class="rounded-lg border border-gray-200 p-4">
                    <dt class="text-xs uppercase text-gray-500">HTTP status</dt>
                    <dd class="mt-1 text-sm">{{ $api['status'] ?? '—' }}</dd>
                </div>
            </dl>
            @if ($api['error'])
                <p class="mt-2 text-sm text-red-600">{{ $api['error'] }}</p>
            @endif
        </section>

        <section>
            <h2 class="text-lg font-semibold">WebSocket</h2>
            <p class="mt-1 text-sm">State: <span class="font-mono">{{ $webSocketState->value }}</span></p>
        </section>

        <section>
            <h2 class="text-lg font-semibold">Bot identity</h2>
            @if ($identity['ok'])
                <dl class="mt-2 grid grid-cols-1 gap-2 sm:grid-cols-3">
                    <div class="rounded-lg border border-gray-200 p-4">
                        <dt class="text-xs uppercase text-gray-500">Username</dt>
                        <dd class="mt-1 text-sm">@{{ $identity['username'] }}</dd>
                    </div>
                    <div class="rounded-lg border border-gray-200 p-4">
                        <dt class="text-xs uppercase text-gray-500">User ID</dt>
                        <dd class="mt-1 font-mono text-xs">{{ $identity['id'] }}</dd>
                    </div>
                    <div class="rounded-lg border border-gray-200 p-4">
                        <dt class="text-xs uppercase text-gray-500">Roles</dt>
                        <dd class="mt-1 font-mono text-xs">{{ $identity['roles'] ?? '—' }}</dd>
                    </div>
                </dl>
            @else
                <p class="mt-1 text-sm text-red-600">Bot identity unavailable.</p>
            @endif
        </section>

        <section>
            <h2 class="text-lg font-semibold">Channel memberships</h2>
            @if (empty($channels))
                <p class="mt-1 text-sm text-gray-500">No channels listed (bot may not be a member of any channel, or the API call failed).</p>
            @else
                <div class="mt-2 overflow-x-auto rounded-lg border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left font-medium">Display name</th>
                                <th class="px-4 py-2 text-left font-medium">Name</th>
                                <th class="px-4 py-2 text-left font-medium">Type</th>
                                <th class="px-4 py-2 text-left font-medium">ID</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @foreach ($channels as $channel)
                                <tr>
                                    <td class="px-4 py-2">{{ $channel['display_name'] ?: '—' }}</td>
                                    <td class="px-4 py-2 font-mono text-xs">{{ $channel['name'] }}</td>
                                    <td class="px-4 py-2 font-mono text-xs">{{ $channel['type'] }}</td>
                                    <td class="px-4 py-2 font-mono text-xs">{{ $channel['id'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>
    </div>
</x-filament-panels::page>
