</main>
    <!-- Footer -->
    <footer class="footer-main py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="footer-brand d-flex align-items-center gap-3 mb-3">
                        <div class="logo-container">
                            <i class="fas fa-cheese fs-2"></i>
                        </div>
                        <div>
                            <h5 class="mb-0">Mundo Queso</h5>
                            <small>Sabores auténticos desde 1985</small>
                        </div>
                    </div>
                    <p class="mb-3">
                        Descubre los mejores quesos artesanales del mundo. 
                        Calidad, tradición y sabor en cada bocado.
                    </p>
                    <div class="social-links">
                        <a href="#" class="social-link me-3">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-link me-3">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="social-link me-3">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="social-link">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="mb-3">Navegación</h6>
                    <ul class="list-unstyled footer-links">
                        <li><a href="<?= BASE_URL ?>index.php">Inicio</a></li>
                        <li><a href="#">Productos</a></li>
                        <li><a href="#">Nosotros</a></li>
                        <li><a href="#">Contacto</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="mb-3">Categorías</h6>
                    <ul class="list-unstyled footer-links">
                        <li><a href="#">Quesos Frescos</a></li>
                        <li><a href="#">Quesos Curados</a></li>
                        <li><a href="#">Quesos Azules</a></li>
                        <li><a href="#">Especialidades</a></li>
                    </ul>
                </div>

                <div class="col-lg-4 mb-4">
                    <h6 class="mb-3">Contacto</h6>
                    <div class="contact-info">
                        <div class="contact-item mb-2">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            <span>Calle del Queso 123, Madrid, España</span>
                        </div>
                        <div class="contact-item mb-2">
                            <i class="fas fa-phone me-2"></i>
                            <span>+34 98 123 45 67</span>
                        </div>
                        <div class="contact-item mb-3">
                            <i class="fas fa-envelope me-2"></i>
                            <span>info@mundoqueso.es</span>
                        </div>
                    </div>

                    <!-- Newsletter -->
                    <div class="newsletter-signup">
                        <h6 class="mb-2">Newsletter</h6>
                        <form class="d-flex gap-2">
                            <input type="email" class="form-control form-control-sm" 
                                   placeholder="Tu email" required>
                            <button type="submit" class="btn btn-warning btn-sm">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <hr class="my-4 ">
            
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0">
                        &copy; <?php echo date("Y"); ?> <strong>Mundo Queso</strong>. 
                        Todos los derechos reservados.
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">
                        Diseñado con <i class="fas fa-heart text-danger"></i> por 
                        <strong>IsbelDTI</strong>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <?php if (isset($extra_scripts)): ?>
        <?= $extra_scripts ?>
    <?php endif; ?>
</body>
</html>
