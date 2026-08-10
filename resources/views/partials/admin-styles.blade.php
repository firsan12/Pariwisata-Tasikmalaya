<style>

    :root {
        --primary: #0d3b7a;
        --primary-dark: #082b5c;
        --blue: #2563eb;
        --green: #16a34a;
        --orange: #ea580c;
        --purple: #7c3aed;
        --pink: #db2777;
        --red: #dc2626;
        --text: #172033;
        --muted: #64748b;
        --border: #e8edf4;
        --bg: #f5f7fb;
    }

    /* HEADER */

    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        flex-wrap: wrap;
    }

    .page-header h2 {
        margin: 7px 0 3px;
        font-size: 25px;
        font-weight: 800;
        color: var(--text);
    }

    .page-header p {
        margin: 0;
        color: var(--muted);
        font-size: 14px;
    }

    .page-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 6px 11px;
        border-radius: 30px;
        background: #e9f1ff;
        color: var(--primary);
        font-size: 12px;
        font-weight: 700;
    }

    .btn-add,
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 17px;
        border-radius: 10px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 700;
        transition: .2s ease;
        border: none;
        cursor: pointer;
    }

    .btn-add {
        color: white;
        background: var(--primary);
    }

    .btn-add:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
    }

    .btn-back {
        color: var(--text);
        background: white;
        border: 1px solid var(--border);
    }

    .btn-back:hover {
        border-color: #cbd8eb;
    }


    /* WRAPPER */

    .page-wrapper {
        background: var(--bg);
        min-height: calc(100vh - 80px);
        padding: 30px 20px 50px;
        max-width: 1280px;
        margin: 0 auto;
    }

    .alert-success {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 13px 17px;
        margin-bottom: 20px;
        background: #eaf9ef;
        border: 1px solid #c8ecd4;
        color: #15803d;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 600;
    }


    /* EMPTY STATE */

    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 8px;
        padding: 60px 20px;
        color: var(--muted);
    }

    .empty-state i {
        font-size: 40px;
        color: #cbd5e1;
        margin-bottom: 6px;
    }

    .empty-state h4 {
        margin: 0;
        color: var(--text);
        font-size: 15px;
        font-weight: 700;
    }

    .empty-state p {
        margin: 0 0 10px;
        font-size: 13px;
    }


    /* GALLERY GRID */

    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
    }

    .gallery-card {
        background: white;
        border: 1px solid var(--border);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 6px 20px rgba(15,23,42,.035);
        transition: .2s ease;
    }

    .gallery-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 25px rgba(15,23,42,.08);
    }

    .gallery-image {
        position: relative;
        height: 160px;
        background: linear-gradient(135deg,#dcecff,#edf4ff);
    }

    .gallery-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .gallery-actions {
        position: absolute;
        top: 8px;
        right: 8px;
        display: flex;
        gap: 6px;
        opacity: 0;
        transition: .2s ease;
    }

    .gallery-card:hover .gallery-actions {
        opacity: 1;
    }

    .gallery-btn {
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background: white;
        color: var(--primary);
        border: none;
        cursor: pointer;
        font-size: 12px;
        text-decoration: none;
        box-shadow: 0 3px 8px rgba(0,0,0,.15);
    }

    .gallery-btn.danger {
        color: var(--red);
    }

    .gallery-info {
        padding: 13px 15px;
    }

    .gallery-info h4 {
        margin: 0 0 4px;
        font-size: 13px;
        font-weight: 750;
        color: var(--text);
    }

    .gallery-info span {
        display: flex;
        align-items: center;
        gap: 4px;
        color: var(--muted);
        font-size: 11px;
        margin-bottom: 4px;
    }

    .gallery-info p {
        margin: 0;
        color: var(--muted);
        font-size: 11px;
        line-height: 1.5;
    }


    /* TABLE */

    .table-panel {
        background: white;
        border: 1px solid var(--border);
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 6px 20px rgba(15,23,42,.035);
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table thead {
        background: #f7f9fc;
    }

    .data-table th {
        text-align: left;
        padding: 14px 18px;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .5px;
        color: var(--muted);
        text-transform: uppercase;
        border-bottom: 1px solid var(--border);
    }

    .data-table td {
        padding: 14px 18px;
        font-size: 13px;
        color: var(--text);
        border-bottom: 1px solid #f0f2f6;
        vertical-align: middle;
    }

    .data-table tbody tr:last-child td {
        border-bottom: none;
    }

    .data-table tbody tr:hover {
        background: #fafbfd;
    }

    .text-right {
        text-align: right;
    }

    .table-sub {
        margin: 3px 0 0;
        color: var(--muted);
        font-size: 11px;
    }

    .table-thumb {
        width: 52px;
        height: 44px;
        border-radius: 9px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg,#dcecff,#edf4ff);
        color: #7a9ac5;
        font-size: 16px;
    }

    .table-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .table-actions {
        display: inline-flex;
        gap: 6px;
    }

    .table-btn {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background: #f1f5f9;
        color: var(--primary);
        border: none;
        cursor: pointer;
        font-size: 12px;
        text-decoration: none;
    }

    .table-btn:hover {
        background: #e2e8f0;
    }

    .table-btn.danger {
        color: var(--red);
    }

    .rating-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 9px;
        border-radius: 20px;
        background: #fff7e6;
        color: #b45309;
        font-size: 11px;
        font-weight: 700;
    }


    /* FORM */

    .form-panel {
        max-width: 640px;
        margin: 0 auto;
        background: white;
        border: 1px solid var(--border);
        border-radius: 18px;
        padding: 28px;
        box-shadow: 0 6px 20px rgba(15,23,42,.035);
    }

    .current-image {
        margin-bottom: 20px;
        border-radius: 12px;
        overflow: hidden;
        max-height: 220px;
    }

    .current-image img {
        width: 100%;
        height: 220px;
        object-fit: cover;
        display: block;
    }

    .form-group {
        margin-bottom: 18px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .form-group label {
        display: block;
        margin-bottom: 6px;
        font-size: 13px;
        font-weight: 700;
        color: var(--text);
    }

    .form-group input[type="text"],
    .form-group input[type="number"],
    .form-group input[type="file"],
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 10px 13px;
        border: 1px solid var(--border);
        border-radius: 10px;
        font-size: 13px;
        color: var(--text);
        background: white;
        box-sizing: border-box;
    }

    .form-group textarea {
        resize: vertical;
        font-family: inherit;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: var(--primary);
    }

    .form-group small {
        display: block;
        margin-top: 5px;
        color: var(--muted);
        font-size: 11px;
    }

    .form-error {
        display: block;
        margin-top: 5px;
        color: var(--red);
        font-size: 11px;
        font-weight: 600;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 24px;
        padding-top: 20px;
        border-top: 1px solid var(--border);
    }

    .btn-cancel {
        padding: 11px 18px;
        border-radius: 10px;
        background: #f1f5f9;
        color: var(--text);
        text-decoration: none;
        font-size: 13px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
    }

    .btn-submit {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 18px;
        border-radius: 10px;
        background: var(--primary);
        color: white;
        border: none;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
    }

    .btn-submit:hover {
        background: var(--primary-dark);
    }

    .pagination-wrapper {
        margin-top: 22px;
    }


    /* RESPONSIVE */

    @media (max-width: 1000px) {
        .gallery-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 640px) {
        .gallery-grid {
            grid-template-columns: 1fr;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .form-panel {
            padding: 20px;
        }

        .page-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .data-table {
            font-size: 12px;
        }

        .data-table th,
        .data-table td {
            padding: 10px 12px;
        }
    }

</style>