@extends('layouts.app')

@section('content')

<link href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css" rel="stylesheet">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Supplier List <span style="float:right"><a class="btn btn-primary" href="{{ route('supplier.create') }}">Add New Supplier</a></span></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-bordered" id="datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Group</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let table = new DataTable('#datatable', {
        processing: true,
        serverSide: true,
        ajax: "{{ route('get-supplier') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'code', name: 'code'},
            {data: 'group', name: 'group'},
            {data: 'name', name: 'name'},
            {
                data: 'action', 
                name: 'action', 
                orderable: false, 
                searchable: false
            },
        ]
    });

    function deleteSupplier(id)
    {
        Swal.fire({
            title: 'Do you want to delete this supplier?',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Yes',
            denyButtonText: `Don't Delete`,
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "DELETE",
                    url: 'supplier/'+id,
                    data: {'_token':'{{ csrf_token() }}'}, // serializes the form's elements.
                    success: function(data)
                    {
                        Swal.fire('Supplier Deleted Successfully!', '', 'deleted');
                        table.ajax.reload();
                    }
                });
            } else if (result.isDenied) {
                Swal.fire('Supplier are not deleted', '', 'info')
            }
        })
    }
</script>

@endsection


