<?php

namespace App\Http\Controllers;

use App\Models\Repository;
use App\Services\RepositoryService\RepositoryService;
use Illuminate\Http\Request;

class RepositoryContentController extends Controller
{
    public function index(Repository $repository, string $archetypeSlug, RepositoryService $repositoryService)
    {
        $archetype = $repositoryService->getArchetype($repository, $archetypeSlug);

        if (!$archetype) {
            return redirect()->route('repositories.show', $repository->id);
        }

        return view('repositories.content.index', [
            'archetype' => $archetype,
            'contentFiles' => $archetype->getContentFiles(),
            'repository' => $repository,
            'canPreview' => $archetype->hasSingleView(),
        ]);
    }

    public function store(Request $request, Repository $repository, string $archetypeSlug, RepositoryService $repositoryService)
    {
        $archetype = $repositoryService->getArchetype($repository, $archetypeSlug);

        if (!$archetype) {
            return redirect()->route('repositories.show', $repository->id);
        }

        $contentFile = $archetype->createContentFile(
            $request->input('title') || '',
            $request->input('timezoneOffsetInMinutes'),
        );

        return redirect()->route('repositories.content.edit', [
            $repository->id,
            $archetype->getSlug(),
            $contentFile->getSlug(),
        ])->with('created', true);
    }

    public function edit(Repository $repository, string $archetypeName, string $slug, RepositoryService $repositoryService)
    {
        $archetype = $repositoryService->getArchetype($repository, $archetypeName);

        if (!$archetype) {
            return redirect()->route('repositories.show', $repository->id);
        }

        return view('repositories.content.edit', [
            'archetype' => $archetype,
            'contentFile' => $archetype->getContentFile($slug),
            'repository' => $repository,
            'canPreview' => $archetype->hasSingleView(),
        ]);
    }

    public function update(Request $request, Repository $repository, string $archetypeName, string $slug, RepositoryService $repositoryService)
    {
        $request->validate([
            'slug' => 'string|required',
        ]);

        $archetype = $repositoryService->getArchetype($repository, $archetypeName);

        if (!$archetype) {
            return redirect()->route('repositories.show', $repository->id);
        }

        $contentFile = $archetype->getContentFile($slug)
                                 ->update(
                                     $request->input('slug'),
                                     $request->input('frontmatter'),
                                     $request->input('body') ?: '',
                                 );

        // Need to redirect instead of `back()` because the slug might've changed
        return redirect()->route('repositories.content.edit', [
            $repository->id,
            $archetype->getSlug(),
            $contentFile->getSlug(),
        ])->with('updated', true);
    }
}
