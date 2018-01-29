<script type="text/javascript">
$(document).ready(function() {
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });

	var oTable = $("#list-nasabah").DataTable({
		processing: true,
		serverSide: true,
		ajax: {
			url: '{{ route('nasabah.list') }}'
		},
		columns: [
			{data: 'no_rekening', name: 'no_rekening'},
			{data: 'nama', name: 'nama'},
			{data: 'alamat', name: 'alamat'},
			{data: 'saldo_awal', name: 'saldo_awal'},
			{data: 'created_at', name: 'created_at'},
			{data: 'action', name: 'action'},	
		],
		pageLength: 3,
		order: [[ 4, 'desc' ]]
	});

	$(document).on('click', '.save', function(e) {
    	e.preventDefault();
    	$("p").html('');
    	var form = $("#form-nasabah").serialize();
        $.ajax({
    		url: '{{ route('nasabah.store') }}',
    		type: 'POST',
    		dataType: 'Json',
    		data: form,
    		success: function(data) {
                if (data.errors) {
                    if (data.errors.no_rekening) {
                        $("#no_rekening-error").html(data.errors.no_rekening);
                    }
                    if (data.errors.nama) {
                        $("#nama-error").html(data.errors.nama)
                    }
                    if (data.errors.alamat) {
                        $("#alamat-error").html(data.errors.alamat)
                    }
                    if (data.errors.saldo_awal) {
                        $("#saldo_awal-error").html(data.errors.saldo_awal)
                    } 
                } else {
                	$('.alert').removeClass('hidden');
					$('#message').text(data.message);
                    oTable.ajax.reload();
                    $("#form-nasabah").trigger('reset');
                }
    		},
            error: function(data) {
                console.log(data)
            }
    	});
	
	});

	$(document).on('click', '#edit', function(){
		$('p').html('');
		$('input[name="rekening"]').val($(this).data('rekening'));
		$('input[name="no_rekening"]').val($(this).data('rekening'));
		$('input[name="nama"]').val($(this).data('nama'));
		$('input[name="alamat"]').val($(this).data('alamat'));
		$('input[name="saldo_awal"]').val($(this).data('saldo'));
		$('input[name="saldo_awal"]').prop('disabled', true);
		$('#saldo').text('Saldo Sisa');
		$('.save').addClass('hidden');
		$('.update').removeClass('hidden btn-primary');
		$('.update').addClass('btn-success');
		$("#title").text('Edit '+$(this).data('nama'));
	});

	$(document).on('click', '.cancel', function(event) {
		event.preventDefault();
		$("#form-nasabah").trigger('reset');
		$('p').html('');
		$('.update').addClass('hidden');
		$('.save').removeClass('hidden btn-success');
		$('.save').addClass('btn-primary');
		$('#title').text('Tambah Nasabah');
		$('input[name="saldo_awal"]').prop('disabled', false);
		$('#saldo').text('Saldo Awal');
	});

	$(document).on('click', '.update', function(e) {
		e.preventDefault();
		$.ajax({
			url: '{{ route('nasabah.update') }}',
			type: 'PUT',
			dataType: 'Json',
			data: {
				rekening: $('input[name="rekening"]').val(),
				no_rekening: $('input[name="no_rekening"]').val(),
				nama: $('input[name="nama"]').val(),
				alamat: $('input[name="alamat"]').val(),
				saldo_awal: $('input[name="saldo_awal"]').val(),
			},
			success: function(data){
				if (data.errors) {
                    if (data.errors.no_rekening) {
                        $("#no_rekening-error").html(data.errors.no_rekening);
                    }
                    if (data.errors.nama) {
                        $("#nama-error").html(data.errors.nama)
                    }
                    if (data.errors.alamat) {
                        $("#alamat-error").html(data.errors.alamat)
                    }
                    if (data.errors.saldo_awal) {
                        $("#saldo_awal-error").html(data.errors.saldo_awal)
                    }
                    $('.alert').addClass('hidden'); 
                } else {
                	$('p').html('');
					$('.alert').removeClass('hidden');
					$('#message').text(data.message);
					oTable.ajax.reload();
					$("#form-nasabah").trigger('reset');
					$('.update').addClass('hidden');
					$('.save').removeClass('hidden btn-success');
					$('.save').addClass('btn-primary');
					$('#title').text('Tambah Nasabah');
                }
			},
			error: function(data){
				console.log(data);
			}
		});
	});

	$(document).on('click', '#hapus', function() {
		$('#deleteModal').modal("show");
        $('.modal-title').text($(this).data('nama'));
        $('input[name="rekening"]').val($(this).data('rekening'));
	});

	$(document).on('click', '#delete', function(e) {
		e.preventDefault();
		$.ajax({
			url: '{{ route('nasabah.destroy') }}',
			type: 'DELETE',
			dataType: 'Json',
			data: {
				rekening: $('input[name="rekening"]').val(),
			},
			success: function(data){
				$('#deleteModal').modal('hide');
				oTable.ajax.reload();
				$('.alert').removeClass('hidden');
				$('#message').text(data.message);
			}
		});
	});
});
</script>