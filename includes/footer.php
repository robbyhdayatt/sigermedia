<footer class="bg-dark text-white mt-5 pt-5 pb-3">
    <div class="container">
        <div class="row">
            <div class="col-md-5 mb-4">
                <h3 class="fw-bold text-primary"><?= strtoupper($d_info['nama_website']) ?></h3>
                <p class="text-secondary">
                    <?= $d_info['deskripsi'] ?>
                </p>
                
                <div class="text-secondary small mt-3">
                    <div class="mb-2"><i class="bi bi-geo-alt me-2"></i> <?= $d_info['alamat'] ?></div>
                    <div class="mb-2"><i class="bi bi-envelope me-2"></i> <?= $d_info['email'] ?></div>
                    <div class="mb-2"><i class="bi bi-telephone me-2"></i> <?= $d_info['no_hp'] ?></div>
                </div>
            </div>
            
            <div class="col-md-3 mb-4">
                <h5 class="fw-bold mb-3">Menu</h5>
                <ul class="list-unstyled">
                    <li><a href="<?= $base_url ?>tentang-kami.php" class="text-secondary text-decoration-none">Tentang Kami</a></li>
                    <li><a href="#" class="text-secondary text-decoration-none">Redaksi</a></li>
                    <li><a href="#" class="text-secondary text-decoration-none">Karir</a></li>
                    <li><a href="#" class="text-secondary text-decoration-none">Pedoman Media Siber</a></li>
                </ul>
            </div>
            
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold mb-3">Ikuti Kami</h5>
                <div class="d-flex gap-2">
                    <?php if(!empty($d_info['facebook'])){ ?>
                        <a href="<?= $d_info['facebook'] ?>" class="btn btn-outline-secondary rounded-circle" style="width: 40px; height: 40px; padding: 0; line-height: 38px;">
                            <i class="bi bi-facebook"></i>
                        </a>
                    <?php } ?>
                    
                    <?php if(!empty($d_info['instagram'])){ ?>
                        <a href="<?= $d_info['instagram'] ?>" class="btn btn-outline-secondary rounded-circle" style="width: 40px; height: 40px; padding: 0; line-height: 38px;">
                            <i class="bi bi-instagram"></i>
                        </a>
                    <?php } ?>
                    
                    <a href="#" class="btn btn-outline-secondary rounded-circle" style="width: 40px; height: 40px; padding: 0; line-height: 38px;">
                        <i class="bi bi-youtube"></i>
                    </a>
                </div>
            </div>
        </div>
        <hr class="border-secondary">
        <div class="text-center text-secondary small">
            &copy; <?= date('Y') ?> <?= $d_info['nama_website'] ?>. All Rights Reserved.
        </div>
    </div>
</footer>

<a href="#" id="backToTop" class="btn btn-primary rounded-circle shadow" 
   style="position: fixed; bottom: 20px; right: 20px; display: none; z-index: 99; width: 45px; height: 45px; line-height: 45px; text-align: center;">
   <i class="bi bi-arrow-up fs-5"></i>
</a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
  window.addEventListener("load", function() {
    var loader = document.getElementById("preloader");
    if(loader) {
        loader.style.opacity = "0";
        setTimeout(function(){ loader.style.display = "none"; }, 500);
    }
  });

  AOS.init({ duration: 800, once: true, offset: 100 });

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