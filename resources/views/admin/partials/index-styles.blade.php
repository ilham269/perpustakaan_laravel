<style>
/* ── Toolbar ── */
.idx-toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    flex-wrap: wrap;
    gap: 12px;
}
.idx-count {
    font-size: 13px;
    color: #6b7280;
}
.idx-btn-add {
    display: inline-flex;
    align-items: center;
    background: #0d6efd;
    color: #fff !important;
    font-size: 13px;
    font-weight: 500;
    padding: 8px 18px;
    border-radius: 8px;
    text-decoration: none;
    transition: background .15s, transform .1s;
    white-space: nowrap;
}
.idx-btn-add:hover { background: #0b5ed7; transform: translateY(-1px); }

/* ── Card ── */
.idx-card {
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 1px 4px rgba(0,0,0,.06), 0 4px 16px rgba(0,0,0,.04);
    overflow: hidden;
}

/* ── Table ── */
.idx-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}
.idx-table thead tr {
    background: #f8fafc;
    border-bottom: 2px solid #e5e7eb;
}
.idx-table thead th {
    padding: 13px 16px;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .06em;
    color: #6b7280;
    white-space: nowrap;
}
.idx-table tbody tr {
    border-bottom: 1px solid #f1f5f9;
    transition: background .1s;
}
.idx-table tbody tr:last-child { border-bottom: none; }
.idx-table tbody tr:hover { background: #f8fafc; }
.idx-table tbody td {
    padding: 13px 16px;
    vertical-align: middle;
    color: #374151;
}

/* ── Cover image ── */
.idx-cover {
    width: 48px;
    height: 64px;
    object-fit: cover;
    border-radius: 6px;
    border: 1px solid #e5e7eb;
}

/* ── Badges ── */
.idx-badge {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    white-space: nowrap;
}
.badge-success     { background: #dcfce7; color: #166534; }
.badge-danger      { background: #fee2e2; color: #991b1b; }
.badge-warning     { background: #fef9c3; color: #854d0e; }
.badge-info        { background: #dbeafe; color: #1e40af; }
.badge-secondary   { background: #f1f5f9; color: #475569; }
.badge-pending     { background: #fef9c3; color: #854d0e; }
.badge-disetujui   { background: #dcfce7; color: #166534; }
.badge-ditolak     { background: #fee2e2; color: #991b1b; }
.badge-dikembalikan{ background: #dbeafe; color: #1e40af; }

/* ── Action buttons ── */
.idx-actions { display: flex; align-items: center; gap: 6px; }
.ia-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    font-size: 14px;
    text-decoration: none;
    transition: background .15s, transform .1s;
    background: transparent;
}
.ia-btn:hover { transform: translateY(-1px); }
.ia-view  { color: #0d6efd; background: #eff6ff; }
.ia-view:hover  { background: #dbeafe; }
.ia-edit  { color: #d97706; background: #fffbeb; }
.ia-edit:hover  { background: #fef3c7; }
.ia-del   { color: #dc2626; background: #fef2f2; }
.ia-del:hover   { background: #fee2e2; }
.ia-pay   { color: #059669; background: #ecfdf5; }
.ia-pay:hover   { background: #d1fae5; }

/* ── Empty state ── */
.idx-empty {
    text-align: center;
    padding: 3rem 1rem;
    color: #9ca3af;
    font-size: 14px;
}

/* ── Pagination ── */
.idx-pagination {
    padding: 14px 16px;
    border-top: 1px solid #f1f5f9;
}

/* ── Flash ── */
.idx-alert {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 16px;
    border-radius: 10px;
    font-size: 14px;
    margin-bottom: 20px;
}
.idx-alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }
.idx-alert-error   { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }
</style>
