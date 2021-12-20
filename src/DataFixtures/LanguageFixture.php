<?php

namespace App\DataFixtures;

use App\Entity\Language;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LanguageFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $languages = [
            'deu' => 'Allemand',
            'dnk' => 'Danois',
            'esp' => 'Espagnol',
            'fin' => 'Finlandais',
            'fra' => 'Français',
            'grc' => 'Grec',
            'ind' => 'Hindi',
            'ita' => 'Italien',
            'jpn' => 'Japonais',
            'kor' => 'Coréen',
            'nld' => 'Néerlandais',
            'nor' => 'Norvégien',
            'prt' => 'Portuguais',
            'rus' => 'Russe',
        ];

        foreach ($languages as $iso => $name) {
            $language = (new Language())
                ->setIso($iso)
                ->setName($name);

            $manager->persist($language);
        }

        $manager->flush();
    }
}
