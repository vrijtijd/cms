<?php

namespace App\Http\Controllers;

use App\Models\Repository;
use App\Services\RepoManager;
use Illuminate\Http\Request;

use function App\Services\convertArchetypeSlugToTitle;

class RepositoryContentController extends Controller
{

    public function index(Repository $repository, string $archetype, RepoManager $repoManager) {
        if (!$repoManager->isValidArchetype($repository, $archetype)) {
            return redirect()->route('repositories.show', $repository->id);
        }

        return view('repositories.content.index', [
            'archetype' => convertArchetypeSlugToTitle($archetype),
            'contentFiles' => $repoManager->getContentFiles($repository, $archetype),
            'repository' => $repository,
        ]);
    }

    public function store(Request $request, Repository $repository, string $archetype, RepoManager $repoManager) {
        if (!$repoManager->isValidArchetype($repository, $archetype)) {
            return redirect()->route('repositories.show', $repository->id);
        }

        $contentFile = $repoManager->createContentFile(
            $repository,
            $archetype,
            $request->input('title')
        );

        return redirect()->route('repositories.content.edit', [
            $repository->id,
            $archetype,
            $contentFile->getSlug(),
        ]);
    }

    public function edit(Repository $repository, string $archetype, string $slug, RepoManager $repoManager) {
        if (!$repoManager->isValidArchetype($repository, $archetype)) {
            return redirect()->route('repositories.show', $repository->id);
        }

        return view('repositories.content.edit', [
            'archetype' => convertArchetypeSlugToTitle($archetype),
            'contentFile' => $repoManager->getContentFile($repository, $archetype, $slug),
            'repository' => $repository,
        ]);
    }

    public function update(Request $request, Repository $repository, string $archetype, string $slug, RepoManager $repoManager) {
        if (!$repoManager->isValidArchetype($repository, $archetype)) {
            return redirect()->route('repositories.show', $repository->id);
        }

        $contentFile = $repoManager->getContentFile($repository, $archetype, $slug)
                    ->update(
                        $request->input('slug'),
                        $request->input('frontmatter'),
                        $request->input('body') ?: '',
                    );

        return redirect()->route('repositories.content.edit', [
            $repository->id,
            $archetype,
            $contentFile->getSlug(),
        ]);
    }

    public function destroy(Repository $repository, string $archetype, string $slug, RepoManager $repoManager) {
        if (!$repoManager->isValidArchetype($repository, $archetype)) {
            return redirect()->route('repositories.show', $repository->id);
        }

        $repoManager->deleteContent($repository, $archetype, $slug);

        return back();
    }
}
