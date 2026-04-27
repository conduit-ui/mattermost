<?php

declare(strict_types=1);

use ConduitUI\Mattermost\Client\Requests\Users\SetProfileImage;
use ConduitUI\Mattermost\Facades\Mattermost;
use Saloon\Data\MultipartValue;
use Saloon\Http\Faking\MockResponse;

describe('Users::updateProfilePhoto()', function (): void {
    beforeEach(function (): void {
        $this->fixture = sys_get_temp_dir().'/mm-avatar-'.bin2hex(random_bytes(4)).'.png';
        // 1×1 transparent PNG
        file_put_contents($this->fixture, base64_decode(
            'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR4nGNgYGD4DwABBAEAfbLI3wAAAABJRU5ErkJggg==',
        ));
    });

    afterEach(function (): void {
        if (isset($this->fixture) && is_file($this->fixture)) {
            unlink($this->fixture);
        }
    });

    it('sends a multipart POST to /users/{id}/image with field name "image"', function (): void {
        Mattermost::fake([
            SetProfileImage::class => MockResponse::make([], 200),
        ]);

        Mattermost::users()->updateProfilePhoto('user-1', $this->fixture);

        Mattermost::assertProfilePhotoUpdated('user-1', function ($record): bool {
            $body = $record->request->body();
            $values = $body->all();

            expect($values)->toHaveCount(1);
            expect($values[0])->toBeInstanceOf(MultipartValue::class);
            expect($values[0]->name)->toBe('image');
            expect($values[0]->filename)->toBe(basename($this->fixture));

            return $record->method === 'POST'
                && str_ends_with($record->url, '/api/v4/users/user-1/image');
        });
    });

    it('accepts an SplFileInfo as the image source', function (): void {
        Mattermost::fake();

        Mattermost::users()->updateProfilePhoto('user-2', new SplFileInfo($this->fixture));

        Mattermost::assertProfilePhotoUpdated('user-2', function ($record): bool {
            $values = $record->request->body()->all();

            return $values[0]->filename === basename($this->fixture);
        });
    });

    it('accepts an open stream resource', function (): void {
        Mattermost::fake();

        $stream = fopen($this->fixture, 'rb');
        Mattermost::users()->updateProfilePhoto('user-3', $stream, 'avatar.png');

        Mattermost::assertProfilePhotoUpdated('user-3', function ($record): bool {
            $values = $record->request->body()->all();

            return is_resource($values[0]->value) && $values[0]->filename === 'avatar.png';
        });
    });

    it('throws when the file path does not exist', function (): void {
        Mattermost::fake();

        expect(fn () => Mattermost::users()->updateProfilePhoto('user-4', '/nonexistent/avatar.png'))
            ->toThrow(InvalidArgumentException::class, 'Profile image file not found');
    });

    it('routes through a named admin connection without touching the default', function (): void {
        config(['mattermost.connections.admin' => [
            'url' => 'https://fake.mattermost.test',
            'token' => 'admin-token',
        ]]);

        $fake = Mattermost::fake();

        Mattermost::connection('admin')->users()->updateProfilePhoto('user-5', $this->fixture);

        $fake->assertProfilePhotoUpdated('user-5');

        $records = $fake->recorded(SetProfileImage::class);
        expect($records[0]->connection)->toBe('admin');
    });
});

describe('Users::deleteProfilePhoto()', function (): void {
    it('sends a DELETE to /users/{id}/image', function (): void {
        Mattermost::fake();

        Mattermost::users()->deleteProfilePhoto('user-9');

        Mattermost::assertProfilePhotoReset('user-9', function ($record): bool {
            return $record->method === 'DELETE'
                && str_ends_with($record->url, '/api/v4/users/user-9/image');
        });
    });
});
