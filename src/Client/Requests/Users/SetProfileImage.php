<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Users;

use InvalidArgumentException;
use RuntimeException;
use Saloon\Contracts\Body\HasBody;
use Saloon\Data\MultipartValue;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasMultipartBody;
use SplFileInfo;

/**
 * SetProfileImage
 *
 * Set a user's profile image using a multipart upload to
 * `POST /api/v4/users/{user_id}/image`. Mattermost rejects bot tokens here
 * for the bot's own account — call this on a connection that has been
 * configured with an admin-grade token.
 */
class SetProfileImage extends Request implements HasBody
{
    use HasMultipartBody;

    protected Method $method = Method::POST;

    /**
     * @param  string  $userId  Target user GUID.
     * @param  string|SplFileInfo|resource  $image  File path, SplFileInfo, or open stream resource.
     * @param  string|null  $filename  Filename sent to the server. Inferred when a path/SplFileInfo is given.
     */
    public function __construct(
        protected string $userId,
        protected mixed $image,
        protected ?string $filename = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/api/v4/users/{$this->userId}/image";
    }

    /**
     * @return array<int, MultipartValue>
     */
    protected function defaultBody(): array
    {
        return [new MultipartValue('image', $this->resolveStream(), $this->resolveFilename())];
    }

    /**
     * @return resource
     */
    private function resolveStream(): mixed
    {
        if (is_resource($this->image)) {
            return $this->image;
        }

        if ($this->image instanceof SplFileInfo) {
            return $this->openPath($this->image->getPathname());
        }

        if (is_string($this->image)) {
            return $this->openPath($this->image);
        }

        throw new InvalidArgumentException('Profile image must be a file path, SplFileInfo, or resource.');
    }

    private function resolveFilename(): string
    {
        if ($this->filename !== null) {
            return $this->filename;
        }

        if ($this->image instanceof SplFileInfo) {
            return $this->image->getFilename();
        }

        if (is_string($this->image)) {
            return basename($this->image);
        }

        return 'profile-image';
    }

    /**
     * @return resource
     */
    private function openPath(string $path): mixed
    {
        if (! is_file($path)) {
            throw new InvalidArgumentException("Profile image file not found: {$path}");
        }

        $handle = @fopen($path, 'rb');

        if ($handle === false) {
            throw new RuntimeException("Could not open profile image: {$path}");
        }

        return $handle;
    }
}
