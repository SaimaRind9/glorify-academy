@extends('layouts.admin')

@section('content')

<div class="container-fluid py-4">

    {{-- Page Header --}}
    <div class="page-header mb-4">
        <div>
            <p class="page-subtitle mb-1">Class Management</p>

            <h2 class="page-title mb-2">
                The Glorify Academy Classes
            </h2>

            <p class="page-description mb-0">
                Manage Nursery and primary classes from one place.
            </p>
        </div>

        <a href="{{ route('class-rooms.create') }}" class="add-class-btn">
            <i class="fa-solid fa-plus"></i>
            Add Class
        </a>
    </div>


    {{-- Statistics --}}
    <div class="row g-4 mb-4">

        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon total-icon">
                    <i class="fa-solid fa-school"></i>
                </div>

                <div>
                    <p>Total Classes</p>
                    <h3>{{ $classes->count() }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon nursery-icon">
                    <i class="fa-solid fa-shapes"></i>
                </div>

                <div>
                    <p>Nursery Classes</p>

                    <h3>
                        {{ $classes->filter(function ($class) {
                            return strtolower($class->class_name) === 'nursery';
                        })->count() }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon primary-icon">
                    <i class="fa-solid fa-book-open-reader"></i>
                </div>

                <div>
                    <p>Primary Classes</p>

                    <h3>
                        {{ $classes->filter(function ($class) {
                            return strtolower($class->class_name) !== 'nursery';
                        })->count() }}
                    </h3>
                </div>
            </div>
        </div>

    </div>


    {{-- Classes Section --}}
    <div class="dashboard-card">

        <div class="card-heading">
            <div>
                <h5>Available Classes</h5>
                <p>All classes currently registered in the academy</p>
            </div>

            <div class="heading-icon">
                <i class="fa-solid fa-layer-group"></i>
            </div>
        </div>


        <div class="row g-4">

            @forelse($classes as $class)

                <div class="col-xl-4 col-md-6">

                    <div class="class-card">

                        <div class="class-card-top">

                            <div class="class-icon">
                                <i class="fa-solid fa-chalkboard"></i>
                            </div>

                            <span class="class-badge">
                                Active
                            </span>

                        </div>


                        <div class="class-card-body">

                            <h4>
                                {{ $class->class_name }}
                            </h4>

                            <p>
                                {{ $class->description ?: 'No description has been added for this class.' }}
                            </p>

                        </div>


                        <div class="class-card-footer">

                            <span>
                                <i class="fa-solid fa-user-graduate"></i>
                                Academy Class
                            </span>

                        </div>

                    </div>

                </div>

            @empty

                <div class="col-12">

                    <div class="empty-state">

                        <div class="empty-icon">
                            <i class="fa-solid fa-school-circle-xmark"></i>
                        </div>

                        <h4>No Classes Found</h4>

                        <p>
                            Add the first class to start managing academy students.
                        </p>

                        <a href="{{ route('class-rooms.create') }}"
                           class="add-class-btn">

                            <i class="fa-solid fa-plus"></i>
                            Add First Class

                        </a>

                    </div>

                </div>

            @endforelse

        </div>

    </div>

</div>


<style>

    .page-header {
        background: linear-gradient(135deg, #172554, #2563eb);
        color: white;
        border-radius: 20px;
        padding: 30px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        box-shadow: 0 15px 35px rgba(37, 99, 235, 0.18);
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: "";
        position: absolute;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.08);
        right: -70px;
        top: -110px;
    }

    .page-header > * {
        position: relative;
        z-index: 1;
    }

    .page-subtitle {
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        opacity: 0.85;
    }

    .page-title {
        font-size: 28px;
        font-weight: 750;
    }

    .page-description {
        font-size: 14px;
        opacity: 0.88;
    }

    .add-class-btn {
        background: white;
        color: #2563eb;
        border: none;
        border-radius: 12px;
        padding: 12px 19px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 700;
        white-space: nowrap;
        box-shadow: 0 8px 20px rgba(15, 23, 42, 0.14);
        transition: all 0.25s ease;
    }

    .add-class-btn:hover {
        color: #1d4ed8;
        transform: translateY(-3px);
        box-shadow: 0 12px 25px rgba(15, 23, 42, 0.18);
    }

    .stat-card {
        background: white;
        border: 1px solid #edf0f5;
        border-radius: 18px;
        padding: 22px;
        display: flex;
        align-items: center;
        gap: 16px;
        height: 100%;
        box-shadow: 0 8px 25px rgba(15, 23, 42, 0.06);
        transition: all 0.25s ease;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 14px 30px rgba(15, 23, 42, 0.10);
    }

    .stat-card p {
        margin: 0 0 4px;
        color: #64748b;
        font-size: 13px;
        font-weight: 500;
    }

    .stat-card h3 {
        margin: 0;
        color: #0f172a;
        font-size: 28px;
        font-weight: 750;
    }

    .stat-icon {
        width: 58px;
        height: 58px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        flex-shrink: 0;
    }

    .total-icon {
        background: #dbeafe;
        color: #2563eb;
    }

    .nursery-icon {
        background: #fce7f3;
        color: #db2777;
    }

    .primary-icon {
        background: #d1fae5;
        color: #059669;
    }

    .dashboard-card {
        background: white;
        border-radius: 18px;
        padding: 24px;
        border: 1px solid #edf0f5;
        box-shadow: 0 8px 25px rgba(15, 23, 42, 0.06);
    }

    .card-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .card-heading h5 {
        margin: 0 0 4px;
        color: #0f172a;
        font-size: 18px;
        font-weight: 700;
    }

    .card-heading p {
        margin: 0;
        color: #94a3b8;
        font-size: 13px;
    }

    .heading-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: #eff6ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .class-card {
        height: 100%;
        background: #ffffff;
        border: 1px solid #e8edf5;
        border-radius: 18px;
        padding: 22px;
        display: flex;
        flex-direction: column;
        transition: all 0.25s ease;
        position: relative;
        overflow: hidden;
    }

    .class-card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        background: linear-gradient(90deg, #2563eb, #60a5fa);
    }

    .class-card:hover {
        transform: translateY(-6px);
        border-color: #bfdbfe;
        box-shadow: 0 15px 35px rgba(15, 23, 42, 0.10);
    }

    .class-card-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .class-icon {
        width: 54px;
        height: 54px;
        border-radius: 15px;
        background: #eff6ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 23px;
    }

    .class-badge {
        background: #dcfce7;
        color: #15803d;
        border-radius: 30px;
        padding: 6px 11px;
        font-size: 11px;
        font-weight: 700;
    }

    .class-card-body {
        flex: 1;
    }

    .class-card-body h4 {
        margin: 0 0 10px;
        color: #0f172a;
        font-size: 20px;
        font-weight: 750;
    }

    .class-card-body p {
        margin: 0;
        color: #64748b;
        font-size: 13px;
        line-height: 1.7;
    }

    .class-card-footer {
        margin-top: 22px;
        padding-top: 16px;
        border-top: 1px solid #f1f5f9;
        color: #94a3b8;
        font-size: 12px;
    }

    .class-card-footer i {
        margin-right: 6px;
        color: #2563eb;
    }

    .empty-state {
        text-align: center;
        padding: 55px 20px;
    }

    .empty-icon {
        width: 75px;
        height: 75px;
        border-radius: 20px;
        background: #eff6ff;
        color: #2563eb;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 32px;
        margin: 0 auto 18px;
    }

    .empty-state h4 {
        color: #0f172a;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .empty-state p {
        color: #94a3b8;
        font-size: 13px;
        margin-bottom: 20px;
    }

    .empty-state .add-class-btn {
        background: #2563eb;
        color: white;
    }

    .empty-state .add-class-btn:hover {
        color: white;
        background: #1d4ed8;
    }

    @media (max-width: 768px) {

        .page-header {
            padding: 24px;
            align-items: flex-start;
            flex-direction: column;
        }

        .page-title {
            font-size: 23px;
        }

        .add-class-btn {
            width: 100%;
        }

        .card-heading {
            align-items: flex-start;
        }
    }

</style>

@endsection