<x-app-layout>

    <x-slot name="header">
        <div class="notice-form-header">

            <div>
                <h2>Edit Notice</h2>
                <p>Update notice details and image</p>
            </div>

            <a href="{{ route('notices.index') }}" class="back-btn">
                <i class="fa-solid fa-arrow-left"></i>
                Back
            </a>

        </div>
    </x-slot>


    <div class="notice-form-page">

        <div class="notice-form-container">

            @if($errors->any())

                <div class="error-box">

                    <div class="error-title">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        Please fix the following:
                    </div>

                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                </div>

            @endif


            <div class="form-card">

                <div class="card-heading">

                    <div class="heading-icon">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </div>

                    <div>
                        <span class="section-label">ANNOUNCEMENT</span>

                        <h2>Update Notice</h2>

                        <p>
                            Edit notice information and optionally replace image
                        </p>
                    </div>

                </div>


                <form
                    action="{{ route('notices.update', $notice) }}"
                    method="POST"
                    enctype="multipart/form-data"
                >

                    @csrf
                    @method('PUT')


                    <div class="form-grid">

                        <div class="form-group full-width">

                            <label>
                                Notice Title
                            </label>

                            <input
                                type="text"
                                name="title"
                                value="{{ old('title', $notice->title) }}"
                                required
                            >

                        </div>


                        <div class="form-group">

                            <label>
                                Publish Date
                            </label>

                            <input
                                type="date"
                                name="publish_date"
                                value="{{ old(
                                    'publish_date',
                                    $notice->publish_date?->format('Y-m-d')
                                ) }}"
                            >

                        </div>


                        <div class="form-group">

                            <label>
                                Status
                            </label>

                            <select
                                name="status"
                                required
                            >

                                <option
                                    value="1"
                                    {{ old('status', $notice->status) == 1 ? 'selected' : '' }}
                                >
                                    Active
                                </option>

                                <option
                                    value="0"
                                    {{ old('status', $notice->status) == 0 ? 'selected' : '' }}
                                >
                                    Inactive
                                </option>

                            </select>

                        </div>


                        <div class="form-group full-width">

                            <label>
                                Description
                            </label>

                            <textarea
                                name="description"
                                rows="6"
                                placeholder="Write notice details here..."
                            >{{ old('description', $notice->description) }}</textarea>

                        </div>


                        <div class="form-group full-width">

                            <label>
                                Notice Image
                                <span class="optional-text">
                                    Optional
                                </span>
                            </label>


                            <div class="upload-layout">

                                <div class="upload-box">

                                    <input
                                        type="file"
                                        name="image"
                                        id="noticeImage"
                                        accept=".jpg,.jpeg,.png,.webp"
                                    >

                                    <label
                                        for="noticeImage"
                                        class="upload-label"
                                    >

                                        <div class="upload-icon">
                                            <i class="fa-solid fa-cloud-arrow-up"></i>
                                        </div>

                                        <strong>
                                            Replace Notice Image
                                        </strong>

                                        <span>
                                            Click to select a new image
                                        </span>

                                        <small>
                                            JPG, JPEG, PNG or WEBP — Max 2MB
                                        </small>

                                    </label>

                                </div>


                                <div class="image-preview-wrapper">

                                    @if($notice->image)

                                        <img
                                            id="imagePreview"
                                            src="{{ asset('storage/' . $notice->image) }}"
                                            alt="{{ $notice->title }}"
                                        >

                                        <div
                                            class="preview-placeholder"
                                            id="previewPlaceholder"
                                            style="display:none;"
                                        >
                                            <i class="fa-regular fa-image"></i>
                                            <span>Image Preview</span>
                                        </div>

                                    @else

                                        <img
                                            id="imagePreview"
                                            src=""
                                            alt="Notice preview"
                                            style="display:none;"
                                        >

                                        <div
                                            class="preview-placeholder"
                                            id="previewPlaceholder"
                                        >
                                            <i class="fa-regular fa-image"></i>
                                            <span>No image uploaded</span>
                                        </div>

                                    @endif


                                    <button
                                        type="button"
                                        id="removeSelectedImage"
                                        class="remove-image-btn"
                                        style="display:none;"
                                    >
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>

                                </div>

                            </div>


                            @if($notice->image)

                                <div class="current-image-note">
                                    <i class="fa-solid fa-circle-info"></i>

                                    Current image will remain unless you upload
                                    a new image.
                                </div>

                            @endif

                        </div>

                    </div>


                    <div class="info-box">

                        <i class="fa-solid fa-circle-info"></i>

                        <span>
                            Selecting a new image will replace the current one
                            when the notice is updated.
                        </span>

                    </div>


                    <div class="form-footer">

                        <a
                            href="{{ route('notices.index') }}"
                            class="cancel-btn"
                        >
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="save-btn"
                        >
                            <i class="fa-solid fa-floppy-disk"></i>
                            Update Notice
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>


    <style>

        :root {
            --form-bg: #f4f7fb;
            --form-card: #ffffff;
            --form-secondary: #f8fafc;
            --form-text: #0f172a;
            --form-muted: #64748b;
            --form-soft: #94a3b8;
            --form-border: #e2e8f0;
            --form-primary: #2563eb;
            --form-shadow:
                0 8px 25px rgba(15, 23, 42, .05);
        }

        html.dark-mode {
            --form-bg: #090e1a;
            --form-card: #111827;
            --form-secondary: #172033;
            --form-text: #f8fafc;
            --form-muted: #a7b2c5;
            --form-soft: #75829a;
            --form-border: #253047;
            --form-primary: #60a5fa;
            --form-shadow:
                0 10px 30px rgba(0, 0, 0, .25);
        }

        body {
            background: var(--form-bg);
        }

        .notice-form-header {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .notice-form-header h2 {
            margin: 0 0 4px;
            color: var(--form-text);
            font-size: 21px;
            font-weight: 750;
        }

        .notice-form-header p {
            margin: 0;
            color: var(--form-muted);
            font-size: 12px;
        }

        .back-btn {
            padding: 10px 15px;
            border-radius: 11px;
            background: var(--form-secondary);
            color: var(--form-muted);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 700;
            transition: transform .25s ease;
        }

        .back-btn:hover {
            transform: translateY(-2px);
        }

        .notice-form-page {
            min-height: calc(100vh - 70px);
            padding: 30px 20px 50px;
            background:
                radial-gradient(
                    circle at 10% 10%,
                    rgba(37, 99, 235, .05),
                    transparent 28%
                ),
                var(--form-bg);
        }

        .notice-form-container {
            width: 100%;
            max-width: 1000px;
            margin: auto;
        }

        .error-box {
            margin-bottom: 18px;
            padding: 14px 16px;
            border: 1px solid #fecaca;
            border-radius: 11px;
            background: #fef2f2;
            color: #b91c1c;
            font-size: 11px;
        }

        html.dark-mode .error-box {
            border-color: rgba(239, 68, 68, .22);
            background: rgba(239, 68, 68, .10);
            color: #f87171;
        }

        .error-title {
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 7px;
            font-weight: 700;
        }

        .error-box ul {
            margin: 0;
            padding-left: 18px;
        }

        .form-card {
            padding: 26px;
            border: 1px solid var(--form-border);
            border-radius: 20px;
            background: var(--form-card);
            box-shadow: var(--form-shadow);
        }

        .card-heading {
            margin-bottom: 24px;
            padding-bottom: 19px;
            border-bottom: 1px solid var(--form-border);
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .heading-icon {
            width: 48px;
            height: 48px;
            flex-shrink: 0;
            border-radius: 13px;
            background: #ffedd5;
            color: #c2410c;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 19px;
        }

        html.dark-mode .heading-icon {
            background: rgba(249, 115, 22, .14);
            color: #fb923c;
        }

        .section-label {
            display: block;
            margin-bottom: 2px;
            color: var(--form-primary);
            font-size: 8px;
            font-weight: 800;
            letter-spacing: 1.2px;
        }

        .card-heading h2 {
            margin: 0 0 3px;
            color: var(--form-text);
            font-size: 17px;
            font-weight: 750;
        }

        .card-heading p {
            margin: 0;
            color: var(--form-soft);
            font-size: 10px;
        }

        .form-grid {
            display: grid;
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .full-width {
            grid-column: 1 / -1;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            color: var(--form-muted);
            font-size: 10px;
            font-weight: 700;
        }

        .optional-text {
            margin-left: 5px;
            color: var(--form-soft);
            font-size: 8px;
            font-weight: 500;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 9px 11px;
            border: 1px solid var(--form-border);
            border-radius: 10px;
            background: var(--form-card);
            color: var(--form-text);
            outline: none;
            font-size: 11px;
            transition:
                border-color .2s ease,
                box-shadow .2s ease;
        }

        .form-group input,
        .form-group select {
            height: 43px;
        }

        .form-group textarea {
            min-height: 130px;
            resize: vertical;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: #2563eb;
            box-shadow:
                0 0 0 3px rgba(37, 99, 235, .08);
        }

        .upload-layout {
            display: grid;
            grid-template-columns:
                minmax(0, 1fr)
                280px;
            gap: 16px;
        }

        .upload-box input[type="file"] {
            display: none;
        }

        .upload-label {
            min-height: 210px;
            padding: 25px;
            border: 2px dashed var(--form-border);
            border-radius: 14px;
            background: var(--form-secondary);
            display: flex !important;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-align: center;
            cursor: pointer;
            transition:
                border-color .25s ease,
                transform .25s ease;
        }

        .upload-label:hover {
            transform: translateY(-2px);
            border-color: #2563eb;
        }

        .upload-icon {
            width: 53px;
            height: 53px;
            margin-bottom: 10px;
            border-radius: 15px;
            background: #dbeafe;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 21px;
        }

        html.dark-mode .upload-icon {
            background: rgba(37, 99, 235, .16);
            color: #60a5fa;
        }

        .upload-label strong {
            margin-bottom: 4px;
            color: var(--form-text);
            font-size: 12px;
        }

        .upload-label span {
            color: var(--form-muted);
            font-size: 9px;
        }

        .upload-label small {
            margin-top: 5px;
            color: var(--form-soft);
            font-size: 8px;
        }

        .image-preview-wrapper {
            position: relative;
            min-height: 210px;
            overflow: hidden;
            border: 1px solid var(--form-border);
            border-radius: 14px;
            background: var(--form-secondary);
        }

        #imagePreview {
            width: 100%;
            height: 210px;
            object-fit: cover;
        }

        .preview-placeholder {
            width: 100%;
            height: 210px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 7px;
            color: var(--form-soft);
            font-size: 10px;
        }

        .preview-placeholder i {
            font-size: 25px;
        }

        .remove-image-btn {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 30px;
            height: 30px;
            align-items: center;
            justify-content: center;
            border: none;
            border-radius: 50%;
            background: rgba(15, 23, 42, .80);
            color: white;
            cursor: pointer;
        }

        .current-image-note {
            margin-top: 8px;
            color: var(--form-soft);
            font-size: 9px;
        }

        .info-box {
            margin-top: 20px;
            padding: 12px 14px;
            border-radius: 10px;
            background: #eff6ff;
            color: #1d4ed8;
            display: flex;
            align-items: flex-start;
            gap: 7px;
            font-size: 10px;
            line-height: 1.5;
        }

        html.dark-mode .info-box {
            background: rgba(37, 99, 235, .13);
            color: #60a5fa;
        }

        .form-footer {
            margin-top: 22px;
            padding-top: 18px;
            border-top: 1px solid var(--form-border);
            display: flex;
            justify-content: flex-end;
            gap: 9px;
        }

        .cancel-btn,
        .save-btn {
            min-width: 125px;
            padding: 10px 16px;
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

        .cancel-btn {
            background: var(--form-secondary);
            color: var(--form-muted);
        }

        .save-btn {
            border: none;
            background: #2563eb;
            color: white;
        }

        @media (max-width: 760px) {

            .upload-layout {
                grid-template-columns: 1fr;
            }

        }

        @media (max-width: 600px) {

            .notice-form-page {
                padding: 20px 12px 35px;
            }

            .notice-form-header {
                flex-direction: column;
                align-items: stretch;
            }

            .back-btn {
                width: 100%;
            }

            .form-card {
                padding: 18px;
                border-radius: 16px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .full-width {
                grid-column: auto;
            }

            .form-footer {
                flex-direction: column-reverse;
            }

            .cancel-btn,
            .save-btn {
                width: 100%;
            }

        }

    </style>


    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const input =
                document.getElementById('noticeImage');

            const preview =
                document.getElementById('imagePreview');

            const placeholder =
                document.getElementById('previewPlaceholder');

            const removeButton =
                document.getElementById('removeSelectedImage');


            if (!input) {
                return;
            }


            input.addEventListener('change', function (event) {

                const file =
                    event.target.files[0];

                if (!file) {
                    return;
                }


                const reader =
                    new FileReader();


                reader.onload = function (e) {

                    preview.src =
                        e.target.result;

                    preview.style.display =
                        'block';

                    placeholder.style.display =
                        'none';

                    removeButton.style.display =
                        'flex';

                };


                reader.readAsDataURL(file);

            });


            removeButton.addEventListener('click', function () {

                input.value = '';

                @if($notice->image)

                    preview.src =
                        "{{ asset('storage/' . $notice->image) }}";

                    preview.style.display =
                        'block';

                    placeholder.style.display =
                        'none';

                @else

                    preview.src = '';

                    preview.style.display =
                        'none';

                    placeholder.style.display =
                        'flex';

                @endif


                removeButton.style.display =
                    'none';

            });

        });

    </script>

</x-app-layout>