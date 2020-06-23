@component('admin.layouts.content', ['title' => 'ویرایش کاربر'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">داشبورد</a></li>
        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">لیست کاربران</a></li>
        <li class="breadcrumb-item active">ویرایش حساب کاربری</li>
    @endslot

    <div class="row">
        <div class="col-lg-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">ویرایش حساب کاربری</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form method="post" action="{{ route('users.update', ['user' => $user->id]) }}" class="form-horizontal">
                    @csrf
                    @method('PATCH')

                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-8 offset-lg-2">
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">نام</label>
                                    <input type="text" name="name" value="{{ $user->name }}" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="نام کاربر را وارد کنید">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-8 offset-lg-2">
                                <div class="form-group">
                                    <label for="email" class="col-sm-2 control-label">ایمیل</label>
                                    <input type="email" name="email" value="{{ $user->email }}" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="ایمیل کاربر را وارد کنید">
                                     @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-8 offset-lg-2">
                                <div class="form-group">
                                    <label for="password" class="col-sm-2 control-label">پسورد</label>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="پسورد را وارد کنید">
                                     @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-8 offset-lg-2">
                                <div class="form-group">
                                    <label for="password_confirm" class="col-sm-3 control-label">تکرار پسورد</label>
                                    <input type="password" name="password_confirmation" class="form-control" id="password_confirm" placeholder="تکرار پسورد را وارد کنید">
                                </div>
                            </div>
                            @if(!$user->hasVerifiedEmail())
                                <div class="col-lg-8 offset-lg-2">
                                    <div class="form-group">
                                        <input type="checkbox" name="verify" class="form-check-input" id="verify">
                                        <label for="verify" class="form-check-label">اکانت فعال باشد</label>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">ویرایش</button>
                        <a href="{{ route('users.index') }}" class="btn btn-default float-left">لغو</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>
@endcomponent