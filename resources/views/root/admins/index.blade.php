@extends('root.templates.master')

@section('content')
    @component('root.components.breadcrumbs')
        @slot('page_title')
            List of admins
        @endslot

        <li class="breadcrumb-item active">
            Admins
        </li>

        @slot('action')
            <form method="GET" action="{{ route('root.admins.create') }}">
                <button type="submit" class="btn btn-info btn-loading float-right">
                    <i class="fas fa-plus"></i> Create
                </button>
            </form>
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Admins</h4>
                    <h6 class="card-subtitle">
                        This is the list of administrators.
                    </h6>

                    <div class="table-responsive m-t-40">
                        <div>
                            <table id="table-admins" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Actions</th>
                                        <th>Name</th>
                                        <th>Birthdate</th>
                                        <th>Gender</th>
                                        <th>Address</th>
                                        <th>Email</th>
                                        <th>Contact</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($admins as $admin)
                                        <tr>
                                            <td class="text-nowrap">
                                                <a href="{{ route('root.admins.edit', $admin) }}" class="link-edit-admin"
                                                    data-toggle="tooltip" data-original-title="Edit">
                                                    <i class="fas fa-pencil-alt text-inverse m-r-10"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <span class="w-25">
                                                        <img src="{{ avatar_thumbnail_path($admin) }}" alt="" class="profile-pic w-50 img-fluid rounded-circle"/>
                                                    </span>

                                                    <span class="w-75 font-weight-normal">
                                                        {{ $admin->full_name }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>{{ $admin->birthdate }}</td>
                                            <td>{{ ucfirst($admin->gender) }}</td>
                                            <td>{{ str_limit($admin->address, 15) }}</td>
                                            <td>{{ $admin->email }}</td>
                                            <td>{{ $admin->contact_number }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="/root/assets/plugins/datatables/datatables.min.js"></script>

    <script>
        $('#table-admins').DataTable({
            "bLengthChange" : false,
        });
    </script>
@endsection
