<div>
    <div class="modal fade" id="ShowModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="userCrudModal"><span id="nama_surat"></span></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nomor">Nomor Surat : </label>
                        <input readonly autocomplete="off" type="text" class="form-control" id="show_nomor" name="nomor">
                    </div>
                    <div class="form-group">
                        <label for="tanggal">Tanggal Keluar : </label>
                        <input readonly autocomplete="off" type="text" class="form-control" id="show_tanggal" name="tanggal">
                    </div>
                    <div class="form-group">
                        <label for="pembuat">Dikeluarkan oleh : </label>
                        <input readonly autocomplete="off" type="text" class="form-control" id="show_pembuat" name="pembuat">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    $(document).on('click', '#show-surat', function (e) {
        e.preventDefault();

    // populate modal
        var id = $(this).data('id');
        var url = $(this).attr('href');
        console.log(id);
        $.get(url, function (data) {
                //success data
                console.log(data);
                $('#nama_surat').html(data.name);
                $('#show_nomor').val(data.nomor_surat);
                $('#show_tanggal').val(data.tanggal);
                $('#show_pembuat').val(data.submitted_by);
                if (data.departemen == null){
                    data.departemen = '-'
                }
                $('#show_departemen').val(data.departemen);
                $('#ShowModal').modal('show');
            }) 
        })
    //end populate modal
});
</script>