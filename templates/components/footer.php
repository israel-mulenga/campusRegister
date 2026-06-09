<footer class="footer footer-main bg-dark text-light pt-5 pb-3 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h4 class="text-white mb-4 footer-heading">COORDONNÉES</h4> 
                    <p><i class="fas fa-map-marker-alt me-2"></i> Lubumbashi, Haut-Katanga<br>République Démocratique du Congo</p> 
                    <p><i class="fas fa-phone-alt me-2"></i> +(243) 822 267 472</p> 
                    <p><i class="fas fa-envelope me-2"></i> <a href="mailto:infos@udbl.ac.cd" class="text-white text-decoration-none">infos@udbl.ac.cd</a></p>
                </div>
                
                <div class="col-md-4 mb-4">
                    <h4 class="text-white mb-4 footer-heading">LIENS RAPIDES</h4>
                    <ul class="list-unstyled">
                        <li><a href="index.php?page=a-propos-de-nous" class="text-light text-decoration-none"><i class="fas fa-chevron-right me-2 small"></i>A propos</a></li>
                        <li><a href="index.php?page=actualites" class="text-light text-decoration-none"><i class="fas fa-chevron-right me-2 small"></i>Actualités</a></li>
                        <li><a href="index.php?page=horaires" class="text-light text-decoration-none"><i class="fas fa-chevron-right me-2 small"></i>Horaires des cours</a></li>
                    </ul>
                </div>

                <div class="col-md-4 mb-4">
                    <h4 class="text-white mb-4 footer-heading">SUIVEZ-NOUS</h4>
                    <p class="small text-muted">Restez connectés aux plateformes de l'Université Don Bosco de Lubumbashi pour suivre toutes les activités académiques.</p>
                </div>
            </div>
            
            <hr class="bg-secondary">
            <div class="row pt-2">
                <div class="col-md-12 text-center">
                    <p class="small text-muted mb-0">&copy; 2026 UDBL. Tous droits réservés.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- SCRIPT DU REVEAL & DOCUMENTS ANCIENS -->
    <script>
    function reveal() {
      var reveals = document.querySelectorAll(".reveal");
      for (var i = 0; i < reveals.length; i++) {
        var windowHeight = window.innerHeight;
        var elementTop = reveals[i].getBoundingClientRect().top;
        var elementVisible = 100;
        if (elementTop < windowHeight - elementVisible) {
          reveals[i].classList.add("active");
        }
      }
    }
    window.addEventListener("scroll", reveal);
    reveal();

    function openDocModal(url, title) {
        document.getElementById('docPreviewIframe').src = url;
        if(title) document.getElementById('docPreviewTitle').innerText = title;
        if (typeof bootstrap !== 'undefined' && typeof bootstrap.Modal !== 'undefined') {
            var myModal = new bootstrap.Modal(document.getElementById('docPreviewModal'));
            myModal.show();
        } else if (typeof $ !== 'undefined') {
            $('#docPreviewModal').modal('show');
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
        var modalEl = document.getElementById('docPreviewModal');
        if(modalEl) {
            modalEl.addEventListener('hidden.bs.modal', function () { document.getElementById('docPreviewIframe').src = ''; });
        }
    });
    </script>

    <!-- INCLUSION DU CHATBOT (S'affiche partout) -->
    <?php  include __DIR__ .'/../../app/views/chatbot/chatbot.php'; ?>
    <script src="public/js/chatbot.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>