<x-app-layout>

    <x-slot name="header">
        <div class="parent-result-header">

            <div>
                <h2>Child Results</h2>
                <p>
                    View exam results for
                    <strong>{{ $student->name }}</strong>
                </p>
            </div>

            <a href="{{ route('dashboard') }}"
               class="back-btn">

                <i class="fa-solid fa-arrow-left"></i>
                Dashboard

            </a>

        </div>
    </x-slot>


    <div class="results-page">

        <div class="results-container">

            <div class="student-card">

                <div class="student-avatar">

                    @if($student->photo)

                        <img
                            src="{{ asset('storage/' . $student->photo) }}"
                            alt="{{ $student->name }}"
                        >

                    @else

                        {{ strtoupper(substr($student->name, 0, 1)) }}

                    @endif

                </div>

                <div>

                    <h3>{{ $student->name }}</h3>

                    <p>
                        {{ $student->student_id }}
                        ·
                        {{ $student->classRoom?->class_name ?? 'No Class' }}
                    </p>

                </div>

            </div>


            <div class="results-card">

                <div class="card-heading">

                    <div>

                        <span class="section-label">
                            ACADEMIC
                        </span>

                        <h2>
                            Exam Results
                        </h2>

                        <p>
                            Select an exam to view the complete result card.
                        </p>

                    </div>


                    <span class="exam-count">

                        {{ $exams->count() }}
                        Exams

                    </span>

                </div>


                @if($exams->count())

                    <div class="exam-grid">

                        @foreach($exams as $exam)

                            <a
                                href="{{ route(
                                    'parent.results.show',
                                    $exam->id
                                ) }}"
                                class="exam-card"
                            >

                                <div class="exam-icon">
                                    <i class="fa-solid fa-file-lines"></i>
                                </div>


                                <div class="exam-info">

                                    <h3>
                                        {{ $exam->exam_name }}
                                    </h3>

                                    <p>
                                        Session:
                                        {{ $exam->session }}
                                    </p>

                                    <span>
                                        {{ $exam->start_date
                                            ? $exam->start_date->format('d M Y')
                                            : 'Date not available'
                                        }}
                                    </span>

                                </div>


                                <i class="fa-solid fa-arrow-right exam-arrow"></i>

                            </a>

                        @endforeach

                    </div>

                @else

                    <div class="empty-state">

                        <div class="empty-icon">
                            <i class="fa-solid fa-chart-column"></i>
                        </div>

                        <h3>
                            No Results Available
                        </h3>

                        <p>
                            No exam results have been published for this student yet.
                        </p>

                    </div>

                @endif

            </div>

        </div>

    </div>


    <style>

        :root {
            --result-bg: #f4f7fb;
            --result-card: #ffffff;
            --result-secondary: #f8fafc;
            --result-text: #0f172a;
            --result-muted: #64748b;
            --result-soft: #94a3b8;
            --result-border: #e4eaf2;
            --result-primary: #2563eb;
            --result-shadow:
                0 8px 25px rgba(15, 23, 42, .05);
        }

        html.dark-mode {
            --result-bg: #090e1a;
            --result-card: #111827;
            --result-secondary: #172033;
            --result-text: #f8fafc;
            --result-muted: #a7b2c5;
            --result-soft: #75829a;
            --result-border: #253047;
            --result-primary: #60a5fa;
            --result-shadow:
                0 10px 30px rgba(0, 0, 0, .25);
        }

        body {
            background: var(--result-bg);
        }

        .parent-result-header {
            width: 100%;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 20px;
        }

        .parent-result-header h2 {
            margin: 0 0 4px;

            color: var(--result-text);

            font-size: 21px;
            font-weight: 750;
        }

        .parent-result-header p {
            margin: 0;

            color: var(--result-muted);

            font-size: 12px;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 7px;

            padding: 10px 15px;

            border-radius: 11px;

            background: var(--result-secondary);
            color: var(--result-muted);

            text-decoration: none;

            font-size: 12px;
            font-weight: 700;
        }

        .results-page {
            min-height: calc(100vh - 70px);

            padding: 30px 20px 50px;

            background:
                radial-gradient(
                    circle at 10% 10%,
                    rgba(37, 99, 235, .05),
                    transparent 28%
                ),
                var(--result-bg);
        }

        .results-container {
            width: 100%;
            max-width: 1200px;

            margin: auto;
        }

        .student-card,
        .results-card {
            border: 1px solid var(--result-border);
            background: var(--result-card);

            box-shadow: var(--result-shadow);

            transition:
                background .3s ease,
                border-color .3s ease;
        }

        .student-card {
            margin-bottom: 20px;

            padding: 18px;

            border-radius: 18px;

            display: flex;
            align-items: center;

            gap: 13px;
        }

        .student-avatar {
            width: 55px;
            height: 55px;

            flex-shrink: 0;

            overflow: hidden;

            border-radius: 15px;

            display: flex;
            align-items: center;
            justify-content: center;

            color: white;

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #60a5fa
                );

            font-size: 19px;
            font-weight: 800;
        }

        .student-avatar img {
            width: 100%;
            height: 100%;

            object-fit: cover;
        }

        .student-card h3 {
            margin: 0 0 3px;

            color: var(--result-text);

            font-size: 15px;
            font-weight: 750;
        }

        .student-card p {
            margin: 0;

            color: var(--result-muted);

            font-size: 11px;
        }

        .results-card {
            overflow: hidden;

            border-radius: 20px;
        }

        .card-heading {
            padding: 22px 24px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 15px;

            border-bottom:
                1px solid var(--result-border);
        }

        .section-label {
            display: block;

            margin-bottom: 3px;

            color: var(--result-primary);

            font-size: 9px;
            font-weight: 800;

            letter-spacing: 1.3px;
        }

        .card-heading h2 {
            margin: 0 0 4px;

            color: var(--result-text);

            font-size: 18px;
            font-weight: 750;
        }

        .card-heading p {
            margin: 0;

            color: var(--result-soft);

            font-size: 11px;
        }

        .exam-count {
            padding: 6px 11px;

            border-radius: 20px;

            background: #dbeafe;
            color: #2563eb;

            font-size: 10px;
            font-weight: 700;
        }

        html.dark-mode .exam-count {
            background: rgba(37, 99, 235, .15);
            color: #60a5fa;
        }

        .exam-grid {
            padding: 20px;

            display: grid;
            grid-template-columns:
                repeat(2, minmax(0, 1fr));

            gap: 15px;
        }

        .exam-card {
            position: relative;

            min-height: 105px;

            padding: 16px;

            display: flex;
            align-items: center;

            gap: 13px;

            border: 1px solid var(--result-border);
            border-radius: 15px;

            background: var(--result-secondary);
            color: var(--result-text);

            text-decoration: none;

            transition:
                transform .25s ease,
                box-shadow .25s ease,
                border-color .25s ease;
        }

        .exam-card:hover {
            transform: translateY(-4px);

            border-color:
                rgba(37, 99, 235, .25);

            box-shadow:
                0 12px 27px rgba(15, 23, 42, .09);
        }

        .exam-icon {
            width: 45px;
            height: 45px;

            flex-shrink: 0;

            border-radius: 13px;

            display: flex;
            align-items: center;
            justify-content: center;

            color: #7c3aed;
            background: #ede9fe;

            font-size: 18px;
        }

        html.dark-mode .exam-icon {
            color: #c084fc;
            background: rgba(147, 51, 234, .15);
        }

        .exam-info {
            min-width: 0;
            flex: 1;
        }

        .exam-info h3 {
            margin: 0 0 4px;

            color: var(--result-text);

            font-size: 13px;
            font-weight: 750;
        }

        .exam-info p,
        .exam-info span {
            display: block;

            margin: 0;

            color: var(--result-muted);

            font-size: 10px;
        }

        .exam-info span {
            margin-top: 3px;

            color: var(--result-soft);
        }

        .exam-arrow {
            color: var(--result-soft);

            font-size: 11px;

            transition: transform .25s ease;
        }

        .exam-card:hover .exam-arrow {
            transform: translateX(4px);

            color: var(--result-primary);
        }

        .empty-state {
            padding: 65px 20px;

            text-align: center;
        }

        .empty-icon {
            width: 70px;
            height: 70px;

            margin: 0 auto 14px;

            border-radius: 20px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: var(--result-secondary);
            color: var(--result-primary);

            font-size: 27px;
        }

        .empty-state h3 {
            margin: 0 0 6px;

            color: var(--result-text);

            font-size: 17px;
        }

        .empty-state p {
            margin: 0;

            color: var(--result-muted);

            font-size: 12px;
        }

        @media (max-width: 700px) {

            .exam-grid {
                grid-template-columns: 1fr;
            }

        }

        @media (max-width: 576px) {

            .parent-result-header {
                flex-direction: column;
                align-items: stretch;
            }

            .back-btn {
                width: 100%;
            }

            .results-page {
                padding: 20px 12px 35px;
            }

            .card-heading {
                align-items: flex-start;

                padding: 18px;
            }

            .exam-grid {
                padding: 13px;
            }

        }

    </style>

</x-app-layout>