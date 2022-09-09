<?php

declare(strict_types=1);

namespace LTS\DsmRuntime\Entity\Fields\FakerData\String;

use LTS\DsmRuntime\Entity\Fields\FakerData\AbstractFakerDataProvider;

class JsonDataFakerData extends AbstractFakerDataProvider
{
    public function __invoke()
    {
        $dataArray = [
            'email' => $this->generator->email,
            'name'  => $this->generator->name,
        ];

        return json_encode($dataArray);
    }
}
