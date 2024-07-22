@php
  $user = Auth::user();
  $id = $user->id;
  $user_guru =DB::table('guru')
        ->join('users', 'users.id', '=', 'guru.user_id')
        ->select('users.nama as nama_guru','guru.*', 'users.*')
        ->where('users.id', $id)
        ->first(); 
  $user_siswa =DB::table('siswa')
        ->join('users', 'users.id', '=', 'siswa.id_siswa')
        ->select('siswa.*', 'users.*')
        ->where('users.id', $id)
        ->first(); 
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
                            @if($user->role == 'guru')
                            <span class="user-level"> {{ $user_guru->nama_sekolah }}</span>
                            @endif
                            @if($user->role == 'siswa')
                            <span class="user-level"> {{ $user_siswa->nis }}</span>
                            @endif
                            <span class="caret"></span>
                        </span>
                    </a>
                    {{-- <div class="clearfix"></div> --}}
                </div>
            </div>
            <ul class="nav nav-primary">
       {{-- Menu Guru --}}
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Menu</h4>
                </li>
                <li class="nav-item {{ request()->is('home') ? 'active' : '' }}">
                    <a href="{{ url('/home') }}">
                        <i class="fas fa-home"></i>
                        <p>Home</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('perangkingan') ? 'active' : '' }}">
                    <a href="{{ url('/perangkingan') }}">
                        <i class="fas fa-graduation-cap"></i>
                        <p>Penentuan Program Studi</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('RuleC45') ? 'active' : '' }}">
                    <a href="{{ url('/RuleC45') }}">
                        <i class="fas fa-sitemap"></i>
                        <p>Pohon Keputusan C4.5</p>
                    </a>
                </li>
        {{-- End Menu Guru --}}
                
            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->