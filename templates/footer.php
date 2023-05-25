    <footer id="footer">
        <div id="social-container">
            <ul>
                <li>
                    <a href=""><i class="fab fa-facebook-square"></i></a>
                </li>
                <li>
                    <a href=""><i class="fab fa-instagram-square"></i></a>
                </li>
                <li>
                    <a href=""><i class="fab fa-youtube-square"></i></a>
                </li>
            </ul>
        </div>
        <div id="footer-links-container">
            <ul>
                <li><a href="newmovie.php">Adicionar Filmes</a></li>
                <li><a href="">Adicionar crítica</a></li>
                <li><a href="auth.php">Entrar / Registrar</a></li>
            </ul>
        </div>
        <p>&copy; 2023 ByWilliams</p>
    </footer>
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function show_password() {
            var password = document.getElementById('password_register');
            var confirmPassword = document.getElementById('confirmPassword_register');
            
            (password.type == "password") ? password.type = "text" : password.type = "password";

            (confirmPassword.type == "password") ? confirmPassword.type = "text" : confirmPassword.type = "password";
        }
    </script>
</body>

</html>