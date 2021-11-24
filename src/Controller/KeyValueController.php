<?php

namespace App\Controller;

use App\Repository\KvKeyValueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class KeyValueController extends AbstractController
{
    #[Route('/', name: 'get_keys_without_group')]
    public function getKeysWithoutGroup(KvKeyValueRepository $keyValueRepository): Response
    {
        return $this->json($keyValueRepository->findAll());
    }
}
