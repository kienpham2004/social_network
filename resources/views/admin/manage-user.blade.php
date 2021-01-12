@extends('admin.admin')

@section('content')
<div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>{{ trans('admin.no.') }}</th>
                    <th>{{ trans('admin.username') }}</th>
                    <th>{{ trans('admin.role') }}</th>
                    <th>{{ trans('admin.email') }}</th>
                    <th>{{ trans('admin.status') }}</th>
                    <th>{{ trans('admin.create_at') }}</th>
                    <th>{{ trans('admin.action') }}</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>{{ trans('admin.no.') }}</th>
                    <th>{{ trans('admin.username') }}</th>
                    <th>{{ trans('admin.role') }}</th>
                    <th>{{ trans('admin.email') }}</th>
                    <th>{{ trans('admin.status') }}</th>
                    <th>{{ trans('admin.create_at') }}</th>
                    <th>{{ trans('admin.action') }}</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($roles as $role)
                    @foreach ($role->users as $user)
                        <tr>
                            <td>{{ $loop->index }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $role->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td id = "status{{ $user->id }}">{{ $user->status }}</td>
                            <td>{{ $user->created_at }}</td>
                            <td>
                                @if (DB::table('users')->where([['id', $user->id], ['status', config('role.user')]])->exists())
                                    <button class="active" id="active{{ $user->id }}" data-id="{{ $user->id }}" ><i class="fas fa-bell"></i></button>
                                @else
                                    <button class="disabled" id="disabled{{ $user->id }}" data-id="{{ $user->id }}" ><i class="fas fa-bell-slash"></i></button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
