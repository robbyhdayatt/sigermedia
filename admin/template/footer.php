<footer class="text-center py-4 mt-5 text-muted border-top">
    <small>&copy; 2025 Siger Info Media. All rights reserved.</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>

<script>
    // Cek apakah ada elemen dengan id="editor" di halaman ini?
    if(document.querySelector( '#editor' )){
        ClassicEditor
            .create( document.querySelector( '#editor' ), {
                // Opsi Toolbar (agar menu lengkap)
                toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'undo', 'redo' ]
            } )
            .catch( error => {
                console.error( error );
            } );
    }
</script>

</body>
</html>