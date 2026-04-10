<style>
  .section-label {
    font-size: 10px;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: #A0905E;
    font-weight: 600;
    padding-bottom: 8px;
    border-bottom: 1px solid #E8DFC8;
    margin-bottom: 16px;
  }

  .form-group-custom { margin-bottom: 18px; }

  .form-group-custom label {
    display: block;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: #6B5B3E;
    margin-bottom: 7px;
    font-weight: 600;
    font-family: 'Lora', serif;
  }

  .form-group-custom label .opsional {
    font-size: 10px;
    color: #BBA97A;
    font-style: italic;
    text-transform: none;
    letter-spacing: 0;
    font-weight: 400;
  }

  .form-input {
    width: 100%;
    background: #FAF6EC;
    border: 1px solid #E0D2B0;
    border-radius: 10px;
    padding: 11px 14px;
    font-size: 14px;
    font-family: 'Lora', serif;
    color: #3A2E1A;
    outline: none;
    appearance: none;
    -webkit-appearance: none;
    transition: border 0.2s, box-shadow 0.2s;
  }

  .form-input:focus {
    border-color: #C4AA70;
    box-shadow: 0 0 0 3px rgba(196, 170, 112, 0.18);
  }

  select.form-input {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%238A7A55' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 14px center;
    padding-right: 36px;
  }

  .form-input.is-invalid { border-color: #C0522A; }

  .form-error {
    font-size: 12px;
    color: #C0522A;
    font-style: italic;
    margin-top: 5px;
    display: block;
  }

  /* Status radio pill */
  .status-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
  }

  @media (min-width: 576px) {
    .status-grid { grid-template-columns: repeat(4, 1fr); }
  }

  .status-opt { position: relative; }
  .status-opt input[type="radio"] { position: absolute; opacity: 0; width: 0; height: 0; }

  .status-opt label {
    display: block;
    text-align: center;
    padding: 9px 6px;
    background: #FAF6EC;
    border: 1px solid #E0D2B0;
    border-radius: 10px;
    font-size: 13px;
    color: #6B5B3E;
    cursor: pointer;
    transition: all 0.15s;
    font-family: 'Lora', serif;
    text-transform: capitalize;
    letter-spacing: 0;
    font-weight: 400;
  }

  .status-opt input:checked + label {
    background: #3A2E1A;
    border-color: #3A2E1A;
    color: #F5EDD6;
  }

  .status-opt label:hover { background: #EDE0BE; border-color: #C4AA70; }

  .divider-line { border: none; border-top: 1px solid #E8DFC8; margin: 1.5rem 0; }
</style>


{{-- ── Peminjam & Buku ── --}}
<div class="section-label">Data Peminjam &amp; Buku</div>

<div class="form-group-custom">
    <label for="user_id">Peminjam</label>
    <select id="user_id" name="user_id"
            class="form-input {{ $errors->has('user_id') ? 'is-invalid' : '' }}" required>
        <option value="">-- Pilih Peminjam --</option>
        @foreach ($users as $user)
            <option value="{{ $user->id }}"
                {{ old('user_id', $peminjaman->user_id ?? '') == $user->id ? 'selected' : '' }}>
                {{ $user->name }}
            </option>
        @endforeach
    </select>
    @error('user_id')
        <span class="form-error">{{ $message }}</span>
    @enderror
</div>

<div class="form-group-custom">
    <label for="buku_id">Buku</label>
    <select id="buku_id" name="buku_id"
            class="form-input {{ $errors->has('buku_id') ? 'is-invalid' : '' }}" required>
        <option value="">-- Pilih Buku --</option>
        @foreach ($bukus as $buku)
            <option value="{{ $buku->id }}"
                {{ old('buku_id', $peminjaman->buku_id ?? '') == $buku->id ? 'selected' : '' }}>
                {{ $buku->judul }} (Stok: {{ $buku->stok }})
            </option>
        @endforeach
    </select>
    @error('buku_id')
        <span class="form-error">{{ $message }}</span>
    @enderror
</div>

<div class="divider-line"></div>

{{-- ── Tanggal ── --}}
<div class="section-label">Tanggal</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="form-group-custom">
            <label for="tanggal_request">Tanggal Request</label>
            <input type="date" id="tanggal_request" name="tanggal_request"
                   class="form-input {{ $errors->has('tanggal_request') ? 'is-invalid' : '' }}"
                   value="{{ old('tanggal_request', isset($peminjaman) ? $peminjaman->tanggal_request?->format('Y-m-d') : '') }}"
                   required>
            @error('tanggal_request')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group-custom">
            <label for="tanggal_pinjam">
                Tanggal Pinjam
                <span class="opsional">(opsional)</span>
            </label>
            <input type="date" id="tanggal_pinjam" name="tanggal_pinjam"
                   class="form-input {{ $errors->has('tanggal_pinjam') ? 'is-invalid' : '' }}"
                   value="{{ old('tanggal_pinjam', isset($peminjaman) ? $peminjaman->tanggal_pinjam?->format('Y-m-d') : '') }}">
            @error('tanggal_pinjam')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group-custom">
            <label for="tanggal_kembali">
                Tanggal Kembali
                <span class="opsional">(opsional)</span>
            </label>
            <input type="date" id="tanggal_kembali" name="tanggal_kembali"
                   class="form-input {{ $errors->has('tanggal_kembali') ? 'is-invalid' : '' }}"
                   value="{{ old('tanggal_kembali', isset($peminjaman) ? $peminjaman->tanggal_kembali?->format('Y-m-d') : '') }}">
            @error('tanggal_kembali')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="divider-line"></div>

{{-- ── Status ── --}}
<div class="section-label">Status Peminjaman</div>

<div class="status-grid mb-2">
    @foreach (['pending', 'disetujui', 'ditolak', 'dikembalikan'] as $s)
        <div class="status-opt">
            <input type="radio"
                   id="status_{{ $s }}"
                   name="status"
                   value="{{ $s }}"
                   {{ old('status', $peminjaman->status ?? 'pending') === $s ? 'checked' : '' }}>
            <label for="status_{{ $s }}">{{ ucfirst($s) }}</label>
        </div>
    @endforeach
</div>

@error('status')
    <span class="form-error">{{ $message }}</span>
@enderror