<style>
/* ── Back link ── */
.show-back {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 13px; color: #6b7280; text-decoration: none;
    padding: 7px 14px; border: 1px solid #e5e7eb; border-radius: 8px;
    background: #fff; transition: all .15s; margin-bottom: 20px;
}
.show-back:hover { background: #f8fafc; color: #111827; }

/* ── Main card ── */
.show-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 1px 4px rgba(0,0,0,.05), 0 4px 16px rgba(0,0,0,.04);
    overflow: hidden;
    margin-bottom: 20px;
}
.show-card-head {
    padding: 18px 22px;
    border-bottom: 1px solid #f1f5f9;
    display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap;
}
.show-card-title { font-size: 16px; font-weight: 700; color: #111827; }
.show-card-sub   { font-size: 13px; color: #6b7280; margin-top: 2px; }
.show-card-body  { padding: 0; }
.show-card-foot  {
    padding: 14px 22px;
    border-top: 1px solid #f1f5f9;
    display: flex; gap: 8px; align-items: center;
}

/* ── Info rows ── */
.info-row {
    display: flex; align-items: baseline;
    padding: 13px 22px;
    border-bottom: 1px solid #f8fafc;
    font-size: 14px;
}
.info-row:last-child { border-bottom: none; }
.info-label { width: 160px; flex-shrink: 0; font-size: 12px; font-weight: 600; color: #9ca3af; text-transform: uppercase; letter-spacing: .05em; }
.info-value { color: #111827; font-weight: 500; }
.info-value.muted { color: #6b7280; font-weight: 400; }

/* ── Cover image ── */
.show-cover {
    width: 90px; height: 124px; object-fit: cover;
    border-radius: 10px; border: 1.5px solid #e5e7eb; flex-shrink: 0;
}
.show-cover-placeholder {
    width: 90px; height: 124px; border-radius: 10px;
    border: 1.5px dashed #d1d5db; background: #f9fafb;
    display: flex; align-items: center; justify-content: center;
    color: #9ca3af; font-size: 28px; flex-shrink: 0;
}

/* ── Badges ── */
.show-badge {
    display: inline-block; padding: 4px 12px; border-radius: 20px;
    font-size: 12px; font-weight: 600;
}
.sb-success     { background: #dcfce7; color: #166534; }
.sb-danger      { background: #fee2e2; color: #991b1b; }
.sb-warning     { background: #fef9c3; color: #854d0e; }
.sb-info        { background: #dbeafe; color: #1e40af; }
.sb-secondary   { background: #f1f5f9; color: #475569; }
.sb-pending     { background: #fef9c3; color: #854d0e; }
.sb-disetujui   { background: #dcfce7; color: #166534; }
.sb-ditolak     { background: #fee2e2; color: #991b1b; }
.sb-dikembalikan{ background: #dbeafe; color: #1e40af; }

/* ── Action buttons ── */
.sa-btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600;
    border: none; cursor: pointer; text-decoration: none; transition: all .15s;
}
.sa-edit   { background: #fffbeb; color: #d97706; border: 1px solid #fde68a; }
.sa-edit:hover   { background: #fef3c7; }
.sa-del    { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
.sa-del:hover    { background: #fee2e2; }
.sa-pay    { background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; }
.sa-pay:hover    { background: #d1fae5; }

/* ── Sub table ── */
.sub-table-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 1px 4px rgba(0,0,0,.05), 0 4px 16px rgba(0,0,0,.04);
    overflow: hidden;
    margin-bottom: 20px;
}
.sub-table-head {
    padding: 16px 22px;
    border-bottom: 1px solid #f1f5f9;
    font-size: 14px; font-weight: 700; color: #111827;
}
.sub-table { width: 100%; border-collapse: collapse; font-size: 13px; }
.sub-table thead tr { background: #f8fafc; border-bottom: 1px solid #e5e7eb; }
.sub-table thead th { padding: 10px 16px; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: .05em; color: #6b7280; }
.sub-table tbody tr { border-bottom: 1px solid #f1f5f9; transition: background .1s; }
.sub-table tbody tr:last-child { border-bottom: none; }
.sub-table tbody tr:hover { background: #f8fafc; }
.sub-table tbody td { padding: 12px 16px; vertical-align: middle; color: #374151; }
.sub-empty { text-align: center; padding: 2.5rem 1rem; color: #9ca3af; font-size: 13px; }

/* ── Denda highlight card ── */
.denda-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 1px 4px rgba(0,0,0,.05), 0 4px 16px rgba(0,0,0,.04);
    border-left: 4px solid #ef4444;
    overflow: hidden;
    margin-bottom: 20px;
}
.denda-card.lunas { border-left-color: #22c55e; }
.denda-card-body  { padding: 20px 22px; display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap; }
.denda-amount     { font-size: 28px; font-weight: 800; color: #dc2626; line-height: 1; }
.denda-card.lunas .denda-amount { color: #16a34a; }
.denda-meta       { font-size: 12px; color: #6b7280; margin-top: 4px; }
.denda-label      { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: #9ca3af; margin-bottom: 6px; }
</style>
