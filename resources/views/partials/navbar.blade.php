<nav class="navbar navbar-expand-lg navbar-light" style="background: #FFFFFF !important;">
    <div class="container-fluid">

        <button type="button" id="sidebarCollapse" class="btn btn-info"
            style="margin-top: 4px; margin-bottom:2px; background: #FFFFFF !important;">
            <i class="fas fa-align-left"
                style="font-size: 20px; margin-top: 5px; margin-bottom: 6px; color: #008A85;"></i>
        </button>

        <div>
            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item active position-relative">
                    <a id="btn-dropdownnavbar" href="#"
                        style="color: #008A85; font-weight: 500;">{{ Auth::User()->nama_siswa }}
                        <i class="fas fa-caret-down ml-2"></i>
                    </a>
                    <div class="dropdown-navbar dropdown-navbar-status"
                        style="min-width: 129px !important; z-index: 999;">
                        <ul class="pl-0">
                            <a href="{{ url('profil/' . Auth::User()->slug) }}">
                                <li><i class="fa fa-user" style="width: 29px;"></i>Profile</li>
                            </a>
                            <a href="" id="btn-about">
                                <li><i class="fa fa-info-circle" style="width: 29px;"></i>About</li>
                            </a>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <li><i class="fas fa-sign-out-alt" style="width: 29px;"></i>Log Out</li>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>

@push('extras-js')
<script>
    $('#btn-about').click(function (e) {
        e.preventDefault();
        Swal.fire({
            title: '<span class="mt-4">ujikom_angga @ 2020</span>',
            html: '<span class="mt-3 mb-3">v. 1.0.0.0</span>',
            showCloseButton: true,
            showConfirmButton: false,
        })
    });
</script>
@endpush