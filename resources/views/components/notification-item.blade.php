@props(['notification', 'isUnread' => false, 'wireClick'])

<div 
    {{ $attributes->merge(['class' => 'group hover:bg-gray-50 transition-colors cursor-pointer']) }}
    @if(str_starts_with($wireClick, 'opened'))
        wire:click="{{ $wireClick }}"
    @else
        @click="Livewire.navigate('{{ $notification->data['redirect'] }}')"
    @endif
>
    <div class="flex px-4 py-3 items-start">
        <!-- Notification Icon -->
        <div class="relative flex-shrink-0 mt-1">
            @if(isset($notification->data['img']))
                <img 
                    src="{{ asset('storage/'. $notification->data['img']) }}" 
                    alt="Profile"
                    class="h-10 w-10 rounded-full object-cover border-2 border-white shadow"
                >
            @else
                <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                    <span class="text-xl">🕒</span>
                </div>
            @endif
            
            @if($isUnread)
            <span class="absolute -top-1 -right-1 h-3 w-3 rounded-full bg-blue-500 ring-2 ring-white"></span>
            @endif
        </div>

        <!-- Notification Content -->
        <div class="ml-3 flex-1 min-w-0">
            <div class="flex justify-between items-baseline">
                <p class="text-sm font-medium text-gray-900 truncate">
                    @switch(class_basename($notification->type))
                        @case('NewRequest') {{ $notification->data['name'] }} @break
                        @case('RequestStatus') Request Update @break
                        @case('AssingedRequest') New Assignment @break
                    @endswitch
                </p>
                <time class="text-xs text-gray-500 ml-2">
                    {{ $notification->created_at->diffForHumans() }}
                </time>
            </div>

            <div class="text-sm text-gray-600 mt-1 space-y-1">
                @switch(class_basename($notification->type))
                    @case('NewRequest')
                        <p>Sent a request</p>
                        <p class="truncate"><span class="font-medium">Concerns:</span> {{ $notification->data['concerns'] }}</p>
                    @break

                    @case('RequestStatus')
                        <p>
                            Your request from {{ \Carbon\Carbon::parse($notification->data['date'])->format('M j, Y') }}
                            @if($notification->data['status'] == 'declined' || $notification->data['status'] == 'resolved')
                                has been
                            @elseif($notification->data['status'] == 'waiting')
                                is currently
                            @else
                                is
                            @endif
                            <span class="font-medium capitalize">{{ $notification->data['status'] }}</span>
                        </p>
                    @break

                    @case('AssingedRequest')
                        <p>Assigned to handle {{ $notification->data['name'] }}'s request</p>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            {{ $notification->data['category'] }}
                        </span>
                    @break
                @endswitch
            </div>
        </div>
    </div>
</div>