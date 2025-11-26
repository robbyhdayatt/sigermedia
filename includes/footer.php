<footer class="bg-dark text-white mt-5 pt-5 pb-3">
    <div class="container">
        <div class="row">
            <div class="col-md-5 mb-4">
                <h3 class="fw-bold text-primary">SIGER INFO</h3>
                <p class="text-secondary">
                    Portal berita terpercaya yang menyajikan informasi terkini dari Lampung untuk Indonesia.
                </p>
            </div>
            <div class="col-md-3 mb-4">
                <h5 class="fw-bold mb-3">Menu</h5>
                <ul class="list-unstyled">
                    <li><a href="<?= $base_url ?>tentang-kami.php" class="text-secondary text-decoration-none">Tentang Kami</a></li>
                    <li><a href="#" class="text-secondary text-decoration-none">Redaksi</a></li>
                    <li><a href="#" class="text-secondary text-decoration-none">Kontak</a></li>
                </ul>
            </div>
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold mb-3">Newsletter</h5>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Email Anda">
                    <button class="btn btn-primary" type="button">Subscribe</button>
                </div>
            </div>
        </div>
        <hr class="border-secondary">
        <div class="text-center text-secondary small">
            &copy; 2025 Siger Info Media. All Rights Reserved.
        </div>
    </div>
</footer>

<a href="#" id="backToTop" class="btn btn-primary rounded-circle shadow" 
   style="position: fixed; bottom: 20px; right: 20px; display: none; z-index: 99; width: 45px; height: 45px; line-height: 33px;">
   <i class="bi bi-arrow-up fs-5"></i>
</a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>

<script>
  // 1. Hilangkan Preloader saat load selesai
  window.addEventListener("load", function() {
    var loader = document.getElementById("preloader");
    loader.style.opacity = "0";
    setTimeout(function(){ loader.style.display = "none"; }, 500);
  });

  // 2. Inisialisasi Animasi AOS
  AOS.init({ duration: 800, once: true, offset: 100 });

  // 3. Logic Tombol Back to Top
  var mybutton = document.getElementById("backToTop");
  window.onscroll = function() {
      if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
          mybutton.style.display = "block";
      } else {
          mybutton.style.display = "none";
      }
  };
</script>

</body>
</html>