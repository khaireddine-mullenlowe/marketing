<?php


namespace MarketingBundle\Service;


use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class UploadInvitationVisualService
 * @package MarketingBundle\Service
 */
class UploadInvitationVisualService
{
    const PATH_TO_UPLOAD = 'img/invitation/';

    /**
     * @var string $storagePath
     */
    private $storagePath;

    /**
     * UploadInvitationVisualService constructor.
     * @param $storagePath
     */
    public function __construct($storagePath)
    {
        $this->storagePath = $storagePath;
    }

    /**
     * @param UploadedFile $uploadedFile
     * @return \Symfony\Component\HttpFoundation\File\File
     * @throws \Exception
     */
    public function uploadVisual(UploadedFile $uploadedFile)
    {
        $pathToUpload = sprintf('%s/%s', $this->storagePath, self::PATH_TO_UPLOAD);

        try {
            $uploadFileResponse = $uploadedFile->move($pathToUpload, $uploadedFile->getClientOriginalName());
        } catch (FileException $e) {
            throw new \Exception(sprintf('Unable to move %s to %s', $uploadedFile, $pathToUpload));
        }

        return $uploadFileResponse;
    }
}
