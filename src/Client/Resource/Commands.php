<?php

namespace ConduitUI\Mattermost\Client\Resource;

use ConduitUI\Mattermost\Client\Requests\Commands\CreateCommand;
use ConduitUI\Mattermost\Client\Requests\Commands\DeleteCommand;
use ConduitUI\Mattermost\Client\Requests\Commands\ExecuteCommand;
use ConduitUI\Mattermost\Client\Requests\Commands\GetCommandById;
use ConduitUI\Mattermost\Client\Requests\Commands\ListAutocompleteCommands;
use ConduitUI\Mattermost\Client\Requests\Commands\ListCommands;
use ConduitUI\Mattermost\Client\Requests\Commands\MoveCommand;
use ConduitUI\Mattermost\Client\Requests\Commands\RegenCommandToken;
use ConduitUI\Mattermost\Client\Requests\Commands\UpdateCommand;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

class Commands extends BaseResource
{
	/**
	 * @param string $teamId The team id.
	 * @param bool $customOnly To get only the custom commands. If set to false will get the custom
	 * if the user have access plus the system commands, otherwise just the system commands.
	 */
	public function listCommands(?string $teamId = null, ?bool $customOnly = null): Response
	{
		return $this->connector->send(new ListCommands($teamId, $customOnly));
	}


	public function createCommand(): Response
	{
		return $this->connector->send(new CreateCommand());
	}


	public function executeCommand(): Response
	{
		return $this->connector->send(new ExecuteCommand());
	}


	/**
	 * @param string $commandId ID of the command to get
	 */
	public function getCommandById(string $commandId): Response
	{
		return $this->connector->send(new GetCommandById($commandId));
	}


	/**
	 * @param string $commandId ID of the command to update
	 */
	public function updateCommand(string $commandId): Response
	{
		return $this->connector->send(new UpdateCommand($commandId));
	}


	/**
	 * @param string $commandId ID of the command to delete
	 */
	public function deleteCommand(string $commandId): Response
	{
		return $this->connector->send(new DeleteCommand($commandId));
	}


	/**
	 * @param string $commandId ID of the command to move
	 */
	public function moveCommand(string $commandId): Response
	{
		return $this->connector->send(new MoveCommand($commandId));
	}


	/**
	 * @param string $commandId ID of the command to generate the new token
	 */
	public function regenCommandToken(string $commandId): Response
	{
		return $this->connector->send(new RegenCommandToken($commandId));
	}


	/**
	 * @param string $teamId Team GUID
	 */
	public function listAutocompleteCommands(string $teamId): Response
	{
		return $this->connector->send(new ListAutocompleteCommands($teamId));
	}
}
