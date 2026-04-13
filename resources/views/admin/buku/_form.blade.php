<style>
  .field { margin-bottom: 1.25rem; }
  .field label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 6px;
    letter-spacing: 0.01em;
  }
  .field label .opt {
    font-weight: 400;
    color: #9ca3af;
    font-size: 12px;
    margin-left: 4px;
  }

  /* INPUT & SELECT & TEXTAREA */
  .finput, .fselect, .ftextarea {
    width: 100%;
    padding: 10px 14px;
    font-size: 14px;
    color: #111827;
    background: #fff;
    border: 1.5px solid #e5e7eb;
    border-radius: 10px;
    transition: border-color .15s, box-shadow .15s;
    outline: none;
    font-family: inherit;
  }
  .finput:focus, .fselect:focus, .ftextarea:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99,102,241,.12);
  }
  .finput.is-invalid, .fselect.is-invalid, .ftextarea.is-invalid {
    border-color: #ef4444;
    box-shadow: 0 0 0 3px rgba(239,68,68,.1);
  }
  .ftextarea { resize: vertical; min-height: 100px; line-height: 1.6; }
  .fselect { appearance: none; cursor: pointer;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236b7280' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 14px center;
    padding-right: 38px;
  }

  .ferror {
    display: block;
    font-size: 12px;
    color: #ef4444;
    margin-top: 5px;
  }

  /* ROW 2 kolom */
  .field-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
  }
  @media (max-width: 600px) { .field-row { grid-template-columns: 1fr; } }

  /* COVER PREVIEW */
  .cover-preview-wrap {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 10px;
  }
  .cover-preview-img {
    width: 80px;
    height: 110px;
    object-fit: cover;
    border-radius: 8px;
    border: 1.5px solid #e5e7eb;
    background: #f3f4f6;
  }
  .cover-preview-placeholder {
    width: 80px;
    height: 110px;
    border-radius: 8px;
    border: 1.5px dashed #d1d5db;
    background: #f9fafb;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #9ca3af;
    font-size: 22px;
  }
  .cover-hint {
    font-size: 12px;
    color: #6b7280;
    line-height: 1.6;
  }

  /* FILE INPUT CUSTOM */
  .file-input-wrap {
    position: relative;
  }
  .file-input-wrap input[type="file"] {
    width: 100%;
    padding: 10px 14px;
    font-size: 13px;
    color: #6b7280;
    background: #f9fafb;
    border: 1.5px dashed #d1d5db;
    border-radius: 10px;
    cursor: pointer;
    transition: border-color .15s;
  }
  .file-input-wrap input[type="file"]:hover { border-color: #6366f1; }
  .file-input-wrap input[type="file"].is-invalid { border-color: #ef4444; }

  /* STOK HELPER */
  .stok-hint {
    font-size: 11px;
    color: #9ca3af;
    margin-top: 4px;
  }

  /* DIVIDER */
  .fsection {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .08em;
    color: #9ca3af;
    margin: 1.5rem 0 1rem;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .fsection::after {
    content: '';
    flex: 1;
    height: 1px;
    background: #f3f4f6;
  }
</style>

{{-- ── INFORMASI BUKU ── --}}
<div class="fsection">Informasi Buku</div>

<div class="field">
    <label for="judul">Judul Buku</label>
    <input type="text" id="judul" name="judul"
           class="finput {{ $errors->has('judul') ? 'is-invalid' : '' }}"
           value="{{ old('judul', $buku->judul ?? '') }}"
           placeholder="Contoh: Laskar Pelangi" required>
    @error('judul') <span class="ferror">{{ $message }}</span> @enderror
</div>

<div class="field">
    <label for="penulis">Penulis</label>
    <input type="text" id="penulis" name="penulis"
           class="finput {{ $errors->has('penulis') ? 'is-invalid' : '' }}"
           value="{{ old('penulis', $buku->penulis ?? '') }}"
           placeholder="Contoh: Andrea Hirata" required>
    @error('penulis') <span class="ferror">{{ $message }}</span> @enderror
</div>

<div class="field-row">
    {{-- CATALOG --}}
    <div class="field" style="margin-bottom:0">
        <label for="catalog_id">Kategori / Katalog</label>
        <select id="catalog_id" name="catalog_id"
                class="fselect {{ $errors->has('catalog_id') ? 'is-invalid' : '' }}">
            <option value="">— Pilih Katalog —</option>
            @foreach($catalogs as $cat)
                <option value="{{ $cat->id }}"
                    {{ old('catalog_id', $buku->catalog_id ?? '') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->nama }}
                </option>
            @endforeach
        </select>
        @error('catalog_id') <span class="ferror">{{ $message }}</span> @enderror
    </div>

    {{-- STOK --}}
    <div class="field" style="margin-bottom:0">
        <label for="stok">Stok</label>
        <input type="number" id="stok" name="stok" min="0"
               class="finput {{ $errors->has('stok') ? 'is-invalid' : '' }}"
               value="{{ old('stok', $buku->stok ?? 0) }}" required>
        <div class="stok-hint">Jumlah eksemplar yang tersedia</div>
        @error('stok') <span class="ferror">{{ $message }}</span> @enderror
    </div>
</div>

<div class="field" style="margin-top:1.25rem">
    <label for="deskripsi">Deskripsi <span class="opt">(opsional)</span></label>
    <textarea id="deskripsi" name="deskripsi" rows="4"
              class="ftextarea {{ $errors->has('deskripsi') ? 'is-invalid' : '' }}"
              placeholder="Sinopsis singkat atau keterangan buku...">{{ old('deskripsi', $buku->deskripsi ?? '') }}</textarea>
    @error('deskripsi') <span class="ferror">{{ $message }}</span> @enderror
</div>

{{-- ── COVER BUKU ── --}}
<div class="fsection">Cover Buku</div>

<div class="field">
    <label for="gambar">Upload Cover <span class="opt">(opsional)</span></label>

    <div class="cover-preview-wrap">
        {{-- Preview gambar --}}
        @if(!empty($buku->gambar ?? null))
            <img id="cover-preview"
                 src="{{ asset('storage/' . $buku->gambar) }}"
                 class="cover-preview-img" alt="Cover saat ini">
        @else
            <div class="cover-preview-placeholder" id="cover-placeholder">
                <i class="bi bi-image"></i>
            </div>
            <img id="cover-preview" class="cover-preview-img" style="display:none" alt="Preview">
        @endif

        <div class="cover-hint">
            Format: JPG, JPEG, PNG<br>
            Ukuran maks: <strong>2 MB</strong><br>
            Rekomendasi: rasio <strong>2:3</strong> (potret)
        </div>
    </div>

    <div class="file-input-wrap">
        <input type="file" id="gambar" name="gambar"
               class="{{ $errors->has('gambar') ? 'is-invalid' : '' }}"
               accept="image/jpg,image/jpeg,image/png">
    </div>
    @error('gambar') <span class="ferror">{{ $message }}</span> @enderror
</div>

<script>
// Live preview cover saat file dipilih
document.getElementById('gambar').addEventListener('change', function () {
    const file = this.files[0];
    if (!file) return;

    const preview = document.getElementById('cover-preview');
    const placeholder = document.getElementById('cover-placeholder');

    const reader = new FileReader();
    reader.onload = function (e) {
        preview.src = e.target.result;
        preview.style.display = 'block';
        if (placeholder) placeholder.style.display = 'none';
    };
    reader.readAsDataURL(file);
});
</script>