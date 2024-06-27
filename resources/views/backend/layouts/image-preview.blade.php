<div class="col-4">
    <div class="input-group mb-3">
        <label class="input-group-text col justify-content-center hvr-border-fade"
            style="cursor:pointer; border-radius: 3px;" for="image">
            <p class="text-dark" id="p">
                <br>
                <i class="fa-light fa-image"></i>
                <br>Importer une image<br>
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
        <input type="file" id="image" name="image"
            class="form-control @error('image') is-invalid @enderror" hidden
            accept=".jpeg, .png, .jpg, .gif, .svg" value="{{ old('image') }}">
        @error('image')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

{{-- scripts --}}
<script src="{{ asset('backend/vendor/jquery/jquery.min.js') }}"></script>
<script type="text/javascript">
    // PREVIEW IMAGE
    $(document).ready(function(e) {
        $('#image').change(function() {
            $('#p').hide();
            $('#preview-image-before-upload').attr('src', '');
            $('#main-image-title').hide();

            if (this.files && this.files[0]) {
                $('#main-image-title').show();

                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#preview-image-before-upload').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
</script>
