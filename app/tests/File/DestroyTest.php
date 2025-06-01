<?php

declare(strict_types=1);

namespace App\Tests\File;

use App\Admin\Domain\Enums\FileMimeType;
use App\Common\Domain\Entity\File;
use App\Tests\ApiTestCase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DestroyTest extends ApiTestCase
{
    public function testDestroySuccessfully(): void
    {
        $user = $this->createUser();
        $this->login($user->getEmail(), self::DEFAULT_USER_PASSWORD);

        $file = $this->createFile();
        $entityManagerInterface = self::getContainer()->get(EntityManagerInterface::class);
        $entityManagerInterface->persist($file);
        $entityManagerInterface->flush();

        $createdFile = $entityManagerInterface->getRepository(File::class)->find($file->getId());
        $this->assertNotNull($createdFile);

        $id = $createdFile->getId();
        $this->sendJsonRequest(Request::METHOD_DELETE, "/api/admin/files/$id");
        $this->assertJsonResponse($this->client->getResponse(), Response::HTTP_OK);
        $this->assertIsApiResponse($this->getJsonResponseData());

        $destroyedFile = $entityManagerInterface->getRepository(File::class)->find($file->getId());
        $this->assertNull($destroyedFile);
    }

    private function createFile(): File
    {
        $file = new File();
        $file->setName('T-shirt');
        $file->setOriginalName('Shirt');
        $file->setPath("path/to/file");
        $file->setMimeType(FileMimeType::JPEG);
        $file->setSize(12456);

        return $file;
    }

    public function testDestroyFailed(): void
    {
        $user = $this->createUser();
        $this->login($user->getEmail(), self::DEFAULT_USER_PASSWORD);

        $this->sendJsonRequest(Request::METHOD_DELETE, "/api/admin/files/2");

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }
}
