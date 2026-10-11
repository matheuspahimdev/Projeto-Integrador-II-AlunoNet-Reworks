<?php

if (!function_exists('renderHeaderAcademic')) {
    function renderHeaderAcademic(string $title): void
    {
        $safeTitle = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
?>
        <section class="hero-header-pages d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h1 class="display-6"><?= $safeTitle ?></h1>
                <p class="text-secondary mb-0">Central Acadêmica • Engenharia de Software • 2026/2</p>
            </div>
            <a class="btn btn-outline-primary" href="centralAcademico.php"><i class="bi bi-arrow-left me-1"></i>Central Acadêmica</a>
        </section>
<?php
    }
}

?>