@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')

<style>
  .profile-page { background: #F9F4EA; padding: 2.5rem 0; font-family: 'Lora', serif; }
  .page-label { font-size: 11px; text-transform: uppercase; letter-spacing: 0.1em; color: #A0905E; margin-bottom: 6px; }
  .page-title { font-family: 'Playfair Display', serif; font-size: 26px; font-weight: 600; color: #3A2E1A; }
  .page-divider { width: 44px; height: 2px; background: #D4C490; border-radius: 2px; margin: 10px 0 2rem; }

  .edit-card { background: #FEFCF7; border: 1px solid #E8DFC8; border-radius: 16px; overflow: hidden; }

  /* Top header */
  .edit-top { background: #F0E6C8; padding: 1.75rem 2rem; border-bottom: 1px solid #E8DFC8; display: flex; align-items: center; gap: 1.25rem; flex-wrap: wrap; }
  .avatar-foto { width: 68px; height: 68px; border-radius: 50%; object-fit: cover; border: 3px solid #D4C49A; flex-shrink: 0; }
  .avatar-initial { width: 68px; height: 68px; border-radius: 50%; background: #EDE0BE; border: 3px solid #D4C49A; display: flex; align-items: center; justify-content: center; font-family: 'Playfair Display', serif; font-size: 26px; font-weight: 600; color: #3A2E1A; flex-shrink: 0; }
  .edit-top-name { font-family: 'Playfair Display', serif; font-size: 17px; font-weight: 600; color: #3A2E1A; margin-bottom: 3px; }
  .edit-top-email { font-size: 13px; color: #8A7A55; font-style: italic; }

  /* Body */
  .edit-body { padding: 1.75rem 2rem; }
  .section-label { font-size: 11px; text-transform: uppercase; letter-spacing: 0.09em; color: #A0905E; font-weight: 600; margin-bottom: 14px; padding-bottom: 8px; border-bottom: 1px solid #E8DFC8; }

  /* Form */
  .form-label-custom { display: block; font-size: 12px; color: #6B5B3E; text-transform: uppercase; letter-spacing: 0.07em; margin-bottom: 7px; }
  .form-control-custom { width: 100%; background: #FAF6EC; border: 1px solid #E0D2B0; border-radius: 10px; padding: 11px 14px; font-size: 14px; font-family: 'Lora', serif; color: #3A2E1A; outline: none; transition: border 0.2s, box-shadow 0.2s; }
  .form-control-custom:focus { border-color: #C4AA70; box-shadow: 0 0 0 3px rgba(196,170,112,0.15); }
  .form-control-custom::placeholder { color: #BBA97A; font-style: italic; }
  .form-control-custom.is-invalid { border-color: #D4654A; }
  .error-msg { font-size: 12px; color: #C0522A; font-style: italic; margin-top: 5px; }

  /* Upload foto */
  .foto-upload-area { background: #FAF6EC; border: 1.5px dashed #D4C490; border-radius: 12px; padding: 1.5rem; text-align: center; cursor: pointer; transition: border-color 0.2s, background 0.2s; }
  .foto-upload-area:hover { background: #F5EDD6; border-color: #C4AA70; }
  .foto-upload-text { font-size: 13px; color: #8A7A55; font-style: italic; margin-top: 6px; }
  .foto-upload-hint { font-size: 11px; color: #BBA97A; margin-top: 4px; }
  .foto-preview { display: none; width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 3px solid #D4C49A; margin: 0 auto 8px; }

  .divider-line { border: none; border-top: 1px solid #E8DFC8; margin: 1.5rem 0; }

  /* Buttons */
  .btn-row { display: flex; gap: 12px; align-items: center; flex-wrap: wrap; }
  .btn-save { background: #3A2E1A; color: #F5EDD6; font-family: 'Playfair Display', serif; font-size: 14px; font-weight: 500; padding: 11px 28px; border-radius: 10px; border: none; cursor: pointer; letter-spacing: 0.04em; transition: background 0.2s, transform 0.15s; }
  .btn-save:hover { background: #4E3D24; transform: translateY(-1px); }
  .btn-cancel { font-size: 13px; color: #8A7040; font-style: italic; text-decoration: none; padding: 11px 4px; }
  .btn-cancel:hover { color: #3A2E1A; }
</style>

<div class="profile-page">
  <div class="container" style="max-width: 720px;">

    <div class="page-label">Akun Saya</div>
    <div class="page-title">Edit Profil</div>
    <div class="page-divider"></div>

    <div class="edit-card">

      {{-- ===== TOP: Avatar + info ===== --}}
      <div class="edit-top">
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
          <div class="edit-top-name">{{ $user->name }}</div>
          <div class="edit-top-email">{{ $user->email }}</div>
        </div>
      </div>

      {{-- ===== FORM ===== --}}
      <div class="edit-body">

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          {{-- ── Informasi Akun ── --}}
          <div class="section-label">Informasi Akun</div>

          <div class="mb-3">
            <label class="form-label-custom" for="name">Nama Lengkap</label>
            <input type="text"
                   id="name"
                   name="name"
                   class="form-control-custom {{ $errors->has('name') ? 'is-invalid' : '' }}"
                   value="{{ old('name', $user->name) }}"
                   placeholder="Nama lengkap kamu">
            @error('name')
              <div class="error-msg">{{ $message }}</div>
            @enderror
          </div>

          <div class="divider-line"></div>

          {{-- ── Informasi Pribadi ── --}}
          <div class="section-label">Informasi Pribadi</div>

          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label-custom" for="no_hp">Nomor HP</label>
              <input type="text"
                     id="no_hp"
                     name="no_hp"
                     class="form-control-custom {{ $errors->has('no_hp') ? 'is-invalid' : '' }}"
                     value="{{ old('no_hp', $profile->no_hp ?? '') }}"
                     placeholder="Contoh: 08123456789">
              @error('no_hp')
                <div class="error-msg">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6">
              <label class="form-label-custom" for="tanggal_lahir">Tanggal Lahir</label>
              <input type="date"
                     id="tanggal_lahir"
                     name="tanggal_lahir"
                     class="form-control-custom {{ $errors->has('tanggal_lahir') ? 'is-invalid' : '' }}"
                     value="{{ old('tanggal_lahir', optional($profile)->tanggal_lahir
                         ? \Carbon\Carbon::parse($profile->tanggal_lahir)->format('Y-m-d')
                         : '') }}">
              @error('tanggal_lahir')
                <div class="error-msg">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label-custom" for="alamat">Alamat</label>
            <textarea id="alamat"
                      name="alamat"
                      class="form-control-custom {{ $errors->has('alamat') ? 'is-invalid' : '' }}"
                      rows="3"
                      placeholder="Alamat lengkap kamu...">{{ old('alamat', $profile->alamat ?? '') }}</textarea>
            @error('alamat')
              <div class="error-msg">{{ $message }}</div>
            @enderror
          </div>

          <div class="divider-line"></div>

          {{-- ── Foto Profil ── --}}
          <div class="section-label">Foto Profil</div>

          <label for="foto" class="foto-upload-area" id="uploadLabel">
            <img id="fotoPreview" class="foto-preview" src="#" alt="Preview">
            <div style="font-size:28px;">🖼️</div>
            <div class="foto-upload-text">Klik untuk upload foto profil baru</div>
            <div class="foto-upload-hint">JPG, JPEG, PNG — Maks. 2MB</div>
          </label>

          <input type="file"
                 id="foto"
                 name="foto"
                 accept="image/jpg,image/jpeg,image/png"
                 style="display:none;">

          @error('foto')
            <div class="error-msg mt-2">{{ $message }}</div>
          @enderror

          <div class="divider-line"></div>

          {{-- ── Tombol ── --}}
          <div class="btn-row">
            <button type="submit" class="btn-save">
              💾 &nbsp;Simpan Perubahan
            </button>
            <a href="{{ route('profile.show') }}" class="btn-cancel">Batal</a>
          </div>

        </form>
      </div>

    </div>
  </div>
</div>

{{-- Preview foto sebelum upload --}}
<script>
  document.getElementById('foto').addEventListener('change', function () {
    const file = this.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function (e) {
      const preview = document.getElementById('fotoPreview');
      preview.src = e.target.result;
      preview.style.display = 'block';
    };
    reader.readAsDataURL(file);
  });
</script>

@endsection