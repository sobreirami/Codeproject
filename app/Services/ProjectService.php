<?php

namespace CodeProject\Services;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectValidator;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProjectService
{
    /**
     * @var ProjectRepository
     */
    protected $repository;

    /**
     * @var ProjectValidator
     */
    protected $validator;

    public function __construct(ProjectRepository $repository, ProjectValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function create(array $data)
    {
        try {
            $this->validator->with($data)->passesOrFail();
            return $this->repository->create($data);
        }
        catch(ValidatorException $e) {
            return [
                'error' => true,
                'message' => $e->getMessageBag()
            ];
        }
        catch(ModelNotFoundException $e) {
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }

    public function update(array $data, $id)
    {
        try {
            $this->validator->with($data)->passesOrFail();
            return $this->repository->update($data, $id);
        }
        catch(ValidatorException $e) {
            return [
                'error' => true,
                'message' => $e->getMessageBag()
            ];
        }
        catch(ModelNotFoundException $e) {
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }

    }

    public function show($id)
    {
        try {
            return $this->repository->with(['owner', 'client', 'notes', 'tasks', 'members'])->find($id);
        }
        catch(ModelNotFoundException $e) {
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }

    public function delete($id)
    {
        try {
            $this->repository->delete($id);

            return [
                'message' => 'Delete project success'
            ];
        }
        catch(\PDOException $e) {
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
        catch(ModelNotFoundException $e) {
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }
}