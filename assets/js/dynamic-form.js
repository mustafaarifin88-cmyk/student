$(document).ready(function() {
    var max_fields = 10;
    var wrapper = $(".input_fields_wrap"); 
    var add_button = $(".add_field_button"); 

    var x = 1; 
    $(add_button).click(function(e){ 
        e.preventDefault();
        if(x < max_fields){ 
            x++; 
            $(wrapper).append(`
                <div class="row mb-2">
                    <div class="col-md-7">
                        <input type="text" name="deskripsi[]" class="form-control" placeholder="Deskripsi Kriteria (misal: Tepat Waktu)" required>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="poin[]" class="form-control" placeholder="Poin" required>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-danger remove_field" type="button"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            `); 
        }
    });

    $(wrapper).on("click",".remove_field", function(e){ 
        e.preventDefault(); 
        $(this).closest('.row').remove(); 
        x--;
    });

    $('#filter-waktu').change(function() {
        var value = $(this).val();
        var url = new URL(window.location.href);
        url.searchParams.set('waktu', value);
        window.location.href = url.toString();
    });

    $('#filter-kelas').change(function() {
        var value = $(this).val();
        var url = new URL(window.location.href);
        url.searchParams.set('kelas', value);
        window.location.href = url.toString();
    });

    $('.custom-file-input').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
});