<style>
    :root {
        --brand-green: #22c55e;
        --brand-cyan: #22d3ee;
        --brand-dark: #173d2b;
        --brand-teal: #0e9da8;
        --brand-glow: rgba(34, 197, 94, 0.18);
        --brand-light: #edfff4;
        --cyan-light: #e0feff;
        --ink: #173d2b;
        --ink-soft: #2d5a42;
        --ink-muted: #5c7c6b;
        --surface: #f8faf8;
        --surface-card: #ffffff;
        --accent: var(--brand-green);
        --accent-secondary: var(--brand-cyan);
        --accent-light: var(--brand-light);
        --accent-glow: var(--brand-glow);
        --border: #d9e9de;
        --border-focus: var(--brand-green);
        --success: var(--brand-green);
        --danger: #ef4444;
        --radius: 14px;
        --radius-sm: 8px;
        --shadow-card: 0 2px 12px rgba(34, 197, 94, 0.08), 0 1px 3px rgba(23, 61, 43, 0.1);
        --shadow-hover: 0 8px 32px rgba(34, 197, 94, 0.15), 0 2px 8px rgba(23, 61, 43, 0.12);
        --transition: 0.22s cubic-bezier(.4, 0, .2, 1);
    }

    body {
        background: var(--surface);
        color: var(--ink);
    }

    /* Custom animations and overrides that can't be done with Bootstrap */
    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(18px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-8px) scale(0.98);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .animate-fade-up {
        animation: fadeUp 0.5s both;
    }

    .animate-slide-in {
        animation: slideIn 0.25s cubic-bezier(.4, 0, .2, 1);
    }

    /* Custom card styling with Bootstrap overrides */
    .card {
        border-color: var(--border);
        box-shadow: var(--shadow-card);
        transition: box-shadow var(--transition);
        border-radius: var(--radius);
        overflow: hidden;
    }

    .card:hover {
        box-shadow: var(--shadow-hover);
    }

    .card-header {
        background: linear-gradient(135deg, #f8fbf8 0%, #f0f7f0 100%);
        border-bottom: 1px solid var(--border);
        padding: 1rem 1.5rem;
    }

    .card-header h6 {
        font-family: 'Syne', sans-serif;
        font-size: 0.88rem;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: var(--ink-soft);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 9px;
    }

    .card-header h6::before {
        content: '';
        display: block;
        width: 3px;
        height: 14px;
        border-radius: 2px;
        background: var(--brand-green);
    }

    /* Form controls with Bootstrap overrides */
    .form-label {
        font-size: 0.8rem;
        font-weight: 600;
        letter-spacing: 0.04em;
        color: var(--ink-soft);
        margin-bottom: 0.25rem;
        text-transform: uppercase;
    }

    .form-control,
    .form-select {
        border: 1.5px solid var(--border);
        border-radius: var(--radius-sm);
        font-family: 'DM Sans', sans-serif;
        font-size: 0.93rem;
        color: var(--ink);
        transition: var(--transition);
        background-color: var(--surface);
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--brand-green);
        background-color: #fff;
        box-shadow: 0 0 0 3px var(--brand-glow);
    }

    .form-control::placeholder {
        color: var(--ink-muted);
    }

    .form-text {
        color: var(--ink-muted);
        font-size: 0.76rem;
        margin-top: 0.25rem;
    }

    /* Buttons */
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 0.5rem 1.25rem;
        background: var(--surface-card);
        border: 1px solid var(--border);
        border-radius: 50px;
        color: var(--ink-soft);
        font-family: 'DM Sans', sans-serif;
        font-size: 0.85rem;
        font-weight: 500;
        text-decoration: none;
        transition: var(--transition);
    }

    .btn-back:hover {
        border-color: var(--brand-green);
        color: var(--brand-green);
        box-shadow: var(--shadow-hover);
        transform: translateX(-3px);
        background: var(--surface-card);
    }

    .btn-add {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0.4rem 1rem;
        background: var(--brand-light);
        color: var(--brand-green);
        border: 1.5px solid transparent;
        border-radius: 50px;
        font-size: 0.82rem;
        font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        transition: var(--transition);
        letter-spacing: 0.02em;
    }

    .btn-add:hover {
        background: var(--brand-green);
        color: #fff;
        box-shadow: 0 4px 16px var(--brand-glow);
        transform: translateY(-1px);
    }

    .btn-remove {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        background: #fef2f2;
        color: var(--danger);
        border: 1.5px solid #fecaca;
        border-radius: 50%;
        font-size: 0.95rem;
        cursor: pointer;
        transition: var(--transition);
        padding: 0;
    }

    .btn-remove:hover {
        background: var(--danger);
        color: #fff;
        border-color: var(--danger);
        transform: rotate(10deg) scale(1.1);
    }

    .btn-remove-lg {
        width: auto;
        border-radius: 50px;
        padding: 0.5rem 1rem;
        gap: 6px;
    }

    .btn-save {
        width: 100%;
        padding: 0.875rem;
        background: linear-gradient(135deg, var(--brand-green) 0%, var(--brand-teal) 100%);
        color: #fff;
        border: none;
        border-radius: var(--radius-sm);
        font-family: 'Syne', sans-serif;
        font-size: 1rem;
        font-weight: 700;
        letter-spacing: 0.04em;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: 0 4px 20px rgba(34, 197, 94, 0.35);
    }

    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 32px rgba(34, 197, 94, 0.45);
    }

    /* Repeater cards */
    .repeater-card {
        background: linear-gradient(135deg, #f8fbf8 0%, #f0f7f0 100%);
        border: 1.5px solid var(--border);
        border-radius: var(--radius-sm);
        padding: 1.25rem;
        margin-bottom: 0.75rem;
        position: relative;
        transition: var(--transition);
    }

    .repeater-card:hover {
        border-color: var(--brand-green);
        box-shadow: 0 2px 12px var(--brand-glow);
    }

    .empty-state {
        text-align: center;
        padding: 2rem 1.25rem;
        color: var(--ink-muted);
        font-size: 0.88rem;
        border: 1.5px dashed var(--border);
        border-radius: var(--radius-sm);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
    }

    .empty-state i {
        font-size: 2rem;
        opacity: 0.35;
        color: var(--brand-green);
    }

    /* Step badge */
    .step-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        background: var(--brand-green);
        color: #fff;
        border-radius: 50%;
        font-size: 0.85rem;
        font-weight: 700;
        font-family: 'Syne', sans-serif;
        flex-shrink: 0;
    }

    /* Publish accent */
    .publish-accent {
        height: 4px;
        background: linear-gradient(90deg, var(--brand-green), var(--brand-cyan), var(--brand-teal));
    }

    /* SEO section */
    .seo-section {
        background: #f0faf4;
        border-radius: var(--radius-sm);
        padding: 1.25rem;
        border: 1px solid var(--border);
    }

    /* File input */
    .file-input-wrapper input[type="file"]::file-selector-button {
        padding: 0.25rem 0.75rem;
        background: var(--brand-light);
        color: var(--brand-green);
        border: 1.5px solid var(--brand-green);
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        margin-right: 0.75rem;
        font-family: 'DM Sans', sans-serif;
    }

    .file-input-wrapper input[type="file"]::file-selector-button:hover {
        background: var(--brand-green);
        color: #fff;
    }

    /* Select2 overrides with brand colors */
    .select2-container--default .select2-selection--single {
        background: var(--surface) !important;
        border: 1.5px solid var(--border) !important;
        border-radius: var(--radius-sm) !important;
        height: 42px !important;
        display: flex !important;
        align-items: center !important;
        padding: 0 0.75rem !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: var(--ink) !important;
        font-family: 'DM Sans', sans-serif !important;
        font-size: 0.93rem !important;
        line-height: 42px !important;
        padding: 0 !important;
    }

    .select2-container--default.select2-container--focus .select2-selection--single {
        border-color: var(--brand-green) !important;
        box-shadow: 0 0 0 3px var(--brand-glow) !important;
    }

    /* Page header */
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 0 1rem;
        position: relative;
        margin-bottom: 0.2rem;
    }

    .page-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, var(--brand-green) 0%, transparent 60%);
        opacity: 0.3;
    }

    .page-header h2 {
        font-family: 'Syne', sans-serif;
        font-size: 1.7rem;
        font-weight: 800;
        margin: 0 0 0.125rem;
        letter-spacing: -0.03em;
        background: linear-gradient(135deg, var(--ink) 40%, var(--brand-green));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start;
        }
    }

    .custom-select {
        border: 1px solid #dce3dd;
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 14px;
        transition: all 0.2s ease;
        background-color: #f9fbf9;
    }

    .custom-select:focus {
        border-color: #2e7d32;
        box-shadow: 0 0 0 3px rgba(46, 125, 50, 0.1);
        background-color: #ffffff;
    }

    .custom-select option {
        padding: 10px;
    }

    .custom-select:hover {
        border-color: #81c784;
    }
</style>