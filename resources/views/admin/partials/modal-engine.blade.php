<style>
/* ── Modal Overlay ── */
.kmodal-overlay {
    position: fixed; inset: 0; z-index: 1050;
    background: rgba(15,23,42,.45);
    backdrop-filter: blur(3px);
    display: flex; align-items: center; justify-content: center;
    padding: 1rem;
    opacity: 0; pointer-events: none;
    transition: opacity .2s;
}
.kmodal-overlay.open { opacity: 1; pointer-events: all; }

/* ── Modal Box ── */
.kmodal {
    background: #fff;
    border-radius: 16px;
    width: 100%;
    max-width: 560px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 20px 60px rgba(0,0,0,.18);
    transform: translateY(16px) scale(.98);
    transition: transform .22s cubic-bezier(.34,1.56,.64,1), opacity .2s;
    opacity: 0;
}
.kmodal-overlay.open .kmodal { transform: translateY(0) scale(1); opacity: 1; }
.kmodal.wide { max-width: 720px; }

/* ── Modal Header ── */
.kmodal-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 18px 22px 16px;
    border-bottom: 1px solid #f1f5f9;
    position: sticky; top: 0; background: #fff; z-index: 1;
    border-radius: 16px 16px 0 0;
}
.kmodal-title { font-size: 15px; font-weight: 700; color: #111827; }
.kmodal-close {
    width: 32px; height: 32px; border-radius: 8px; border: none;
    background: #f1f5f9; color: #6b7280; cursor: pointer; font-size: 16px;
    display: flex; align-items: center; justify-content: center;
    transition: background .15s;
}
.kmodal-close:hover { background: #e2e8f0; color: #111827; }

/* ── Modal Body ── */
.kmodal-body { padding: 20px 22px; }

/* ── Modal Footer ── */
.kmodal-footer {
    padding: 14px 22px 18px;
    display: flex; gap: 10px; justify-content: flex-end;
    border-top: 1px solid #f1f5f9;
}
.kbtn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 9px 20px; border-radius: 9px; font-size: 13px; font-weight: 600;
    border: none; cursor: pointer; transition: all .15s;
}
.kbtn-primary { background: #0d6efd; color: #fff; }
.kbtn-primary:hover { background: #0b5ed7; }
.kbtn-primary:disabled { opacity: .6; cursor: not-allowed; }
.kbtn-ghost { background: #f1f5f9; color: #374151; }
.kbtn-ghost:hover { background: #e2e8f0; }

/* ── Toast ── */
.ktoast-wrap {
    position: fixed; top: 20px; right: 20px; z-index: 2000;
    display: flex; flex-direction: column; gap: 8px;
}
.ktoast {
    display: flex; align-items: center; gap: 10px;
    padding: 12px 16px; border-radius: 10px; font-size: 13px; font-weight: 500;
    box-shadow: 0 4px 16px rgba(0,0,0,.12);
    animation: toastIn .25s ease;
    min-width: 260px; max-width: 360px;
}
.ktoast.success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }
.ktoast.error   { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }
@keyframes toastIn { from { opacity:0; transform: translateX(20px); } to { opacity:1; transform: translateX(0); } }

/* ── Form fields inside modal ── */
.kfield { margin-bottom: 16px; }
.kfield label { display: block; font-size: 12px; font-weight: 600; color: #374151; margin-bottom: 6px; letter-spacing: .01em; }
.kfield label .opt { font-weight: 400; color: #9ca3af; font-size: 11px; margin-left: 4px; }
.kinput, .kselect, .ktextarea {
    width: 100%; padding: 9px 13px; font-size: 14px; color: #111827;
    background: #fff; border: 1.5px solid #e5e7eb; border-radius: 9px;
    outline: none; font-family: inherit; transition: border-color .15s, box-shadow .15s;
}
.kinput:focus, .kselect:focus, .ktextarea:focus {
    border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,.1);
}
.kinput.err, .kselect.err, .ktextarea.err { border-color: #ef4444; }
.ktextarea { resize: vertical; min-height: 90px; line-height: 1.6; }
.kselect { appearance: none; cursor: pointer;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236b7280' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right 13px center; padding-right: 36px;
}
.kerror { display: block; font-size: 11px; color: #ef4444; margin-top: 4px; }
.kfield-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
@media (max-width: 480px) { .kfield-row { grid-template-columns: 1fr; } }
.ksection { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em;
    color: #9ca3af; margin: 18px 0 12px; display: flex; align-items: center; gap: 8px; }
.ksection::after { content:''; flex:1; height:1px; background:#f3f4f6; }

/* Status radio pills */
.kstatus-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 8px; }
@media (max-width: 480px) { .kstatus-grid { grid-template-columns: repeat(2,1fr); } }
.kstatus-opt { position: relative; }
.kstatus-opt input { position: absolute; opacity: 0; width: 0; height: 0; }
.kstatus-opt label {
    display: block; text-align: center; padding: 8px 4px;
    background: #f8fafc; border: 1.5px solid #e5e7eb; border-radius: 8px;
    font-size: 12px; color: #6b7280; cursor: pointer; transition: all .15s;
}
.kstatus-opt input:checked + label { background: #111827; border-color: #111827; color: #fff; }
.kstatus-opt label:hover { background: #f1f5f9; border-color: #d1d5db; }

/* Cover preview */
.kcover-wrap { display: flex; align-items: center; gap: 12px; margin-bottom: 10px; }
.kcover-img { width: 64px; height: 88px; object-fit: cover; border-radius: 7px; border: 1.5px solid #e5e7eb; }
.kcover-placeholder { width: 64px; height: 88px; border-radius: 7px; border: 1.5px dashed #d1d5db;
    background: #f9fafb; display: flex; align-items: center; justify-content: center; color: #9ca3af; font-size: 20px; }
.kfile-input { width: 100%; padding: 9px 13px; font-size: 13px; color: #6b7280;
    background: #f9fafb; border: 1.5px dashed #d1d5db; border-radius: 9px; cursor: pointer; }
.kfile-input:hover { border-color: #6366f1; }
</style>

{{-- Toast container --}}
<div class="ktoast-wrap" id="ktoastWrap"></div>

<script>
// ── Toast ──────────────────────────────────────────────────────────────────
function kToast(msg, type = 'success') {
    const wrap = document.getElementById('ktoastWrap');
    const el = document.createElement('div');
    el.className = `ktoast ${type}`;
    el.innerHTML = `<i class="bi bi-${type === 'success' ? 'check-circle-fill' : 'x-circle-fill'}"></i> ${msg}`;
    wrap.appendChild(el);
    setTimeout(() => el.remove(), 3500);
}

// ── Modal open/close ───────────────────────────────────────────────────────
function kOpenModal(id) {
    const ov = document.getElementById(id);
    ov.classList.add('open');
    document.body.style.overflow = 'hidden';
}
function kCloseModal(id) {
    const ov = document.getElementById(id);
    ov.classList.remove('open');
    document.body.style.overflow = '';
    // Reset errors
    ov.querySelectorAll('.kerror').forEach(e => e.textContent = '');
    ov.querySelectorAll('.kinput,.kselect,.ktextarea,.kfile-input').forEach(e => e.classList.remove('err'));
}

// Close on overlay click
document.addEventListener('click', e => {
    if (e.target.classList.contains('kmodal-overlay')) {
        kCloseModal(e.target.id);
    }
});
// Close on Escape
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
        document.querySelectorAll('.kmodal-overlay.open').forEach(ov => kCloseModal(ov.id));
    }
});

// ── AJAX form submit ───────────────────────────────────────────────────────
function kSubmitForm(formId, modalId, onSuccess) {
    const form = document.getElementById(formId);
    const btn  = form.querySelector('[type=submit]');

    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        // Clear previous errors
        form.querySelectorAll('.kerror').forEach(el => el.textContent = '');
        form.querySelectorAll('.kinput,.kselect,.ktextarea,.kfile-input').forEach(el => el.classList.remove('err'));

        btn.disabled = true;
        const origText = btn.innerHTML;
        btn.innerHTML = '<i class="bi bi-arrow-repeat spin"></i> Menyimpan...';

        const fd = new FormData(form);

        try {
            const res = await fetch(form.action, {
                method: form.method.toUpperCase() === 'GET' ? 'POST' : form.method,
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content },
                body: fd,
            });

            const json = await res.json();

            if (!res.ok) {
                // Validation errors
                if (json.errors) {
                    Object.entries(json.errors).forEach(([field, msgs]) => {
                        const input = form.querySelector(`[name="${field}"]`);
                        if (input) input.classList.add('err');
                        const errEl = form.querySelector(`[data-err="${field}"]`);
                        if (errEl) errEl.textContent = msgs[0];
                    });
                } else {
                    kToast(json.message || 'Terjadi kesalahan.', 'error');
                }
            } else {
                kCloseModal(modalId);
                kToast(json.message, 'success');
                if (onSuccess) onSuccess(json.data);
            }
        } catch (err) {
            kToast('Gagal terhubung ke server.', 'error');
        } finally {
            btn.disabled = false;
            btn.innerHTML = origText;
        }
    });
}

// ── AJAX delete ────────────────────────────────────────────────────────────
async function kDelete(url, rowId, confirmMsg) {
    if (!confirm(confirmMsg || 'Yakin ingin menghapus?')) return;

    try {
        const res = await fetch(url, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
            },
        });
        const json = await res.json();

        if (res.ok) {
            const row = document.getElementById(rowId);
            if (row) {
                row.style.transition = 'opacity .3s';
                row.style.opacity = '0';
                setTimeout(() => row.remove(), 300);
            }
            kToast(json.message, 'success');
        } else {
            kToast(json.message || 'Gagal menghapus.', 'error');
        }
    } catch {
        kToast('Gagal terhubung ke server.', 'error');
    }
}
</script>
<style>
@keyframes spin { to { transform: rotate(360deg); } }
.spin { display: inline-block; animation: spin .6s linear infinite; }
</style>
