<?php
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$updateChecker = PucFactory::buildUpdateChecker(
  'https://github.com/tuusuario/tu-plugin',
  __FILE__,
  'tu-plugin'
);

// Si el repositorio es privado:
$updateChecker->setAuthentication('TU_TOKEN_GITHUB');

// Si usas la rama main:
$updateChecker->setBranch('main');