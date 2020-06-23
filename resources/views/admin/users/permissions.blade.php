@component('admin.layouts.content', ['title' => 'ثبت دسترسی'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">داشبورد</a></li>
        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">لیست کاربران</a></li>
        <li class="breadcrumb-item active">ثبت دسترسی</li>
    @endslot

    @slot('script')
        <script>
            $(document).ready(function () {
                var $searchfield = $(this).find('.select2-search__field');
                $searchfield.css('border', 'none');
            });

            $('#roles').select2({
                placeholder: 'مقام مورد نظر را انتخاب کنید',
            });

            $('#permissions').select2({
                placeholder: 'دسترسی مورد نظر را انتخاب کنید'
            });
        </script>
    @endslot

    <div class="row">
        <div class="col-lg-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">فرم ثبت دسترسی</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form method="post" action="{{ route('users.permissions.store', array('user' => $user->id)) }}" class="form-horizontal">
                    @csrf

                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-8 offset-lg-2">
                                <div class="form-group">
                                    <label for="roles" class="col-sm-3 control-label"> مقام ها</label>
                                    <select class="form-control" name="roles[]" id="roles" multiple>
                                        @foreach($roles as $role)
                                            <option {{ $user->roles->contains('id', $role->id) ? 'selected' : '' }} value="{{ $role->id }}">{{ $role->label }} - {{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-8 offset-lg-2">
                                <div class="form-group">
                                    <label for="permissions" class="col-sm-3 control-label"> دسترسی ها</label>
                                    <select class="form-control" name="permissions[]" id="permissions" multiple>
                                        @foreach($permissions as $permission)
                                            <option {{ $user->permissions->contains('id', $permission->id) ? 'selected' : '' }} value="{{ $permission->id }}">{{ $permission->label }} - {{ $permission->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">ایجاد</button>
                        <a href="{{ route('roles.index') }}" class="btn btn-default float-left">لغو</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>
@endcomponent