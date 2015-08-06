<?php

namespace CodeProject\Services;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectValidator;
use CodeProject\Repositories\ProjectMemberRepository;
use CodeProject\Validators\ProjectMemberValidator;
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

    /**
     * @var ProjectMemberRepository
     */
    protected $repositoryProjectMember;

    /**
     * @var ProjectMemberValidator
     */
    protected $validatorProjectMember;

    public function __construct(ProjectRepository $repository, ProjectValidator $validator, ProjectMemberRepository $repositoryProjectMember, ProjectMemberValidator $validatorProjectMember)
    {
        $this->repository = $repository;
        $this->validator = $validator;

        $this->repositoryProjectMember = $repositoryProjectMember;
        $this->validatorProjectMember = $validatorProjectMember;
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

    public function addMember(array $data)
    {
        try {
            $this->validatorProjectMember->with($data)->passesOrFail();
            return $this->repositoryProjectMember->create($data);
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

    public function removeMember($id, $id_user)
    {
        try {

            $this->repository->find($id)->members()->detach($id_user);

            return [
                'message' => 'User delete project success'
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

    public function allMember($id)
    {
        return $this->repositoryProjectMember->findWhere(['project_id' => $id])->all();
    }

    public function isMember($id, $id_user)
    {
        $data = $this->repositoryProjectMember->findWhere(['project_id' => $id, 'user_id' => $id_user])->all();

        if($data)
        {
            return [
                'message' => 'User is already member of the project'
            ];
        }
        else
        {
            return [
                'message' => 'User is not member of the project'
            ];
        }
    }

}