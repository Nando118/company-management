@extends('layouts.app')

@section('content_header')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Companies</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive px-1">
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-end">
                            <a class="btn btn-success" href="{{ route('company.create') }}" role="button"><i class="fas fa-plus"></i> Add Company</a>
                        </div>
                    </div>
                    <table id="tbl_list" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Logo</th>
                                <th>Website</th>
                                <th>Created At</th>
                                <th style="width: 12%">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#tbl_list').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('company.index') }}',
                columns: [
                    {
                        data: null,
                        name: 'no',
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row, meta) {
                            // Menampilkan nomor index (incremented by 1) pada setiap baris
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    {
                        data: 'logo',
                        name: 'logo',
                        render: function (data, type, row) {
                            if (type === 'display' && data) {
                                return '<img src="{{ asset('storage/') }}/' + data + '" width="100" height="100">';
                            }
                            return data;
                        }
                    },
                    { data: 'website', name: 'website' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
                columnDefs: [
                    {
                        target: 5,
                        render: DataTable.render.date()
                    },
                ],
                order: [5, 'desc'],
            });
        });

        $('#tbl_list').on('click', '.delete', function (){
            const el = $(this);
            Swal.fire({
                icon: 'warning',
                title: 'Delete Company Data',
                text: "Are you sure you want to delete this company data?",
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if(result.value){
                    $('.loading').show();
                    $.ajax({
                        url: el.data('url'),
                        type: 'DELETE',
                        dataType: 'JSON',
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        }
                    }).always(function (){
                        $('.loading').hide();
                    }).done(function (data) {
                        if(data.success){
                            $('#tbl_list').DataTable().ajax.reload();
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'Company data has been successfully deleted!',
                            });
                        }
                        else {
                            Swal.fire({
                                icon: 'error',
                                title: 'ERROR',
                                text: 'Company data failed to delete!',
                            });
                        }
                    });
                }
            });
        });

    </script>

    @if(session('success'))
        <script>
            Swal.fire({
                title: 'Success!',
                text: '{{ session("success") }}',
                icon: 'success',
                confirmButtonText: 'OK'
            })
        </script>
    @endif

    @if(session('error'))
        <script>
            Swal.fire({
                title: 'Error!',
                text: '{{ session("error") }}',
                icon: 'error',
                confirmButtonText: 'OK'
            })
        </script>
    @endif


@endpush
