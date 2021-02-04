<?php

namespace App\Services\RepositoryService;

use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Str;
use Symfony\Component\Yaml\Yaml;

class ContentFile
{
    private $slug;
    private $body;
    private $frontMatter;
    private $archetype;
    private $path;

    public function __construct(string $path, Archetype $archetype)
    {
        $this->slug = (string) Str::of($path)->basename('.md');
        $this->path = $path;
        $this->archetype = $archetype;
    }

    public function getName()
    {
        return Str::title(implode(' ', explode('-', $this->slug)));
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function getFrontMatter()
    {
        if (!$this->frontMatter) {
            $this->readFile();
        }

        return $this->frontMatter;
    }

    public function getBody()
    {
        if (!$this->body) {
            $this->readFile();
        }

        return $this->body;
    }

    public function getURI()
    {
        return "/{$this->archetype->getSlug()}/{$this->slug}";
    }

    public function getArchetype()
    {
        return $this->archetype;
    }

    public function update(string $slug, array $frontMatter, string $body)
    {
        $slug = Str::slug($slug);
        $this->frontMatter = $frontMatter;

        $fileHandle = fopen($this->path, 'w');

        foreach ($frontMatter as $key => $value) {
            if ($value === 'true' || $value === 'false') {
                $frontMatter[$key] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
            } elseif (is_numeric($value)) {
                $frontMatter[$key] = $value + 0;
            } elseif (Carbon::hasFormat($value, 'Y-m-d\TH:i:sP')) {
                $frontMatter[$key] = new DateTime($value);
            }
        }

        $frontMatterYaml = trim(Yaml::dump($frontMatter));
        $body = str_replace("\r", '', $body); // Remove carriage returns
        $body = preg_replace('/^[ \t\f]+|[ \t\f]+$/m', '', trim($body)); // trim each line
        $body = preg_replace('/^(.+)$/m', '\1  ', $body); // force markdown newlines

        $this->body = $body;

        fwrite($fileHandle, <<<EOF
---
$frontMatterYaml
---

$body

EOF
);

        fclose($fileHandle);

        if ($this->slug !== $slug) {
            $newPath = str_replace("{$this->slug}.md", "$slug.md", $this->path);

            rename($this->path, $newPath);

            $this->slug = $slug;
            $this->path = $newPath;
        }

        return $this;
    }

    public function setWeight(int $weight)
    {
        $frontMatter = array_merge($this->getFrontMatter(), [
            'weight' => $weight,
        ]);

        $this->update(
            $this->getSlug(),
            $frontMatter,
            $this->getBody(),
        );
    }

    public function applyTimezoneOffset(int $timezoneOffsetInMinutes)
    {
        $frontMatter = $this->getFrontMatter();

        foreach ($frontMatter as $key => $value) {
            if ($value instanceof DateTime) {
                $frontMatter[$key] = Carbon::instance($value)->utcOffset($timezoneOffsetInMinutes)
                                                             ->format('Y-m-d\TH:i:sP');
            }
        }

        return $this->update(
            $this->slug,
            $frontMatter,
            $this->body,
        );
    }

    public function delete()
    {
        exec("rm {$this->path}");
    }

    private function readFile()
    {
        $fileHandle = fopen($this->path, 'r');

        $frontMatter = '';
        $body = '';

        $isReadingFrontMatter = false;

        while (($line = fgets($fileHandle)) !== false) {
            if (preg_match('/^-+$/', $line)) {
                $isReadingFrontMatter = !$isReadingFrontMatter;
                continue;
            }

            if ($isReadingFrontMatter) {
                $frontMatter .= $line;
            } else {
                $body .= $line;
            }
        }

        fclose($fileHandle);

        $this->frontMatter = Yaml::parse($frontMatter, Yaml::PARSE_DATETIME);
        $this->body = $body;
    }
}
