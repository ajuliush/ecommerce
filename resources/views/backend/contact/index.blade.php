@extends('backend.app')
@section('content')
@extends('backend.app')
@section('content')
<div class="main-content">

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>coupon</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="index.html">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">All Coupon</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <form class="form-search" method="GET" action="{{ route('coupon.index') }}">
                            <fieldset class="name">
                                <input type="text" placeholder="Search here..." class="" name="search" tabindex="2" value="" aria-required="true" required="">
                            </fieldset>
                            <div class="button-submit">
                                <button class="" type="submit"><i class="icon-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <a class="tf-button style-1 w208" href="{{ route('coupon.create') }}"><i class="icon-plus"></i>Add new</a>
                </div>
                <div class="wg-table table-all-user">

                    <div class="table-responsive">
                        @if(Session::has('status'))
                        <p class="alert alert-success">{{ Session::get('status')}}</p>
                        @endif
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Comment</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($contacts->isNotEmpty())
                                @foreach ($contacts as $contact)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $contact->name }}</td>
                                    <td>{{ $contact->email }}</td>
                                    <td>{{ $contact->phone }}</td>
                                    <td>{{ $contact->comment }}</td>
                                    <td>
                                        <div class="list-icon-function">
                                            {{-- <a href="{{ route('contact.edit', $contact->id) }}">
                                            <div class="item edit">
                                                <i class="icon-edit-3"></i>
                                            </div>
                                            </a> --}}
                                            <form action="{{ route('contact.destroy', $contact->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <div class="item text-danger delete">
                                                    <i class="icon-trash-2"></i>
                                                </div>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="4" class="px-5 py-5 border-b border-gray-600 bg-gray-800 text-sm text-white">
                                        {{ "No Data available" }}
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    {{ $contacts->links('pagination::bootstrap-5') }}
                </div>
                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">

                </div>
            </div>
        </div>
    </div>


    @endsection
    @push('scripts')
    <script>
        $(function() {
            $('.delete').on('click', function(e) {
                e.preventDefault();
                var form = $(this).closest('form');
                swal({
                    title: "Are you sure?"
                    , text: "You want to delete this record?"
                    , type: "warning"
                    , buttons: ["No", "Yes"]
                    , confirmButtonColor: '#dc3545'
                }).then(function(result) {
                    if (result) {
                        form.submit();
                    }
                });
            });
        });

    </script>
    @endpush

    @endsection
