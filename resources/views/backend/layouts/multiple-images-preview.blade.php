<div class="col-4">
    <div class="input-group mb-3">
        <label class="input-group-text col justify-content-center hvr-border-fade"
            style="cursor:pointer; border-radius: 3px;" for="images">
            <p class="text-dark" id="p">
                <br>
                <i class="fa-light fa-image"></i>
                <br>Importer des images<br>
                <br>
                <span class="form-text">
                    <i class="fa-light fa-circle-info"></i>
                    <br>Formats de fichier acceptés: <br>
                    JPG, PNG ou SVG. <br>
                    La taille de l'image doit être <br>
                    inférieure à 2 Mo.
                </span>
            </p>
            <span class="d-flex flex-column text-dark" style="height:250px;">
                <p id="main-image-title" class="text-center" style="display: none;">Image
                    principale</p>
                <img id="preview-image-before-upload" src=""
                    style="max-height: 200px; max-width:200px;">
            </span>
        </label>
        <input type="file" id="images" name="images[]"
            class="form-control @error('images') is-invalid @enderror" hidden
            accept=".jpeg, .png, .jpg, .gif, .svg" multiple value="{{ old('images') }}">
        @error('images')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div id="thumbnails-container" class="d-flex overflow-auto"
        style="max-width: 100%; overflow-x: auto; border: 1px solid #ddd; padding: 5px;">
        <div id="thumbnails" class="d-flex flex-row-reverse flex-nowrap"></div>
    </div>
</div>

<script src="{{ asset('backend/vendor/jquery/jquery.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(e) {
        $('#images').change(function() {
            $('#p').hide();
            $('#preview-image-before-upload').attr('src', '');
            $('#thumbnails').empty();
            $('#main-image-title').hide();

            let files = Array.from(this.files);

            if (files.length > 0) {
                $('#main-image-title').show();

                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#preview-image-before-upload').attr('src', e.target.result);
                }
                reader.readAsDataURL(files[0]);

                files.forEach((file, index) => {
                    let reader = new FileReader();
                    reader.onload = (e) => {
                        let img = $('<img src="' + e.target.result +
                            '" style="max-height: 50px; max-width:100px; margin: 5px; cursor: pointer;">'
                            );
                        img.on('click', function() {
                            $('#preview-image-before-upload').attr('src', e.target.result);
                            $('#thumbnails img').css('border', 'none');
                            $(this).css('border', '5px solid blue');
                            // Move selected file to the beginning of the array
                            files.splice(index, 1);
                            files.unshift(file);
                            updateFileInput(files);
                        });
                        if (index == 0) {
                            img.css('border', '5px solid blue');
                        }
                        $('#thumbnails').append(img);
                    }
                    reader.readAsDataURL(file);
                });
            }

            function updateFileInput(files) {
                let dataTransfer = new DataTransfer();
                files.forEach(file => dataTransfer.items.add(file));
                $('#images')[0].files = dataTransfer.files;
            }
        });
    });
</script>
