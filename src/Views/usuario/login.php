<?php if (!isset($_SESSION['identity'])): ?>
    <h2>Login</h2>
    <?php
    if (isset($_SESSION['login']) && $_SESSION['login'] === 'failed' && isset($_SESSION['login_error'])) {
        echo '<div class="error-message">' . $_SESSION['login_error'] . '</div>';
    }
    ?>
    <form action="<?= BASE_URL ?>Usuario/login" method="POST">
        <label for="email">Email</label>
        <input type="email" name="data[email]" id="email">
        <label for="password">Contraseña</label>
        <input type="password" name="data[password]" id="password">
        <input type="submit" value="Enviar">
    </form>
    <?php endif; ?>