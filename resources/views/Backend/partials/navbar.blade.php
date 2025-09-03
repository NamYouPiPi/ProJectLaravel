<!--begin::Start Navbar Links-->
<ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
            <i class="bi bi-list"></i>
        </a>
    </li>
</ul>
<!--end::Start Navbar Links-->
<!--begin::End Navbar Links-->
<ul class="navbar-nav ms-auto">
    <li class="nav-item">
        <a class="nav-link" href="#" data-lte-toggle="fullscreen">
            <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
            <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
        </a>
    </li>
    <!--begin::User Menu Dropdown-->
    <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">


            <span class="d-none d-md-inline">
                {{ auth()->user()->name ?? 'Guest' }}
                @if(auth()->user() && auth()->user()->role)
                    <small class="text-muted">({{ ucfirst(auth()->user()->role->name) }})</small>
                @endif
            </span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
            <!--begin::User Image-->
            <li class="user-header text-bg-primary text-center">
                @if(auth()->user() && auth()->user()->userProfile && auth()->user()->userProfile->profile_image)
                    @php
                        $user = auth()->user();
                        $profile = $user?->userProfile;
                    @endphp
                    @if($profile && $profile->profile_image)
                        <img src="{{ asset('storage/' . $profile->profile_image) }}" class="rounded-circle shadow mb-2"
                            alt="User Image" width="80" height="80" />
                    @else
                        <img src="{{ asset('assets/image/default-profile.png') }}" class="rounded-circle shadow mb-2"
                            alt="User Image" width="80" height="80" />
                    @endif
                @else
                    <img src="{{ asset('assets/image/default-profile.png') }}" class="rounded-circle shadow mb-2"
                        alt="User Image" width="80" height="80" />
                @endif
                <p class="mb-0">
                    <strong>{{ auth()->user()->name ?? 'Guest' }}</strong>
                    @if(auth()->user() && auth()->user()->role)
                        <span class="d-block">{{ ucfirst(auth()->user()->role->name) }}</span>
                    @endif
                </p>
                <p class="mb-0">
                    <small>{{ auth()->user()->email ?? '' }}</small>
                </p>
                <small>
                    Member since {{ auth()->user() ? auth()->user()->created_at->format('M. Y') : '' }}
                </small>
            </li>
            <!--end::User Image-->
            <!--begin::Menu Footer-->
            <li class="user-footer d-flex justify-content-between px-3 py-2">
                @php
                    $user = auth()->user();
                @endphp
                @if($user && (!$user->userProfile->profile_image && !$user->userProfile->bio && !$user->userProfile->phone))
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-flat">Add User Profile</a>
                @else
                    <a href="{{ route('profile.show') }}" class="btn btn-default btn-flat">Profile</a>
                @endif
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-default btn-flat">Sign out</button>
                </form>
            </li>
            <!--end::Menu Footer-->
        </ul>
    </li>
    <!--end::User Menu Dropdown-->
</ul>
<!--end::End Navbar Links-->
