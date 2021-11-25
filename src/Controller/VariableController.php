<?php

namespace App\Controller;

use App\Entity\Space;
use App\Entity\Variable;
use App\Form\Model\SpaceForm;
use App\Form\Model\VariableForm;
use App\Form\SpaceType;
use App\Form\VariableType;
use App\Repository\SpaceRepository;
use App\Repository\VariableRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VariableController extends AbstractController
{
    #[Route('/{spaceName}', name: 'get_variables', methods: ['GET'])]
    #[ParamConverter('space', options: ['mapping' => ['spaceName' => 'name']])]
    public function getVariables(VariableRepository $variableRepository, Space $space): Response
    {
        $variables = $variableRepository->findBy(
            ['space' => $space],
            ['key' => 'ASC'],
        );

        $output = '';

        /** @var Variable $variable */
        foreach ($variables as $variable) {
            $output .= $variable->getKey() . "=" . $variable->getValue()."\r\n";
        }

        $response = new Response($output);
        $response->headers->set('Content-Type', 'text/plain');
        return $response;
    }

    #[Route('/', name: 'post_space', methods: ['POST'])]
    public function postSpace(Request $request, SpaceRepository $spaceRepository): Response
    {
        $form = $this->createForm(SpaceType::class);
        $form->submit(json_decode($request->getContent(), true));

        if (true === $form->isValid()) {
            /** @var SpaceForm $spaceData */
            $spaceData = $form->getData();
            $space = new Space($spaceData->name);

            $existingSpace = $spaceRepository->findOneBy(['name' => $space->getName()]);

            if ($existingSpace instanceof Space) {
                return $this->json(['error' => ' Space already exist'], Response::HTTP_CONFLICT);
            }

            $spaceRepository->save($space);

            return $this->json($space);
        } else {
            return $this->json($this->getErrorsFromForm($form));
        }
    }

    #[Route('/{spaceName}', name: 'put_space', methods: ['PUT'])]
    #[ParamConverter('space', options: ['mapping' => ['spaceName' => 'name']])]
    public function putSpace(Request $request, SpaceRepository $spaceRepository, Space $space): Response
    {
        $form = $this->createForm(SpaceType::class);
        $form->submit(json_decode($request->getContent(), true));

        if (true === $form->isValid()) {
            /** @var SpaceForm $spaceData */
            $spaceData = $form->getData();
            $space->setName($spaceData->name);
            $spaceRepository->save($space);

            return $this->json($space);
        } else {
            return $this->json($this->getErrorsFromForm($form));
        }
    }

    #[Route('/{spaceName}/{variableKey}', name: 'get_variable', methods: ['GET'])]
    public function getVariable(
        SpaceRepository $spaceRepository,
        VariableRepository $variableRepository,
        string $spaceName,
        string $variableKey
    ): Response
    {
        $space = $spaceRepository->findOneBy(['name' => $spaceName]);

        if (false === $space instanceof Space) {
            return $this->json(['error' => 'Space not found'], Response::HTTP_NOT_FOUND);
        }

        $variable = $variableRepository->findOneBy([
            'space' => $space,
            'key' => $variableKey
        ]);

        if (false === $variable instanceof Variable) {
            return $this->json(['error' => 'Variable not found'], Response::HTTP_NOT_FOUND);
        }

        $response = new Response($variable->getValue());
        $response->headers->set('Content-Type', 'text/plain');

        return $response;
    }

    #[Route('/{spaceName}', name: 'post_variable', methods: ['POST'])]
    #[ParamConverter('space', options: ['mapping' => ['spaceName' => 'name']])]
    public function postVariable(Request $request, SpaceRepository $spaceRepository, VariableRepository $variableRepository, string $spaceName): Response
    {
        $space = $spaceRepository->findOneBy(['name' => $spaceName]);

        if (false === $space instanceof Space) {
            return $this->json(['error' => 'Space not found'], Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(VariableType::class);
        $form->submit(json_decode($request->getContent(), true));

        if (true === $form->isValid()) {
            /** @var VariableForm $variableData */
            $variableData = $form->getData();
            $variable = new Variable($space, $variableData->key, $variableData->value);

            $existingVariable = $variableRepository->findOneBy([
                'space' => $variable->getSpace(),
                'key' => $variable->getKey()
            ]);

            if ($existingVariable instanceof Variable) {
                return $this->json(['error' => ' Variable already exist'], Response::HTTP_CONFLICT);
            }

            $variableRepository->save($variable);

            return $this->json($variable);
        } else {
            return $this->json($this->getErrorsFromForm($form));
        }
    }

    #[Route('/{spaceName}/{variableKey}', name: 'put_variable', methods: ['PUT'])]
    public function putVariable(
        Request $request,
        SpaceRepository $spaceRepository,
        VariableRepository $variableRepository,
        string $spaceName,
        string $variableKey
    ): Response
    {
        $space = $spaceRepository->findOneBy(['name' => $spaceName]);

        if (false === $space instanceof Space) {
            return $this->json(['error' => 'Space not found'], Response::HTTP_NOT_FOUND);
        }

        $variable = $variableRepository->findOneBy([
            'space' => $space,
            'key' => $variableKey
        ]);

        if (false === $variable instanceof Variable) {
            return $this->json(['error' => 'Variable not found'], Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(VariableType::class);
        $form->submit(json_decode($request->getContent(), true));

        if (true === $form->isValid()) {
            /** @var VariableForm $variableData */
            $variableData = $form->getData();
            $variable->setKey($variableData->key)
                ->setValue($variableData->value);

            $variableRepository->save($variable);

            return $this->json($variable);
        } else {
            return $this->json($this->getErrorsFromForm($form));
        }
    }

    private function getErrorsFromForm(FormInterface $form): array
    {
        $errors = [];

        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }

        foreach ($form->all() as $childForm) {
            if ($childForm instanceof FormInterface) {
                if ($childErrors = $this->getErrorsFromForm($childForm)) {
                    $errors[$childForm->getName()] = $childErrors;
                }
            }
        }

        return $errors;
    }
}
