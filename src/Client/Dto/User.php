<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class User extends SpatieData
{
	public function __construct(
		#[MapName('auth_service')]
		public ?string $authService = null,
		#[MapName('create_at')]
		public ?int $createAt = null,
		#[MapName('delete_at')]
		public ?int $deleteAt = null,
		public ?string $email = null,
		#[MapName('email_verified')]
		public ?bool $emailVerified = null,
		#[MapName('failed_attempts')]
		public ?int $failedAttempts = null,
		#[MapName('first_name')]
		public ?string $firstName = null,
		public ?string $id = null,
		#[MapName('last_name')]
		public ?string $lastName = null,
		#[MapName('last_password_update')]
		public ?int $lastPasswordUpdate = null,
		#[MapName('last_picture_update')]
		public ?int $lastPictureUpdate = null,
		public ?string $locale = null,
		#[MapName('mfa_active')]
		public ?bool $mfaActive = null,
		public ?string $nickname = null,
		#[MapName('notify_props')]
		public ?UserNotifyProps $notifyProps = null,
		public ?object $props = null,
		public ?string $roles = null,
		#[MapName('terms_of_service_create_at')]
		public ?int $termsOfServiceCreateAt = null,
		#[MapName('terms_of_service_id')]
		public ?string $termsOfServiceId = null,
		public ?Timezone $timezone = null,
		#[MapName('update_at')]
		public ?int $updateAt = null,
		public ?string $username = null,
	) {
	}
}
