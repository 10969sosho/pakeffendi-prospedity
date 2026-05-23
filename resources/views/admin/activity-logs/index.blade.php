@extends('admin.layouts.app')

@section('title', 'Activity Logs')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Activity Logs</h1>
            <p class="mt-2 text-sm text-gray-600">Track all admin activities</p>
        </div>
    </div>

    <!-- Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($totalPropertiesPerAdmin as $admin)
            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Properties</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $admin->properties_count }}</p>
                        <p class="text-sm text-gray-500 mt-1">by {{ $admin->name }}</p>
                    </div>
                    <div class="w-12 h-12 bg-[#E4E9DD] rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-[#5B6A49]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
        <form method="GET" action="{{ route('admin.activity-logs.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Admin</label>
                <select name="user_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                    <option value="">All Admins</option>
                    @foreach($admins as $admin)
                        <option value="{{ $admin->id }}" {{ request('user_id') == $admin->id ? 'selected' : '' }}>{{ $admin->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Action</label>
                <select name="action" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                    <option value="">All Actions</option>
                    <option value="create" {{ request('action') == 'create' ? 'selected' : '' }}>Create</option>
                    <option value="update" {{ request('action') == 'update' ? 'selected' : '' }}>Update</option>
                    <option value="delete" {{ request('action') == 'delete' ? 'selected' : '' }}>Delete</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Model</label>
                <select name="model" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                    <option value="">All Models</option>
                    <option value="Property" {{ request('model') == 'Property' ? 'selected' : '' }}>Property</option>
                    <option value="Inquiry" {{ request('model') == 'Inquiry' ? 'selected' : '' }}>Inquiry</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Date From</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Date To</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="px-4 py-2 bg-[#96A480] hover:bg-[#7A8A6A] text-white rounded-lg font-medium">Filter</button>
                <a href="{{ route('admin.activity-logs.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-medium">Reset</a>
            </div>
        </form>
    </div>

    <!-- Activity Logs Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-[#96A480]">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Admin</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Action</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Model</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Description</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Date & Time</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">IP Address</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($activities as $activity)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $activity->user->name ?? 'N/A' }}</div>
                                <div class="text-xs text-gray-500">{{ $activity->user->email ?? '' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($activity->action == 'create')
                                    <span class="px-2 py-1 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-600 uppercase">
                                        {{ $activity->action }}
                                    </span>
                                @elseif($activity->action == 'update')
                                    <span class="px-2 py-1 inline-flex text-xs font-semibold rounded-full bg-[#E4E9DD] text-[#5B6A49] uppercase">
                                        {{ $activity->action }}
                                    </span>
                                @else
                                    <span class="px-2 py-1 inline-flex text-xs font-semibold rounded-full bg-red-100 text-red-600 uppercase">
                                        {{ $activity->action }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $activity->model }}</div>
                                @if($activity->model_id)
                                    <div class="text-xs text-gray-500">ID: {{ $activity->model_id }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $activity->description }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">
                                    {{ $activity->created_at->format('d M Y') }}<br>
                                    <span class="text-xs">{{ $activity->created_at->format('H:i:s') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">{{ $activity->ip_address ?? '-' }}</div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No activity logs</h3>
                                <p class="mt-1 text-sm text-gray-500">Activity logs will appear here when admins perform actions.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($activities->hasPages())
        <div class="bg-white rounded-xl shadow-lg p-4">
            {{ $activities->links() }}
        </div>
    @endif
</div>
@endsection



