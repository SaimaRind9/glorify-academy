<x-app-layout>

    <x-slot name="header">
        <div class="notice-page-header">

            <div>
                <h2>Notices</h2>
                <p>Manage academy notices and announcements</p>
            </div>

            <a href="{{ route('notices.create') }}" class="add-btn">
                <i class="fa-solid fa-plus"></i>
                Add Notice
            </a>

        </div>
    </x-slot>


    <div class="notice-page">

        <div class="notice-container">

            @if(session('success'))

                <div class="success-box">
                    <i class="fa-solid fa-circle-check"></i>
                    {{ session('success') }}
                </div>

            @endif


            <div class="notice-card">

                <div class="card-heading">

                    <div>
                        <span class="section-label">ANNOUNCEMENTS</span>
                        <h2>Notice List</h2>
                        <p>View and manage all published notices</p>
                    </div>

                    <span class="record-count">
                        {{ $notices->total() }} Notices
                    </span>

                </div>


                @if($notices->count())

                    <div class="notice-list">

                        @foreach($notices as $notice)

                            <div class="notice-item">

                                <div class="notice-image">

                                    @if($notice->image)

                                        <img
                                            src="{{ asset('storage/' . $notice->image) }}"
                                            alt="{{ $notice->title }}"
                                        >

                                    @else

                                        <div class="notice-placeholder">
                                            <i class="fa-solid fa-bullhorn"></i>
                                        </div>

                                    @endif

                                </div>


                                <div class="notice-content">

                                    <div class="notice-title-row">

                                        <div>
                                            <h3>{{ $notice->title }}</h3>

                                            <p>
                                                {{ \Illuminate\Support\Str::limit(
                                                    $notice->description,
                                                    130
                                                ) }}
                                            </p>
                                        </div>


                                        @if($notice->status)

                                            <span class="status-badge active-status">
                                                Active
                                            </span>

                                        @else

                                            <span class="status-badge inactive-status">
                                                Inactive
                                            </span>

                                        @endif

                                    </div>


                                    <div class="notice-meta">

                                        <span>
                                            <i class="fa-regular fa-calendar"></i>

                                            {{ $notice->publish_date
                                                ? $notice->publish_date->format('d M Y')
                                                : 'No publish date' }}
                                        </span>

                                        <span>
                                            <i class="fa-regular fa-clock"></i>

                                            {{ $notice->created_at->format('d M Y, h:i A') }}
                                        </span>

                                    </div>


                                    <div class="notice-actions">

                                        <a
                                            href="{{ route('notices.show', $notice) }}"
                                            class="action-btn view-btn"
                                        >
                                            <i class="fa-solid fa-eye"></i>
                                            View
                                        </a>


                                        <a
                                            href="{{ route('notices.edit', $notice) }}"
                                            class="action-btn edit-btn"
                                        >
                                            <i class="fa-solid fa-pen-to-square"></i>
                                            Edit
                                        </a>


                                        <form
                                            method="POST"
                                            action="{{ route('notices.destroy', $notice) }}"
                                            onsubmit="return confirm('Delete this notice?')"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="action-btn delete-btn"
                                            >
                                                <i class="fa-solid fa-trash"></i>
                                                Delete
                                            </button>

                                        </form>

                                    </div>

                                </div>

                            </div>

                        @endforeach

                    </div>


                    <div class="pagination-wrapper">
                        {{ $notices->links() }}
                    </div>

                @else

                    <div class="empty-state">

                        <div class="empty-icon">
                            <i class="fa-solid fa-bullhorn"></i>
                        </div>

                        <h3>No Notices Yet</h3>

                        <p>
                            Create your first academy notice with an optional image.
                        </p>

                        <a
                            href="{{ route('notices.create') }}"
                            class="empty-add-btn"
                        >
                            <i class="fa-solid fa-plus"></i>
                            Create Notice
                        </a>

                    </div>

                @endif

            </div>

        </div>

    </div>


    <style>

        :root {
            --notice-bg: #f4f7fb;
            --notice-card: #ffffff;
            --notice-secondary: #f8fafc;
            --notice-text: #0f172a;
            --notice-muted: #64748b;
            --notice-soft: #94a3b8;
            --notice-border: #e2e8f0;
            --notice-primary: #2563eb;
            --notice-shadow:
                0 8px 25px rgba(15, 23, 42, .05);
        }

        html.dark-mode {
            --notice-bg: #090e1a;
            --notice-card: #111827;
            --notice-secondary: #172033;
            --notice-text: #f8fafc;
            --notice-muted: #a7b2c5;
            --notice-soft: #75829a;
            --notice-border: #253047;
            --notice-primary: #60a5fa;
            --notice-shadow:
                0 10px 30px rgba(0, 0, 0, .25);
        }

        body {
            background: var(--notice-bg);
        }

        .notice-page-header {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .notice-page-header h2 {
            margin: 0 0 4px;
            color: var(--notice-text);
            font-size: 21px;
            font-weight: 750;
        }

        .notice-page-header p {
            margin: 0;
            color: var(--notice-muted);
            font-size: 12px;
        }

        .add-btn,
        .empty-add-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;

            padding: 10px 15px;

            border-radius: 11px;

            background: #2563eb;
            color: white;

            text-decoration: none;

            font-size: 11px;
            font-weight: 700;

            transition:
                transform .25s ease,
                box-shadow .25s ease;
        }

        .add-btn:hover,
        .empty-add-btn:hover {
            transform: translateY(-2px);

            box-shadow:
                0 10px 20px rgba(37, 99, 235, .15);
        }

        .notice-page {
            min-height: calc(100vh - 70px);

            padding: 30px 20px 50px;

            background:
                radial-gradient(
                    circle at 10% 10%,
                    rgba(37, 99, 235, .05),
                    transparent 28%
                ),
                var(--notice-bg);
        }

        .notice-container {
            width: 100%;
            max-width: 1200px;
            margin: auto;
        }

        .success-box {
            margin-bottom: 18px;

            padding: 13px 15px;

            border: 1px solid #a7f3d0;
            border-radius: 11px;

            background: #ecfdf5;
            color: #047857;

            display: flex;
            align-items: center;
            gap: 7px;

            font-size: 11px;
        }

        html.dark-mode .success-box {
            border-color: rgba(34, 197, 94, .22);

            background: rgba(34, 197, 94, .10);

            color: #4ade80;
        }

        .notice-card {
            overflow: hidden;

            border: 1px solid var(--notice-border);
            border-radius: 20px;

            background: var(--notice-card);

            box-shadow: var(--notice-shadow);
        }

        .card-heading {
            padding: 21px 23px;

            border-bottom: 1px solid var(--notice-border);

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
        }

        .section-label {
            display: block;

            margin-bottom: 3px;

            color: var(--notice-primary);

            font-size: 8px;
            font-weight: 800;

            letter-spacing: 1.2px;
        }

        .card-heading h2 {
            margin: 0 0 3px;

            color: var(--notice-text);

            font-size: 17px;
            font-weight: 750;
        }

        .card-heading p {
            margin: 0;

            color: var(--notice-soft);

            font-size: 10px;
        }

        .record-count {
            padding: 6px 10px;

            border-radius: 20px;

            background: #dbeafe;
            color: #2563eb;

            font-size: 9px;
            font-weight: 700;

            white-space: nowrap;
        }

        html.dark-mode .record-count {
            background: rgba(37, 99, 235, .15);
            color: #60a5fa;
        }

        .notice-list {
            padding: 18px;
        }

        .notice-item {
            margin-bottom: 14px;

            padding: 15px;

            border: 1px solid var(--notice-border);
            border-radius: 15px;

            background: var(--notice-secondary);

            display: grid;
            grid-template-columns: 160px 1fr;
            gap: 16px;

            transition:
                transform .25s ease,
                box-shadow .25s ease,
                border-color .25s ease;
        }

        .notice-item:last-child {
            margin-bottom: 0;
        }

        .notice-item:hover {
            transform: translateY(-3px);

            border-color: rgba(37, 99, 235, .22);

            box-shadow:
                0 12px 28px rgba(15, 23, 42, .08);
        }

        .notice-image {
            width: 160px;
            height: 110px;

            overflow: hidden;

            border-radius: 12px;

            background: var(--notice-card);
        }

        .notice-image img {
            width: 100%;
            height: 100%;

            object-fit: cover;
        }

        .notice-placeholder {
            width: 100%;
            height: 100%;

            display: flex;
            align-items: center;
            justify-content: center;

            background:
                linear-gradient(
                    135deg,
                    #dbeafe,
                    #eff6ff
                );

            color: #2563eb;

            font-size: 26px;
        }

        html.dark-mode .notice-placeholder {
            background:
                linear-gradient(
                    135deg,
                    rgba(37, 99, 235, .18),
                    rgba(37, 99, 235, .08)
                );

            color: #60a5fa;
        }

        .notice-content {
            min-width: 0;
        }

        .notice-title-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;

            gap: 15px;
        }

        .notice-title-row h3 {
            margin: 0 0 5px;

            color: var(--notice-text);

            font-size: 14px;
            font-weight: 750;
        }

        .notice-title-row p {
            margin: 0;

            color: var(--notice-muted);

            font-size: 10px;
            line-height: 1.6;
        }

        .status-badge {
            padding: 5px 9px;

            border-radius: 20px;

            font-size: 8px;
            font-weight: 750;

            white-space: nowrap;
        }

        .active-status {
            background: #dcfce7;
            color: #15803d;
        }

        .inactive-status {
            background: #fee2e2;
            color: #b91c1c;
        }

        html.dark-mode .active-status {
            background: rgba(34, 197, 94, .14);
            color: #4ade80;
        }

        html.dark-mode .inactive-status {
            background: rgba(239, 68, 68, .14);
            color: #f87171;
        }

        .notice-meta {
            margin-top: 12px;

            display: flex;
            flex-wrap: wrap;

            gap: 12px;

            color: var(--notice-soft);

            font-size: 9px;
        }

        .notice-meta span {
            display: inline-flex;
            align-items: center;

            gap: 5px;
        }

        .notice-actions {
            margin-top: 14px;

            display: flex;
            flex-wrap: wrap;

            gap: 7px;
        }

        .action-btn {
            min-height: 33px;

            padding: 0 11px;

            border: none;
            border-radius: 9px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 5px;

            text-decoration: none;

            font-size: 9px;
            font-weight: 700;

            cursor: pointer;
        }

        .view-btn {
            background: #dbeafe;
            color: #2563eb;
        }

        .edit-btn {
            background: #ffedd5;
            color: #c2410c;
        }

        .delete-btn {
            background: #fee2e2;
            color: #b91c1c;
        }

        html.dark-mode .view-btn {
            background: rgba(37, 99, 235, .15);
            color: #60a5fa;
        }

        html.dark-mode .edit-btn {
            background: rgba(249, 115, 22, .14);
            color: #fb923c;
        }

        html.dark-mode .delete-btn {
            background: rgba(239, 68, 68, .14);
            color: #f87171;
        }

        .pagination-wrapper {
            padding: 17px 22px;

            border-top: 1px solid var(--notice-border);
        }

        .empty-state {
            padding: 65px 20px;

            text-align: center;
        }

        .empty-icon {
            width: 68px;
            height: 68px;

            margin: 0 auto 13px;

            border-radius: 19px;

            background: var(--notice-secondary);
            color: var(--notice-primary);

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 25px;
        }

        .empty-state h3 {
            margin: 0 0 6px;

            color: var(--notice-text);

            font-size: 16px;
        }

        .empty-state p {
            margin: 0 0 14px;

            color: var(--notice-muted);

            font-size: 11px;
        }

        @media (max-width: 700px) {

            .notice-page-header {
                flex-direction: column;
                align-items: stretch;
            }

            .add-btn {
                width: 100%;
            }

            .notice-page {
                padding: 20px 12px 35px;
            }

            .card-heading {
                align-items: flex-start;
                padding: 18px;
            }

            .notice-list {
                padding: 12px;
            }

            .notice-item {
                grid-template-columns: 1fr;
            }

            .notice-image {
                width: 100%;
                height: 190px;
            }

            .notice-title-row {
                flex-direction: column;
            }

            .notice-actions,
            .notice-actions form,
            .action-btn {
                width: 100%;
            }

        }

    </style>

</x-app-layout>