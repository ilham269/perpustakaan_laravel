@extends('layouts.app')
@section('title', 'Pinjam Buku')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600&family=Lora:ital,wght@0,400;0,500;1,400&display=swap" rel="stylesheet">

<style>
  .pinjam-page { background: #F9F4EA; min-height: 100vh; padding: 2.5rem 0; font-family: 'Lora', serif; }
  .page-label  { font-size: 11px; text-transform: uppercase; letter-spacing: .1em; color: #A0905E; margin-bottom: 6px; }
  .page-title  { font-family: 'Playfair Display', serif; font-size: 26px; font-weight: 600; color: #3A2E1A; }
  .page-divider{ width: 44px; height: 2px; background: #D4C490; border-radius: 2px; margin: 10px 0 2rem; }

  .form-card   { background: #FEFCF7; border: 1px solid #E8DFC8; border-radius: 16px; overflow: hidden; }
  .form-header { background: #F0E6C8; padding: 1.25rem 2rem; border-bottom: 1px solid #E8DFC8; }
  .form-header h5 { font-family: 'Playfair Display', serif; font-size: 16px; color: #3A2E1A; margin: 0; }
  .form-body   { padding: 1.75rem 2rem; }

  .sec-label   { font-size: 11px; text-transform: uppercase; letter-spacing: .09em; color: #A0905E; font-weight: 600;
                 margin-bottom: 14px; padding-bottom: 8px; border-bottom: 1px solid #E8DFC8; }
  .flabel      { display: block; font-size: 12px; color: #6B5B3E; text-transform: uppercase; letter-spacing: .07em; margin-bottom: 7px; }
  .finput      { width: 100%; background: #FAF6EC; border: 1px solid #E0D2B0; border-radius: 10px;
                 padding: 11px 14px; font-size: 14px; font-family: 'Lora', serif; color: #3A2E1A;
                 outline: none; transition: border .2s, box-shadow .2s; }
  .finput:focus{ border-color: #C4AA70; box-shadow: 0 0 0 3px rgba(196,170,112,.15); }
  .finput.is-invalid { border-color: #D4654A; }
  .ferror      { font-size: 12px; color: #C0522A; font-style: italic; margin-top: 5px; display: block; }
  select.finput{ appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%238A7A55' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
                 background-repeat: no-repeat; background-position: right 14px center; padding-right: 36px; }
  .divider-line{ border: none; border-top: 1px solid #E8DFC8; margin: 1.5rem 0; }

  .book-option { display: flex; align-items: center; gap: 14px; padding: 12px 14px; background: #FAF6EC;
                 border: 1px solid #E0D2B0; border-radius: 10px; cursor: pointer; transition: all .15s; margin-bottom: 10px; }
  .book-option:hover { background: #F0E6C8; border-color: #C4AA70; }
  .book-option input[type=radio] { accent-color: #3A2E1A; width: 16px; height: 16px; flex-shrink: 0; }
  .book-option.selected { background: #EDE0BE; border-color: #3A2E1A; }
  .book-cover-sm { width: 44px; height: 60px; object-fit: cover; border-radius: 5px; border: 1px solid #D4C49A; flex-shrink: 0; }
  .book-info-title { font-family: 'Playfair Display', serif; font-size: 14px; color: #3A2E1A; font-weight: 600; }
  .book-info-author { font-size: 12px; color: #8A7A55; font-style: italic; }
  .stok-pill { font-size: 11px; background: #F5EDD6; color: #7A6030; padding: 2px 10px; border-radius: 20px;
               border: 1px solid #DDD0A8; display: inline-block; margin-top: 4px; }

  .btn-submit { background: #3A2E1A; color: #F5EDD6; font-family: 'Playfair Display', serif; font-size: 14px;
                font-weight: 500; padding: 12px 32px; border-radius: 10px; border: none; cursor: pointer;
                letter-spacing: .04em; transition: background .2s, transform .15s; }
  .btn-submit:hover { background: #4E3D24; transform: translateY(-1px); }

  .info-box { background: #FFF8E7; border: 1px solid #F0D080; border-radius: 10px; padding: 12px 16px;
              font-size: 13px; color: #7A5C10; margin-bottom: 1.5rem; }
</style>

<div class="pinjam-page">
  <div class="container" style="max-width: 680px;">

    <div class="page-label">Perpustakaan</div>
    <div class="page-title">Pinjam Buku</div>
    <div class="page-divider"></div>

    <div class="info-box">
      📋 &nbsp;Isi data diri dan pilih buku yang ingin dipinjam. Permintaan akan diproses oleh admin.
      Batas pinjam <strong>7 hari</strong> — keterlambatan dikenakan denda <strong>Rp 1.000/hari</strong>.
    </div>

    <div class="form-card">
      <div class="form-header">
        <h5>📖 Form Peminjaman Buku</h5>
      </div>
      <div class="form-body">

        <form action="{{ route('user.peminjaman.store') }}" method="POST">
          @csrf

          {{-- Data Diri --}}
          <div class="sec-label">Data Diri</div>

          <div class="mb-3">
            <label class="flabel" for="nama">Nama Lengkap</label>
            <input type="text" id="nama" name="nama"
                   class="finput {{ $errors->has('nama') ? 'is-invalid' : '' }}"
                   value="{{ old('nama', $user->name) }}"
                   placeholder="Nama lengkap kamu" required>
            @error('nama') <span class="ferror">{{ $message }}</span> @enderror
          </div>

          <div class="mb-3">
            <label class="flabel" for="alamat">Alamat</label>
            <textarea id="alamat" name="alamat" rows="3"
                      class="finput {{ $errors->has('alamat') ? 'is-invalid' : '' }}"
                      placeholder="Alamat lengkap kamu..." required>{{ old('alamat', $profile->alamat ?? '') }}</textarea>
            @error('alamat') <span class="ferror">{{ $message }}</span> @enderror
          </div>

          <div class="divider-line"></div>

          {{-- Pilih Buku --}}
          <div class="sec-label">Pilih Buku</div>

          @error('buku_id')
            <span class="ferror mb-3 d-block">{{ $message }}</span>
          @enderror

          @forelse ($bukus as $buku)
            <label class="book-option {{ old('buku_id', $selectedBukuId) == $buku->id ? 'selected' : '' }}"
                   for="buku_{{ $buku->id }}" id="label_{{ $buku->id }}">
              <input type="radio" id="buku_{{ $buku->id }}" name="buku_id" value="{{ $buku->id }}"
                     {{ old('buku_id', $selectedBukuId) == $buku->id ? 'checked' : '' }}
                     onchange="highlightBook(this)">
              <img class="book-cover-sm"
                   src="{{ $buku->gambar ? asset('storage/'.$buku->gambar) : 'https://via.placeholder.com/44x60/EDE0BE/9A8860?text=📖' }}"
                   alt="{{ $buku->judul }}">
              <div>
                <div class="book-info-title">{{ $buku->judul }}</div>
                <div class="book-info-author">{{ $buku->penulis }}</div>
                <span class="stok-pill">Stok: {{ $buku->stok }}</span>
              </div>
            </label>
          @empty
            <p class="text-muted fst-italic">Tidak ada buku tersedia saat ini.</p>
          @endforelse

          <div class="divider-line"></div>

          <button type="submit" class="btn-submit">
            📨 &nbsp;Kirim Permintaan Pinjam
          </button>

        </form>
      </div>
    </div>

  </div>
</div>

<script>
  function highlightBook(radio) {
    document.querySelectorAll('.book-option').forEach(el => el.classList.remove('selected'));
    document.getElementById('label_' + radio.value).classList.add('selected');
  }
</script>
@endsection
