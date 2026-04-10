@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')

<style>
  .profile-page { background: #F9F4EA; padding: 2.5rem 0; font-family: 'Lora', serif; }
  .page-label { font-size: 11px; text-transform: uppercase; letter-spacing: 0.1em; color: #A0905E; margin-bottom: 6px; }
  .page-title { font-family: 'Playfair Display', serif; font-size: 26px; font-weight: 600; color: #3A2E1A; }
  .page-divider { width: 44px; height: 2px; background: #D4C490; border-radius: 2px; margin: 10px 0 2rem; }

  .profile-card { background: #FEFCF7; border: 1px solid #E8DFC8; border-radius: 16px; overflow: hidden; }

  .profile-top { background: #F0E6C8; padding: 2rem; display: flex; align-items: center; gap: 1.5rem; border-bottom: 1px solid #E8DFC8; flex-wrap: wrap; }

  .avatar-foto { width: 85px; height: 85px; border-radius: 50%; object-fit: cover; border: 3px solid #D4C49A; flex-shrink: 0; }
  .avatar-initial { width: 85px; height: 85px; border-radius: 50%; background: #EDE0BE; border: 3px solid #D4C49A; display: flex; align-items: center; justify-content: center; font-family: 'Playfair Display', serif; font-size: 30px; font-weight: 600; color: #3A2E1A; flex-shrink: 0; }

  .profile-name { font-family: 'Playfair Display', serif; font-size: 21px; font-weight: 600; color: #3A2E1A; margin-bottom: 3px; }
  .profile-email { font-size: 13px; color: #8A7A55; font-style: italic; }
  .profile-badge { display: inline-block; background: #F5EDD6; color: #8A7040; font-size: 10px; letter-spacing: 0.07em; text-transform: uppercase; padding: 3px 12px; border-radius: 20px; border: 1px solid #D4C490; margin-top: 8px; }

  .profile-body { padding: 1.75rem 2rem; }
  .info-section-title { font-family: 'Playfair Display', serif; font-size: 12px; font-weight: 600; color: #3A2E1A; letter-spacing: 0.08em; text-transform: uppercase; margin-bottom: 14px; }

  .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 1.75rem; }
  @media (max-width: 576px) { .info-grid { grid-template-columns: 1fr; } }

  .info-item { background: #FAF6EC; border: 1px solid #E8DFC8; border-radius: 10px; padding: 12px 16px; }
  .info-label { font-size: 10px; color: #A0905E; text-transform: uppercase; letter-spacing: 0.07em; margin-bottom: 5px; }
  .info-value { font-size: 14px; color: #3A2E1A; font-weight: 500; }
  .info-value.empty { color: #BBA97A; font-style: italic; font-weight: 400; }

  .divider-line { border: none; border-top: 1px solid #E8DFC8; margin: 1.5rem 0; }

  .btn-edit { display: inline-block; background: #3A2E1A; color: #F5EDD6 !important; font-family: 'Playfair Display', serif; font-size: 14px; font-weight: 500; padding: 11px 28px; border-radius: 10px; text-decoration: none; letter-spacing: 0.04em; transition: background 0.2s, transform 0.15s; }
  .btn-edit:hover { background: #4E3D24; transform: translateY(-1px); }

  .alert-success-custom { background: #F0E6C8; border: 1px solid #D4C490; color: #5C4220; border-radius: 10px; padding: 12px 16px; margin-bottom: 1.5rem; font-size: 14px; }
</style>

<div class="profile-page">
  <div class="container" style="max-width: 720px;">

    {{-- Breadcrumb label --}}
    <div class="page-label">Akun Saya</div>
    <div class="page-title">Profil Saya</div>
    <div class="page-divider"></div>

    {{-- Alert sukses --}}
    @if (session('success'))
      <div class="alert-success-custom">
        ✅ &nbsp;{{ session('success') }}
      </div>
    @endif

    <div class="profile-card">

      {{-- ===== TOP: Avatar + Nama ===== --}}
      <div class="profile-top">

        {{-- Foto atau inisial --}}
        @if ($profile && $profile->foto)
          <img class="avatar-foto"
               src="{{ asset('storage/' . $profile->foto) }}"
               alt="Foto {{ $user->name }}">
        @else
          <div class="avatar-initial">
            {{ strtoupper(substr($user->name, 0, 1)) }}
          </div>
        @endif

        <div>
          <div class="profile-name">{{ $user->name }}</div>
          <div class="profile-email">{{ $user->email }}</div>
          <span class="profile-badge">Anggota Perpustakaan</span>
        </div>

      </div>

      {{-- ===== BODY: Info detail ===== --}}
      <div class="profile-body">

        <div class="info-section-title">Informasi Pribadi</div>

        <div class="info-grid">

          <div class="info-item">
            <div class="info-label">Nomor HP</div>
            <div class="info-value {{ !($profile && $profile->no_hp) ? 'empty' : '' }}">
              {{ ($profile && $profile->no_hp) ? $profile->no_hp : 'Belum diisi' }}
            </div>
          </div>

          <div class="info-item">
            <div class="info-label">Tanggal Lahir</div>
            <div class="info-value {{ !($profile && $profile->tanggal_lahir) ? 'empty' : '' }}">
              {{ ($profile && $profile->tanggal_lahir)
                  ? \Carbon\Carbon::parse($profile->tanggal_lahir)->translatedFormat('d F Y')
                  : 'Belum diisi' }}
            </div>
          </div>

          <div class="info-item" style="grid-column: 1 / -1;">
            <div class="info-label">Alamat</div>
            <div class="info-value {{ !($profile && $profile->alamat) ? 'empty' : '' }}">
              {{ ($profile && $profile->alamat) ? $profile->alamat : 'Belum diisi' }}
            </div>
          </div>

        </div>

        <hr class="divider-line">

        <a href="{{ route('profile.edit') }}" class="btn-edit">
          ✏️ &nbsp;Edit Profil
        </a>

      </div>

    </div>
  </div>
</div>

@endsection