@extends('layouts.admin')

@section('title','Academic Sessions')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold">
                Academic Session Management
            </h2>

            <p class="text-muted mb-0">
                Manage academy academic sessions
            </p>

        </div>

        <a href="{{ route('academic-sessions.create') }}"
           class="btn btn-primary">

            <i class="fa-solid fa-plus"></i>

            Add Session

        </a>

    </div>


    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            {{ session('success') }}

            <button class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif



    <div class="card shadow border-0 rounded-4">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>#</th>

                            <th>Session</th>

                            <th>Start Date</th>

                            <th>End Date</th>

                            <th>Status</th>

                            <th width="220">
                                Action
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                    @forelse($sessions as $session)

                        <tr>

                            <td>

                                {{ $loop->iteration }}

                            </td>

                            <td>

                                <strong>

                                    {{ $session->session_name }}

                                </strong>

                            </td>

                            <td>

                                {{ date('d M Y',strtotime($session->start_date)) }}

                            </td>

                            <td>

                                {{ date('d M Y',strtotime($session->end_date)) }}

                            </td>

                            <td>

                                @if($session->status=="Active")

                                    <span class="badge bg-success">

                                        Active

                                    </span>

                                @else

                                    <span class="badge bg-secondary">

                                        Inactive

                                    </span>

                                @endif

                            </td>

                            <td>

                                <a href="{{ route('academic-sessions.edit',$session->id) }}"
                                   class="btn btn-warning btn-sm">

                                    <i class="fa-solid fa-pen"></i>

                                </a>


                                <form action="{{ route('academic-sessions.toggle-status',$session->id) }}"
                                      method="POST"
                                      class="d-inline">

                                    @csrf

                                    @method('PATCH')

                                    @if($session->status=="Active")

                                        <button class="btn btn-secondary btn-sm">

                                            Inactive

                                        </button>

                                    @else

                                        <button class="btn btn-success btn-sm">

                                            Activate

                                        </button>

                                    @endif

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6"
                                class="text-center">

                                No Academic Session Found

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection