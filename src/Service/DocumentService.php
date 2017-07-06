<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 28.08.14
 * Time: 18:09
 */
namespace Lib\Service {

    use Zend\Diactoros\UploadedFile;
    use Zend\Form\Form;
    use Zend\File\Transfer;
    use Zend\Hydrator\ClassMethods;
    use Zend\Validator\File as Validator;
    use Zend\Filter\File as Filter;

    use Zend\View\Model\JsonModel;
    use Zend\View\Model\ViewModel;

    use Lib\Entity;
    use Lib\Entity\Document;

    /**
     * Class DocumentService
     * @package Lib\Service
     */
    class DocumentService extends ServiceAbstract
    {
        /**
         * Edit article
         * @param Document $document
         * @return JsonModel|ViewModel
         */
        public function edit(Document $document)
        {
            /** @var Form $form */
            $form = $this->createForm($document);

            $saved = [];
            if ($this->getRequest()->isPost()) {
                try {
                    $data = $this->params()
                        ->fromPost();

                    $form->setData($data);
                    if (!$form->isValid()) {
                        throw new \InvalidArgumentException(
                            serialize($form->getMessages())
                        );
                    }

                    foreach ($this->params()->fromFiles('file') as $info) {

                        $file = new Entity\File;
                        $file->setName($info['name'])
                            ->setIndex($document->getFiles()->count())
                            ->setType($info['type'])->setSize($info['size'])
                            ->setDescription($info['name']);

                        try {

                            $dir = $file->getDirectory();
                            if (!file_exists($dir)) {
                                mkdir($dir, 0777, true);
                            }

                            /** @var UploadedFile $adapter */
                            $uploader = new UploadedFile($info['tmp_name'], $info['size'], $info['error'], $info['name'], $info['type']);
                            $uploader->moveTo($file->getRealLocation());

                            if ($uploader->getError()) {
                                throw new \InvalidArgumentException(
                                    sprintf("File '%s' wasnt save: %s", $info['name'],
                                        implode("<br/>", $uploader->getError()))
                                );
                            }

                            $mime = new Validator\MimeType;
                            $mime->addMimeType(['image', 'application', 'text'])
                                ->enableHeaderCheck(true)
                                ->setMagicFile(false);

                            if (!$mime->isValid($file->getRealLocation(), $info)) {
                                throw new \InvalidArgumentException(
                                    implode("<br/>", $mime->getMessages())
                                );
                            }

                            $document->addFiles($file);

                            $saved[$file->getIndex()] = [
                                'thumbnail' => $file->getPreview(),
                                'status' => 'success',
                            ];

                        } catch (\Exception $ex) {
                            $saved[$file->getIndex()] = [
                                'status' => 'error',
                                'message' => $ex->getMessage(),
                                'trace' => $ex->getTraceAsString(),
                            ];
                        }
                    }

                    $em = $this->getEntityManager();
                    if (!$document->getId()) {
                        $exp = $em->getExpressionBuilder();
                        $q = $em->createQueryBuilder()->select($exp->max('i.index'))
                            ->from(get_class($document), 'i')
                            ->getQuery();

                        $max = intval($q->getSingleScalarResult());
                        $document->setIndex(++$max);
                    }

                    $em->persist($document);
                    $em->flush();

                    /** @var Entity\File $attachment */
                    foreach ($document->getFiles() as $attachment) {
                        if (isset($saved[$attachment->getIndex()])) {
                            $saved[$attachment->getIndex()] += $attachment->toArray();
                        }
                    }

                    ksort($saved);
                    return new JsonModel([
                        "status" => "success",
                        "data" => [
                            "message" => "Changes saved",
                            "files" => $saved ?: null
                        ]
                    ]);

                } catch (\Exception $ex) {

                    return new JsonModel([
                        "status" => "error",
                        "data" => [
                            "message" => $ex->getMessage(),
                            "trace" => $ex->getTraceAsString(),
                            "files" => array_map(function ($item) {
                                return array_merge($item, ['status' => 'error', 'message' => '']);
                            }, $saved)
                        ]
                    ]);
                }
            }

            /** @var  $viewModel */
            $viewModel = new ViewModel;
            $viewModel->setVariable('routeParams', $this->getRouteMatch()->getParams())
                ->setVariable('form', $form);

            return $viewModel;
        }
    }
}