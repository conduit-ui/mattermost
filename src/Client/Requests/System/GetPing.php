<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\System;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetPing
 *
 * Check if the server is up and healthy based on the configuration setting `GoRoutineHealthThreshold`.
 * If `GoRoutineHealthThreshold` and the number of goroutines on the server exceeds that threshold the
 * server is considered unhealthy. If `GoRoutineHealthThreshold` is not set or the number of goroutines
 * is below the threshold the server is considered healthy.
 * __Minimum server version__: 3.10
 * If a
 * "device_id" is passed in the query, it will test the Push Notification Proxy in order to discover
 * whether the device is able to receive notifications. The response will have a
 * "CanReceiveNotifications" property with one of the following values: - true: It can receive
 * notifications - false: It cannot receive notifications - unknown: There has been an unknown error,
 * and it is not certain whether it can
 *   receive notifications.
 *
 * __Minimum server version__: 6.5
 * #####
 * Permissions
 * None.
 */
class GetPing extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/api/v4/system/ping';
    }

    /**
     * @param  null|bool  $getServerStatus  Check the status of the database and file storage as well
     * @param  null|string  $deviceId  Check whether this device id can receive push notifications
     */
    public function __construct(
        protected ?bool $getServerStatus = null,
        protected ?string $deviceId = null,
    ) {}

    public function defaultQuery(): array
    {
        return array_filter(['get_server_status' => $this->getServerStatus, 'device_id' => $this->deviceId]);
    }
}
