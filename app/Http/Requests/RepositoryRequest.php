<?php

namespace App\Http\Requests;

use App\Services\RepositoryService\RepositoryService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RepositoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->is_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(RepositoryService $repositoryService)
    {
        return [
            'name' => [
                'required',
                function ($attribute, $name, $fail) use ($repositoryService) {
                    /*
                     * Technically, this will fail if the repository name is changed
                     * to a name that doesn't result in a slug change. However, this
                     * code is already a bit silly to write since it'll likely never
                     * be triggered. If this ever becomes a problem, store the slug in
                     * the database, or as a workaround, simply change the name to
                     * something that results in a slug change and then change it again
                     * to whatever you want.
                     */
                    if (
                        (!isset($this->repository) || $this->repository->name !== $name) &&
                        $repositoryService->doesRepositoryDirectoryExist($name)
                    ) {
                        $fail('The repository cannot share a slug with another repository');
                    }
                },
            ],
            'url' => 'required',
            'website' => 'nullable|url',
            'team' => 'integer|exists:teams,id',
        ];
    }
}
