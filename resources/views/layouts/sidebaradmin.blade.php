@php
  $user = Auth::user();
@endphp


<!-- Sidebar -->
<div class="sidebar sidebar-style-2">			
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                <div class="avatar-sm float-left mr-2">
                    @if($user->foto == null)
                    <img src="{{ asset('assets/img/profile/profile_1.png') }}" class="avatar-img rounded-circle" alt="user avatar">
                    @endif
                    @if($user->foto != null)
                    <img src="{{ asset('assets/img/profile/' . $user->foto) }}" class="avatar-img rounded-circle" alt="user avatar">
                    @endif
                </div>
                <div class="info">
                    <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                        <span>
                            {{ $user->nama }}
                            <span class="user-level">{{ $user->role }}</span>
                            <span class="caret"></span>
                        </span>
                    </a>
                </div>
            </div>
            <ul class="nav nav-primary">
       {{-- Admin Menu --}}
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Menu</h4>
                </li>
                <li class="nav-item {{ request()->is('mapel') ? 'active' : '' }}">
                    <a href="{{ url('/mapel') }}">
                        <i class="fas fa-layer-group"></i>
                        <p>Data Mata Pelajaran</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('data_prodi') ? 'active' : '' }}">
                    <a href="{{ url('/data_prodi') }}">
                        <i class="fas fa-graduation-cap"></i>
                        <p>Data Program Studi</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('data_kriteria') ? 'active' : '' }}">
                    <a href="{{ url('/data_kriteria') }}">
                        <i class="fas fa-list-alt"></i>
                        <p>Data Kriteria</p>
                    </a>
                </li>
        {{-- End Menu Admin --}}                
            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->