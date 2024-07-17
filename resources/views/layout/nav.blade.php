<div class="logo">
    <a href="/" style="text-decoration: none; color: white;">KeiLaTrack</a>
</div>
<div class="profile-picture">
    <a href="{{ route('player.information') }}">
        @if (!empty(session('Player_Image')))
            <img src="{{ session('Player_Image') }}" alt="Profile Picture">
        @else
            <img src="https://static.vecteezy.com/system/resources/previews/026/966/960/original/default-avatar-profile-icon-of-social-media-user-vector.jpg" alt="Default Profile Picture">
        @endif
    </a>
</div>
