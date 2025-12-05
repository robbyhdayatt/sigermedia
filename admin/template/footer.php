</div> </div> </div> <footer class="text-center py-3 bg-white border-top mt-auto">
    <small class="text-muted">&copy; 2025 Siger Info Media - Admin Panel</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js" referrerpolicy="origin"></script>

<script>
    // 1. Script Toggle Sidebar
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
        });
    }

    // 2. Inisialisasi TinyMCE (Editor)
    if (document.querySelector('#editor')) {
        tinymce.init({
            selector: '#editor',
            height: 600,
            menubar: true,
            branding: false,
            promotion: false,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | fontfamily fontsize blocks | ' +
                'bold italic underline | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'forecolor backcolor | table image media link | fullscreen code',
            image_title: true,
            automatic_uploads: true,
            file_picker_types: 'image',
            paste_data_images: true,
            images_upload_handler: (blobInfo, progress) => new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.readAsDataURL(blobInfo.blob());
                reader.onload = () => resolve(reader.result);
                reader.onerror = error => reject(error);
            }),
        });
    }
</script>

</body>
</html>