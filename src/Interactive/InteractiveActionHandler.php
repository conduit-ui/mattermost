<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Interactive;

/**
 * Base class for interactive action handler classes.
 *
 * Subclass this and implement `handle()` to return a response. The router
 * resolves handlers from the container so constructor DI is available.
 *
 *   class ApproveHandler extends InteractiveActionHandler {
 *       public function handle(InteractiveAction $action): InteractiveActionResponse {
 *           return InteractiveActionResponse::make()->update('Approved!');
 *       }
 *   }
 */
abstract class InteractiveActionHandler
{
    /**
     * Handle the incoming interactive action and return a response.
     */
    abstract public function handle(InteractiveAction $action): InteractiveActionResponse;
}
