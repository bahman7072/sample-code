@component('admin.layouts.content', ['title' => 'کاربران'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">داشبورد</a></li>
        <li class="breadcrumb-item active">لیست کاربران</li>
    @endslot

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">کاربران</h3>

                    <div class="card-tools d-flex">
                        <form action="">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="search" class="form-control float-right" value="{{ request('search') }}" placeholder="جستجو">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                        <div class="btn-group-sm mr-2">
                            @can('create-user')
                                <a href="{{ route('users.create') }}" class="btn btn-info">ایجاد <i class="fa fa-plus"></i></a>
                            @endcan

                            @can('show-staff-users')
                                    <a href="{{ request()->fullUrlWithQuery(['admin' => 1]) }}" class="btn btn-danger">کاربران مدیر <i class="fa fa-users"></i></a>
                            @endcan
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th>شماره</th>
                            <th>نام کاربر</th>
                            <th>ایمیل</th>
                            <th>وضعیت ایمیل</th>
                            <th>اقدامات</th>
                        </tr>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                @if($user->email_verified_at)
                                    <td><span class="badge badge-success">فعال</span></td>
                                @else
                                    <td><span class="badge badge-danger">غیر فعال</span></td>
                                @endif
                                <td>
                                    <div class="btn-group">
                                        @can('edit-user')
                                            <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="btn btn-sm btn-primary" title="ویرایش"><i class="fa fa-edit"></i></a>
                                        @endcan
                                        @if($user->isStaffUser())
                                            @can('staff-user-permissions')
                                                    <a href="{{ route('users.permissions', ['user' => $user->id]) }}" class="btn btn-sm btn-dark" title="دسترسی"><i class="fa fa-user-secret"></i></a>
                                            @endcan
                                        @endif
                                       @can('delete-user')
                                            <form action="{{ route('users.destroy', ['user' => $user->id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-sm btn-danger" title="حذف"><i class="fa fa-remove"></i></button>
                                            </form>
                                       @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div class="col-lg-12 text-center">{{ $users->appends(['search' => request('search')])->render() }}</div>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
@endcomponent