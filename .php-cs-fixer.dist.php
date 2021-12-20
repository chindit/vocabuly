<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('var')
;

return (new PhpCsFixer\Config())
    ->setRules([
		'@PSR12' => true,
        '@Symfony' => true,
		'array_syntax' => ['syntax' => 'short'],
		'cast_spaces' => ['space' => 'none'],
    ])
	->setFinder($finder)
;
