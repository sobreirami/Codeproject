<?php

namespace CodeProject\Services;

use CodeProject\Repositories\ClientRepository;
use CodeProject\Validators\ClientValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prettus\Validator\Exceptions\ValidatorException;

class ClientService
{
    /**
     * @var ClientRepository
     */
    protected $repository;

    /**
     * @var ClientValidator
     */
    protected $validator;

    public function __construct(ClientRepository $repository, ClientValidator $validator)
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
            return $this->repository->with(['project'])->find($id);
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
                'message' => 'Delete client success'
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

    public function index()
    {
        return  $this->repository->with(['project'])->all();
    }
}