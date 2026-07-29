<?php
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$updateChecker = PucFactory::buildUpdateChecker(
  'https://github.com/emamut-dev/kudi-shift/',
  __FILE__,
  'kudi-shift'
);

// Si el repositorio es privado:
$updateChecker->setAuthentication('TU_TOKEN_GITHUB');

// Si usas la rama main:
$updateChecker->setBranch('master');