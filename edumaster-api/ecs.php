<?php

use CodelyTv\CodingStyle;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return function (ECSConfig $ecsConfig): void {
  $ecsConfig->paths([
    __DIR__ . '/src',
    __DIR__ . '/app',
    __DIR__ . '/tests',
  ]);

  $ecsConfig->sets([CodingStyle::DEFAULT]);
  $ecsConfig->skip([
    // PhpCsFixer\Fixer\ClassNotation\FinalClassFixer::class,
    // PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer::class,
  ]);

  // Or this if you prefer to have the code aligned
  // $ecsConfig->sets([CodingStyle::ALIGNED]);
};
