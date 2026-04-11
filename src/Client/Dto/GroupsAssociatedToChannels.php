<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Data as SpatieData;

/**
 * a map of channel id(s) to the set of groups that constrain the corresponding channel in a team
 */
class GroupsAssociatedToChannels extends SpatieData {}
