<?php

function carregar($classe)
{
    $diretorio = new RecursiveDirectoryIterator(
        __DIR__ . '/backend',
        RecursiveDirectoryIterator::SKIP_DOTS
    );

    $arquivos = new RecursiveIteratorIterator($diretorio);

    foreach ($arquivos as $arquivo) {
        if ($arquivo->getFilename() == $classe . '.php') {
            require_once $arquivo->getPathname();
            return;
        }
    }
}

spl_autoload_register('carregar');
