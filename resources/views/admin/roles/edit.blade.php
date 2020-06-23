@component('admin.layouts.content', ['title' => 'ویرایش مقام'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">داشبورد</a></li>
        <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">مقام ها</a></li>
        <li class="breadcrumb-item active">ویرایش مقام</li>
    @endslot

    @slot('script')
        <script>
            $(document).ready(function () {
                var $searchfield = $(this).find('.select2-search__field');
                $searchfield.css('border', 'none');
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
                    <h3 class="card-title">فرم ویرایش مقام</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form method="post" action="{{ route('roles.update', ['role' => $role->id]) }}" class="form-horizontal">
                    @csrf
                    @method('PATCH')

                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-8 offset-lg-2">
                                <div class="form-group">
                                    <label for="name" class="col-sm-3 control-label">عنوان مقام</label>
                                    <input type="text" name="name" value="{{ old('name', $role->name) }}" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="عنوان مقام را وارد کنید">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-8 offset-lg-2">
                                <div class="form-group">
                                    <label for="label" class="col-sm-3 control-label">توضیح مقام</label>
                                    <input type="text" name="label" value="{{ old('label', $role->label) }}" class="form-control @error('label') is-invalid @enderror" id="label" placeholder="توضیح مقام را وارد کنید">
                                    @error('label')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-8 offset-lg-2">
                                <div class="form-group">
                                    <label for="permissions" class="col-sm-3 control-label">توضیح مقام</label>
                                    <select class="form-control" name="permissions[]" id="permissions" multiple>
                                        @foreach($permissions as $permission)
                                            <option {{ $role->permissions->contains('id', $permission->id) ? 'selected' : '' }} value="{{ $permission->id }}">{{ $permission->label }} - {{ $permission->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">ویرایش</button>
                        <a href="{{ route('roles.index') }}" class="btn btn-default float-left">لغو</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>
@endcomponent