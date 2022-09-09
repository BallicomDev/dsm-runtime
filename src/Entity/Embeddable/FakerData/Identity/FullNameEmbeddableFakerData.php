<?php

declare(strict_types=1);

namespace LTS\DsmRuntime\Entity\Embeddable\FakerData\Identity;

use LTS\DsmRuntime\Entity\Embeddable\Objects\Identity\FullNameEmbeddable;
use LTS\DsmRuntime\Entity\Fields\FakerData\AbstractFakerDataProvider;

class FullNameEmbeddableFakerData extends AbstractFakerDataProvider
{
    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function __invoke()
    {
        return FullNameEmbeddable::create(
            [
                FullNameEmbeddable::EMBEDDED_PROP_TITLE       => $this->generator->title,
                FullNameEmbeddable::EMBEDDED_PROP_FIRSTNAME   => $this->generator->firstName,
                FullNameEmbeddable::EMBEDDED_PROP_MIDDLENAMES => [
                    $this->generator->firstName,
                    $this->generator->firstName,
                ],
                FullNameEmbeddable::EMBEDDED_PROP_LASTNAME    => $this->generator->lastName,
                FullNameEmbeddable::EMBEDDED_PROP_SUFFIX      => $this->generator->jobTitle,
            ]
        );
    }
}
