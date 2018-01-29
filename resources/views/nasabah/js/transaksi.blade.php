<script type="text/javascript">
    $(document).ready(function() {
        $("#title").text('Tambah Transaksi');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
        
        var oTable = $("#list-transaksi").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('transaksi.list', $nasabah->no_rekening) }}'
            },
            columns: [
                {data: 'jenis_transaksi', name: 'jenis_transaksi'},
                {data: 'total', name: 'total'},
                {data: 'saldo', name: 'saldo'},
                {data: 'user.name', name: 'user.name'}, 
                {data: 'created_at', name: 'created_at'},  
            ],
            pageLength: 3,
            order: [[ 4, 'desc' ]]
        });

        $(document).on('click', '#simpan', function(e) {
            e.preventDefault();
            $("p").html('');
            var form = $("#form-transaksi").serialize();
            $.ajax({
                url: '{{ route('nasabah.set-transaksi', $nasabah->no_rekening) }}',
                type: 'POST',
                dataType: 'Json',
                data: form,
                success: function(data) {
                    if (data.errors) {
                        if (data.errors.jenis_transaksi) {
                            $("#jenis_transaksi-error").html(data.errors.jenis_transaksi);
                        }
                        if (data.errors.total) {
                            $("#total-error").html(data.errors.total)
                        } 
                    } else {
                        $('.alert').removeClass('hidden');
                        $('#message').text(data.message);
                        oTable.ajax.reload();
                        $("#form-transaksi").trigger('reset');
                    }
                },
                error: function(data) {
                    console.log(data)
            }
        });  
    });
});
</script>