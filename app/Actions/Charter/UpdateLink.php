<?php

namespace App\Actions\Charter;

use App\Contracts\UpdatesLink;

class UpdateLink implements UpdatesLink
{

    public function update($user, $link, $input)
    {
        $link->update($input);
    }
}
