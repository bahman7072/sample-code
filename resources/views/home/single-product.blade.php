@extends('layouts.app')

@section('script')
    <script>
        $('#sendComment').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            let parent_id = button.data('id');

            var modal = $(this);
            modal.find('input[name="parent_id"]').val(parent_id)
        });

        document.querySelector('#sendCommentForm').addEventListener('submit', function (event) {
            event.preventDefault();

            let target = event.target;

            let data = {
                commentable_id: target.querySelector('input[name="commentable_id"]').value,
                commentable_type: target.querySelector('input[name="commentable_type"]').value,
                parent_id: target.querySelector('input[name="parent_id"]').value,
                comment: target.querySelector('textarea[name="comment"]').value
            };

            if (data.comment.length < 2){
                console.log('Please Enter Comment More Than 2 Character')
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            });

            $.ajax({
                type: 'POST',
                url: '/comments',
                data: JSON.stringify(data),
                success: function (data) {
                    console.log(data);
                }
            });
        })
    </script>
@endsection

@section('content')

    @auth
        {{--******Send Comment as Ajax******--}}
        <div class="modal fade" id="sendComment">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">ارسال نظر</h5>
                        <button type="button" class="close mr-auto ml-0" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('send.comment') }}" method="post" id="sendCommentForm">
                        @csrf

                        <div class="modal-body">
                            <input type="hidden" name="commentable_id" value="{{ $product->id }}">
                            <input type="hidden" name="commentable_type" value="{{ get_class($product) }}">
                            <input type="hidden" name="parent_id" value="0">

                            <div class="form-group">
                                <label for="message-text" class="col-form-label">پیام دیدگاه:</label>
                                <textarea name="comment" class="form-control" id="message-text"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">لغو</button>
                            <button type="submit" class="btn btn-primary">ارسال نظر</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        {{--******Send Comment as Form******--}}
        {{--<div class="modal fade" id="sendComment">--}}
            {{--<div class="modal-dialog">--}}
                {{--<div class="modal-content">--}}
                    {{--<div class="modal-header">--}}
                        {{--<h5 class="modal-title" id="exampleModalLabel">ارسال نظر</h5>--}}
                        {{--<button type="button" class="close mr-auto ml-0" data-dismiss="modal">--}}
                            {{--<span aria-hidden="true">&times;</span>--}}
                        {{--</button>--}}
                    {{--</div>--}}
                    {{--<form action="{{ route('send.comment') }}" method="post">--}}
                        {{--@csrf--}}

                        {{--<div class="modal-body">--}}
                            {{--<input type="hidden" name="commentable_id" value="{{ $product->id }}">--}}
                            {{--<input type="hidden" name="commentable_type" value="{{ get_class($product) }}">--}}
                            {{--<input type="hidden" name="parent_id" value="0">--}}

                            {{--<div class="form-group">--}}
                                {{--<label for="message-text" class="col-form-label">پیام دیدگاه:</label>--}}
                                {{--<textarea name="comment" class="form-control" id="message-text"></textarea>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="modal-footer">--}}
                            {{--<button type="button" class="btn btn-secondary" data-dismiss="modal">لغو</button>--}}
                            {{--<button type="submit" class="btn btn-primary">ارسال نظر</button>--}}
                        {{--</div>--}}
                    {{--</form>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    @endauth

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ $product->title }}
                    </div>

                    <div class="card-body">
                        {{ $product->description }}
                        <hr>
                        <span>دسته بندی: </span>
                        @if($product->categories)
                            @foreach($product->categories as $category)
                                <a href="#" class="badge badge-info">{{ $category->name }}</a>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="mt-4">بخش نظرات</h4>
                    @auth
                        <span class="btn btn-sm btn-primary" data-toggle="modal" data-target="#sendComment" data-id="0">ثبت نظر جدید</span>
                    @endauth

                </div>

                @guest
                    <div class="alert alert-warning">برای ثبت نظر لطفا وارد سایت شوید.</div>
                @endguest

                @include('layouts.comments', ['comments' => $product->comments()->where('parent_id', 0)->get()])
            </div>
        </div>
    </div>
@endsection
