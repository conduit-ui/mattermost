<?php

// Generated 2026-04-10 23:46:41

use ConduitUI\Mattermost\Client\Mattermost;
use ConduitUI\Mattermost\Client\Requests\Files\GetFile;
use ConduitUI\Mattermost\Client\Requests\Files\GetFileInfo;
use ConduitUI\Mattermost\Client\Requests\Files\GetFileLink;
use ConduitUI\Mattermost\Client\Requests\Files\GetFilePreview;
use ConduitUI\Mattermost\Client\Requests\Files\GetFilePublic;
use ConduitUI\Mattermost\Client\Requests\Files\GetFileThumbnail;
use ConduitUI\Mattermost\Client\Requests\Files\UploadFile;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;

beforeEach(function (): void {
    $this->mattermost = new Mattermost(
        bearerToken: 'replace'
    );
});

it('calls the uploadFile method in the Files resource', function (): void {
    Saloon::fake([
        UploadFile::class => MockResponse::fixture('files.uploadFile'),
    ]);

    $response = $this->mattermost->files()->uploadFile(
        channelId: 'test string',
        filename: 'test string'
    );

    Saloon::assertSent(UploadFile::class);

    expect($response->status())->toBe(200);
});

it('calls the getFile method in the Files resource', function (): void {
    Saloon::fake([
        GetFile::class => MockResponse::fixture('files.getFile'),
    ]);

    $response = $this->mattermost->files()->getFile(
        fileId: 'test string'
    );

    Saloon::assertSent(GetFile::class);

    expect($response->status())->toBe(200);
});

it('calls the getFileInfo method in the Files resource', function (): void {
    Saloon::fake([
        GetFileInfo::class => MockResponse::fixture('files.getFileInfo'),
    ]);

    $response = $this->mattermost->files()->getFileInfo(
        fileId: 'test string'
    );

    Saloon::assertSent(GetFileInfo::class);

    expect($response->status())->toBe(200);
});

it('calls the getFileLink method in the Files resource', function (): void {
    Saloon::fake([
        GetFileLink::class => MockResponse::fixture('files.getFileLink'),
    ]);

    $response = $this->mattermost->files()->getFileLink(
        fileId: 'test string'
    );

    Saloon::assertSent(GetFileLink::class);

    expect($response->status())->toBe(200);
});

it('calls the getFilePreview method in the Files resource', function (): void {
    Saloon::fake([
        GetFilePreview::class => MockResponse::fixture('files.getFilePreview'),
    ]);

    $response = $this->mattermost->files()->getFilePreview(
        fileId: 'test string'
    );

    Saloon::assertSent(GetFilePreview::class);

    expect($response->status())->toBe(200);
});

it('calls the getFilePublic method in the Files resource', function (): void {
    Saloon::fake([
        GetFilePublic::class => MockResponse::fixture('files.getFilePublic'),
    ]);

    $response = $this->mattermost->files()->getFilePublic(
        fileId: 'test string',
        h: 'test string'
    );

    Saloon::assertSent(GetFilePublic::class);

    expect($response->status())->toBe(200);
});

it('calls the getFileThumbnail method in the Files resource', function (): void {
    Saloon::fake([
        GetFileThumbnail::class => MockResponse::fixture('files.getFileThumbnail'),
    ]);

    $response = $this->mattermost->files()->getFileThumbnail(
        fileId: 'test string'
    );

    Saloon::assertSent(GetFileThumbnail::class);

    expect($response->status())->toBe(200);
});
