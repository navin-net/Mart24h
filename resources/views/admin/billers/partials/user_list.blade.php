@if($biller->users->count())
    <ul class="list-group">
        @foreach($biller->users as $user)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ $user->name }}
                <span class="text-muted small">{{ $user->email }}</span>
            </li>
        @endforeach
    </ul>
@else
    <div class="alert alert-warning mb-0">
        {{ __('messages.no_users_found') }}
    </div>
@endif
