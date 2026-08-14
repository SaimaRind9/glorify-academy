<x-app-layout>

    <x-slot name="header">
        <div class="notice-show-header">

            <div>
                <h2>Notice Details</h2>
                <p>View complete announcement information</p>
            </div>

            <div class="header-actions">

                <a href="{{ route('notices.index') }}" class="back-btn">
                    <i class="fa-solid fa-arrow-left"></i>
                    Back
                </a>

                <a href="{{ route('notices.edit', $notice) }}" class="edit-btn">
                    <i class="fa-solid fa-pen-to-square"></i>
                    Edit Notice
                </a>

            </div>

        </div>
    </x-slot>


    <div class="notice-show-page">

        <div class="notice-show-container">

            <div class="notice-show-card">


                {{-- Image --}}
                <div class="notice-image-wrapper">

                    @if($notice->image)

                       <img
    src="{{ asset('storage/' . $notice->image) }}"
    alt="{{ $notice->title }}"
    class="notice-main-image"
    onclick="openNoticeImage(this.src)"
    title="Click to view full image"
>

                    @else

                        <div class="notice-image-placeholder">

                            <i class="fa-solid fa-bullhorn"></i>

                            <span>
                                No Image Available
                            </span>

                        </div>

                    @endif

                </div>


                {{-- Content --}}
                <div class="notice-content">

                    <div class="notice-top">

                        <div>

                            <span class="section-label">
                                ANNOUNCEMENT
                            </span>

                            <h1>
                                {{ $notice->title }}
                            </h1>

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

                        <div>

                            <i class="fa-regular fa-calendar"></i>

                            <span>
                                Publish Date
                            </span>

                            <strong>
                                {{ $notice->publish_date
                                    ? $notice->publish_date->format('d M Y')
                                    : 'Not Set' }}
                            </strong>

                        </div>


                        <div>

                            <i class="fa-regular fa-clock"></i>

                            <span>
                                Created
                            </span>

                            <strong>
                                {{ $notice->created_at->format('d M Y, h:i A') }}
                            </strong>

                        </div>


                        <div>

                            <i class="fa-solid fa-pen"></i>

                            <span>
                                Last Updated
                            </span>

                            <strong>
                                {{ $notice->updated_at->format('d M Y, h:i A') }}
                            </strong>

                        </div>

                    </div>


                    <div class="description-section">

                        <h3>
                            <i class="fa-solid fa-align-left"></i>
                            Description
                        </h3>

                        <div class="description-box">

                            @if($notice->description)

                                {!! nl2br(e($notice->description)) !!}

                            @else

                                <span class="no-description">
                                    No description was provided for this notice.
                                </span>

                            @endif

                        </div>

                    </div>


                    <div class="notice-footer">

                        <a
                            href="{{ route('notices.edit', $notice) }}"
                            class="footer-edit-btn"
                        >
                            <i class="fa-solid fa-pen-to-square"></i>
                            Edit Notice
                        </a>


                        <form
                            method="POST"
                            action="{{ route('notices.destroy', $notice) }}"
                            onsubmit="return confirm('Are you sure you want to delete this notice?')"
                        >

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="delete-btn"
                            >
                                <i class="fa-solid fa-trash"></i>
                                Delete Notice
                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

<div id="noticeImageModal" class="image-modal">

    <button
        type="button"
        class="image-modal-close"
        onclick="closeNoticeImage()"
    >
        <i class="fa-solid fa-xmark"></i>
    </button>

    <img
        id="noticeFullImage"
        src=""
        alt="Notice Image"
    >

</div>
    <style>

        :root {
            --show-bg: #f4f7fb;
            --show-card: #ffffff;
            --show-secondary: #f8fafc;
            --show-text: #0f172a;
            --show-muted: #64748b;
            --show-soft: #94a3b8;
            --show-border: #e2e8f0;
            --show-primary: #2563eb;
            --show-shadow:
                0 10px 30px rgba(15, 23, 42, .06);
        }

        html.dark-mode {
            --show-bg: #090e1a;
            --show-card: #111827;
            --show-secondary: #172033;
            --show-text: #f8fafc;
            --show-muted: #a7b2c5;
            --show-soft: #75829a;
            --show-border: #253047;
            --show-primary: #60a5fa;
            --show-shadow:
                0 12px 35px rgba(0, 0, 0, .28);
        }

        body {
            background: var(--show-bg);
        }

        .notice-show-header {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .notice-show-header h2 {
            margin: 0 0 4px;
            color: var(--show-text);
            font-size: 21px;
            font-weight: 750;
        }

        .notice-show-header p {
            margin: 0;
            color: var(--show-muted);
            font-size: 12px;
        }

        .header-actions {
            display: flex;
            gap: 9px;
        }

        .back-btn,
        .edit-btn {
            padding: 10px 15px;

            border-radius: 11px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 7px;

            text-decoration: none;

            font-size: 11px;
            font-weight: 700;

            transition:
                transform .25s ease,
                box-shadow .25s ease;
        }

        .back-btn {
            background: var(--show-secondary);
            color: var(--show-muted);
        }

        .edit-btn {
            background: #2563eb;
            color: white;
        }

        .back-btn:hover,
        .edit-btn:hover {
            transform: translateY(-2px);
        }

        .notice-show-page {
            min-height: calc(100vh - 70px);

            padding: 30px 20px 50px;

            background:
                radial-gradient(
                    circle at 10% 10%,
                    rgba(37, 99, 235, .05),
                    transparent 28%
                ),
                var(--show-bg);
        }

        .notice-show-container {
            width: 100%;
            max-width: 1050px;

            margin: auto;
        }

        .notice-show-card {
            overflow: hidden;

            border: 1px solid var(--show-border);
            border-radius: 20px;

            background: var(--show-card);

            box-shadow: var(--show-shadow);
        }

        .notice-image-wrapper {
            width: 100%;
            max-height: 430px;

            overflow: hidden;

            background: var(--show-secondary);
        }

       .notice-main-image {
    width: 100%;
    max-height: 500px;
    object-fit: contain;
    display: block;
    margin: auto;
    cursor: zoom-in;
    background: var(--show-secondary);
}

        .notice-image-placeholder {
            height: 300px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex-direction: column;

            gap: 10px;

            background:
                linear-gradient(
                    135deg,
                    #dbeafe,
                    #eff6ff
                );

            color: #2563eb;
        }

        .notice-image-placeholder i {
            font-size: 42px;
        }

        .notice-image-placeholder span {
            font-size: 11px;
            font-weight: 700;
        }

        html.dark-mode .notice-image-placeholder {
            background:
                linear-gradient(
                    135deg,
                    rgba(37, 99, 235, .18),
                    rgba(37, 99, 235, .08)
                );

            color: #60a5fa;
        }

        .notice-content {
            padding: 27px;
        }

        .notice-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;

            gap: 20px;

            margin-bottom: 20px;
        }

        .section-label {
            display: block;

            margin-bottom: 4px;

            color: var(--show-primary);

            font-size: 8px;
            font-weight: 800;

            letter-spacing: 1.3px;
        }

        .notice-top h1 {
            margin: 0;

            color: var(--show-text);

            font-size: 26px;
            font-weight: 800;

            line-height: 1.3;
        }

        .status-badge {
            padding: 6px 11px;

            border-radius: 20px;

            font-size: 9px;
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
            margin-bottom: 24px;

            padding: 15px;

            border-radius: 13px;

            background: var(--show-secondary);

            display: grid;

            grid-template-columns:
                repeat(3, minmax(0, 1fr));

            gap: 12px;
        }

        .notice-meta > div {
            display: grid;

            grid-template-columns:
                auto 1fr;

            column-gap: 8px;
            row-gap: 2px;
        }

        .notice-meta i {
            grid-row: 1 / span 2;

            margin-top: 3px;

            color: var(--show-primary);
        }

        .notice-meta span {
            color: var(--show-soft);

            font-size: 8px;
        }

        .notice-meta strong {
            color: var(--show-text);

            font-size: 9px;
            font-weight: 700;
        }

        .description-section h3 {
            margin: 0 0 9px;

            color: var(--show-text);

            display: flex;
            align-items: center;

            gap: 7px;

            font-size: 13px;
            font-weight: 750;
        }

        .description-section h3 i {
            color: var(--show-primary);
        }

        .description-box {
            min-height: 150px;

            padding: 18px;

            border: 1px solid var(--show-border);
            border-radius: 13px;

            background: var(--show-secondary);

            color: var(--show-muted);

            font-size: 12px;
            line-height: 1.8;

            white-space: normal;
        }

        .no-description {
            color: var(--show-soft);
            font-style: italic;
        }

        .notice-footer {
            margin-top: 24px;

            padding-top: 19px;

            border-top: 1px solid var(--show-border);

            display: flex;
            justify-content: flex-end;

            gap: 9px;
        }

        .footer-edit-btn,
        .delete-btn {
            min-width: 125px;

            padding: 10px 14px;

            border-radius: 10px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 6px;

            text-decoration: none;

            font-size: 10px;
            font-weight: 700;

            cursor: pointer;
        }

        .footer-edit-btn {
            background: #ffedd5;
            color: #c2410c;
        }

        .delete-btn {
            border: none;

            background: #fee2e2;
            color: #b91c1c;
        }

        html.dark-mode .footer-edit-btn {
            background: rgba(249, 115, 22, .14);
            color: #fb923c;
        }

        html.dark-mode .delete-btn {
            background: rgba(239, 68, 68, .14);
            color: #f87171;
        }

.image-modal {
    position: fixed;
    inset: 0;
    z-index: 99999;

    display: none;
    align-items: center;
    justify-content: center;

    padding: 30px;

    background: rgba(0, 0, 0, 0.9);
    backdrop-filter: blur(5px);
}

.image-modal.active {
    display: flex;
}

.image-modal img {
    max-width: 95vw;
    max-height: 92vh;

    width: auto;
    height: auto;

    object-fit: contain;

    border-radius: 10px;

    box-shadow:
        0 20px 60px rgba(0, 0, 0, .5);
}

.image-modal-close {
    position: absolute;
    top: 20px;
    right: 25px;

    width: 42px;
    height: 42px;

    border: none;
    border-radius: 50%;

    background: rgba(255, 255, 255, .15);
    color: white;

    display: flex;
    align-items: center;
    justify-content: center;

    font-size: 20px;
    cursor: pointer;
}

.image-modal-close:hover {
    background: rgba(255, 255, 255, .25);
}

        @media (max-width: 700px) {

            .notice-show-header {
                flex-direction: column;
                align-items: stretch;
            }

            .header-actions {
                width: 100%;
            }

            .back-btn,
            .edit-btn {
                flex: 1;
            }

            .notice-show-page {
                padding: 20px 12px 35px;
            }

            .notice-main-image {
                height: 280px;
            }

            .notice-content {
                padding: 18px;
            }

            .notice-top {
                flex-direction: column;
            }

            .notice-top h1 {
                font-size: 21px;
            }

            .notice-meta {
                grid-template-columns: 1fr;
            }

            .notice-footer {
                flex-direction: column;
            }

            .notice-footer form,
            .footer-edit-btn,
            .delete-btn {
                width: 100%;
            }

        }

    </style>
<script>
    function openNoticeImage(src) {

        const modal =
            document.getElementById('noticeImageModal');

        const image =
            document.getElementById('noticeFullImage');

        image.src = src;

        modal.classList.add('active');

        document.body.style.overflow = 'hidden';
    }


    function closeNoticeImage() {

        const modal =
            document.getElementById('noticeImageModal');

        modal.classList.remove('active');

        document.body.style.overflow = '';
    }


    document
        .getElementById('noticeImageModal')
        ?.addEventListener('click', function (event) {

            if (event.target === this) {
                closeNoticeImage();
            }

        });


    document.addEventListener('keydown', function (event) {

        if (event.key === 'Escape') {
            closeNoticeImage();
        }

    });
</script>
</x-app-layout>