@component('admin.layouts.content', ['title' => 'نظرات'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">داشبورد</a></li>
        <li class="breadcrumb-item active">لیست نظرات</li>
    @endslot

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">نظرات</h3>

                    <div class="card-tools d-flex">
                        <form action="">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="search" class="form-control float-right" value="{{ request('search') }}" placeholder="جستجو">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
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
                            <th>نظر</th>
                            <th>وضعیت نظر</th>
                            <th>اقدامات</th>
                        </tr>
                        @foreach($comments as $comment)
                            <tr>
                                <td>{{ $comment->id }}</td>
                                <td>{{ $comment->user->name }}</td>
                                <td>{{ $comment->user->email }}</td>
                                <td>{{ $comment->comment }}</td>
                                @if($comment->approved == 1)
                                    <td><span class="badge badge-success">تایید شده</span></td>
                                @else
                                    <td><span class="badge badge-danger">تایید نشده</span></td>
                                @endif
                                <td>
                                    <div class="btn-group">
                                        @can('edit-user')
                                            @if($comment->approved == 0)
                                                <form action="{{ route('comments.update', ['comment' => $comment->id]) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')

                                                    <button type="submit" class="btn btn-sm btn-success" title="تایید"><i class="fa fa-check"></i></button>
                                                </form>
                                            @endif
                                        @endcan
                                       @can('delete-comment')
                                            <form action="{{ route('comments.destroy', ['comment' => $comment->id]) }}" method="POST">
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
                    <div class="col-lg-12 text-center">{{ $comments->appends(['search' => request('search')])->render() }}</div>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
@endcomponent