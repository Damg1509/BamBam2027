<!DOCTYPE html>
<html lang="<?= e($settings['language'] ?? 'es-CL') ?>" data-theme="light" data-font-size="small" data-contrast="normal">
    <?php
    $baseUrl = $settings['url'] ?? '';
    $defaultImg = $settings['image'] ?? 'og-default.jpg';
    $fallbackOgImage = $baseUrl !== '' ? $baseUrl . '/img/' . $defaultImg : '/img/' . $defaultImg;
    ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title><?= e($pageTitle ?? $settings['title'] ?? 'Jardín Infantil BamBam') ?></title>
    <meta name="description" content="<?= e($description ?? $settings['description'] ?? '') ?>">
    <meta name="author" content="<?= e($settings['author'] ?? 'Jardin Infantil BamBam') ?>">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <link rel="canonical" href="<?= e($canonicalUrl ?? $settings['url'] ?? '') ?>">
    <!-- Open Graph / Facebook / WhatsApp (Dinámico por página) -->
    <meta property="og:type" content="<?=  e($ogType ?? 'website') ?>">
    <meta property="og:url" content="<?= e($canonicalUrl ?? $settings['url'] ?? '') ?>">
    <meta property="og:title" content="<?= e($pageTitle ?? $settings['title'] ?? '') ?>">
    <meta property="og:description" content="<?= e($description ?? $settings['description'] ?? '') ?>">
    <meta property="og:site_name" content="<?= e($settings['title'] ?? 'Jardín Infantil BamBam') ?>">
    <meta property="og:locale" content="<?= e(str_replace('-', '_', $settings['lang'] ?? 'es_CL')) ?>">
    <meta property="og:image" content="<?= e($ogImage ?? $fallbackOgImage) ?>">
    <meta property="og:image:width" content="<?= e($settings['imageWidth'] ?? '1200') ?>">
    <meta property="og:image:height" content="<?= e($settings['imageHeight'] ?? '630') ?>">
    <!-- WPO: Precarga y Fuentes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Hojas de Estilo del Proyecto -->
    <link rel="stylesheet" href="/css/styles.css">
    <?php
    if(!empty($settings['fonts']) && is_array($settings['fonts'])){
        foreach($settings['fonts'] as $fontUrl){
            echo "<link rel=\"stylesheet\" href=\"$fontUrl\">";
        }
    }
    ?>
    <!-- Google Analitycs 4 (GA4) -->
    <?php if(!empty($settings['analytics'])): ?>
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?= e($settings['analytics']) ?>"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '<?= e($settings['analytics']) ?>', {
                'anonymize_ip': true,
                'send_page_view': true
            });
        </script>
    <?php endif; ?>
</head>