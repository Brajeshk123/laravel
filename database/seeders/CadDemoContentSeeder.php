<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Content;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CadDemoContentSeeder extends Seeder
{
    public function run(): void
    {
        $author = User::query()->first();

        if (! $author) {
            $this->command?->warn('CAD demo content skipped because no users exist.');

            return;
        }

        $categories = collect([
            'CAD Services' => 'Professional CAD drafting, modeling, and documentation services.',
            'CAD Insights' => 'Practical guidance for engineering, architecture, and manufacturing teams.',
        ])->mapWithKeys(function (string $description, string $name) {
            $category = Category::updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'description' => $description,
                    'status' => true,
                    'sort_order' => 10,
                ]
            );

            return [$name => $category];
        });

        $tags = collect([
            'CAD',
            'BIM',
            '3D Modeling',
            'Drafting',
            'Manufacturing',
            'Documentation',
        ])->mapWithKeys(function (string $name) {
            $tag = Tag::updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );

            return [$name => $tag->id];
        });

        foreach ($this->items() as $index => $item) {
            $imagePath = $this->createImage(
                $item['slug'],
                $item['title'],
                $item['kicker'],
                $item['accent'],
                $item['type']
            );

            $content = Content::updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'title' => $item['title'],
                    'content_type' => $item['type'],
                    'excerpt' => $item['excerpt'],
                    'content' => $this->body($item),
                    'featured_image' => $imagePath,
                    'banner_image' => $imagePath,
                    'author_id' => $author->id,
                    'status' => 'published',
                    'published_at' => now()->subDays(10 - $index),
                    'is_featured' => $index < 4,
                    'allow_comments' => $item['type'] === 'blog',
                    'meta_title' => $item['title'],
                    'meta_description' => $item['excerpt'],
                    'meta_keywords' => implode(', ', $item['tags']),
                    'robots' => 'index, follow',
                    'og_title' => $item['title'],
                    'og_description' => $item['excerpt'],
                    'og_image' => $imagePath,
                    'twitter_card' => 'summary_large_image',
                ]
            );

            $category = $item['type'] === 'service'
                ? $categories['CAD Services']
                : $categories['CAD Insights'];

            $content->categories()->sync([$category->id]);
            $content->tags()->sync(collect($item['tags'])->map(fn ($tag) => $tags[$tag])->all());
        }
    }

    private function items(): array
    {
        return [
            [
                'type' => 'service',
                'slug' => '2d-cad-drafting-documentation',
                'title' => '2D CAD Drafting & Documentation',
                'kicker' => 'Production Drawings',
                'accent' => '#36d1dc',
                'excerpt' => 'Precise construction, fabrication, and permit-ready drawings prepared with clean layers, line weights, and revision control.',
                'tags' => ['CAD', 'Drafting', 'Documentation'],
            ],
            [
                'type' => 'service',
                'slug' => '3d-product-modeling-visualization',
                'title' => '3D Product Modeling & Visualization',
                'kicker' => 'Digital Prototypes',
                'accent' => '#ff6b6b',
                'excerpt' => 'High-quality 3D CAD models for product reviews, presentations, manufacturing discussions, and investor-ready visuals.',
                'tags' => ['CAD', '3D Modeling', 'Manufacturing'],
            ],
            [
                'type' => 'service',
                'slug' => 'bim-modeling-coordination',
                'title' => 'BIM Modeling & Coordination',
                'kicker' => 'Coordinated Builds',
                'accent' => '#7c3aed',
                'excerpt' => 'Coordinated architectural, structural, and MEP models that help project teams reduce clashes before construction starts.',
                'tags' => ['BIM', '3D Modeling', 'Documentation'],
            ],
            [
                'type' => 'service',
                'slug' => 'cad-conversion-redraw-services',
                'title' => 'CAD Conversion & Redraw Services',
                'kicker' => 'Legacy to Digital',
                'accent' => '#22c55e',
                'excerpt' => 'Convert PDFs, scans, and legacy markups into editable CAD files with accurate geometry and consistent standards.',
                'tags' => ['CAD', 'Drafting', 'Documentation'],
            ],
            [
                'type' => 'service',
                'slug' => 'manufacturing-shop-drawings',
                'title' => 'Manufacturing & Shop Drawings',
                'kicker' => 'Fabrication Ready',
                'accent' => '#f59e0b',
                'excerpt' => 'Detailed shop drawings, assemblies, exploded views, and bill-of-material ready packages for fabrication teams.',
                'tags' => ['Manufacturing', 'Drafting', 'Documentation'],
            ],
            [
                'type' => 'blog',
                'slug' => 'how-clean-cad-standards-save-project-hours',
                'title' => 'How Clean CAD Standards Save Project Hours',
                'kicker' => 'Workflow',
                'accent' => '#06b6d4',
                'excerpt' => 'Layer naming, title blocks, and plotting rules are not admin clutter. They are the difference between fast coordination and avoidable rework.',
                'tags' => ['CAD', 'Drafting', 'Documentation'],
            ],
            [
                'type' => 'blog',
                'slug' => '2d-vs-3d-cad-choosing-right-deliverable',
                'title' => '2D vs 3D CAD: Choosing the Right Deliverable',
                'kicker' => 'Planning',
                'accent' => '#ec4899',
                'excerpt' => 'A practical guide to deciding when a drawing set is enough and when a 3D model will make reviews, approvals, and fabrication easier.',
                'tags' => ['CAD', '3D Modeling', 'Manufacturing'],
            ],
            [
                'type' => 'blog',
                'slug' => 'bim-coordination-before-site-work',
                'title' => 'Why BIM Coordination Matters Before Site Work',
                'kicker' => 'Coordination',
                'accent' => '#8b5cf6',
                'excerpt' => 'Early model coordination helps teams identify conflicts, align responsibilities, and reduce expensive changes in the field.',
                'tags' => ['BIM', '3D Modeling', 'Documentation'],
            ],
            [
                'type' => 'blog',
                'slug' => 'preparing-sketches-for-cad-conversion',
                'title' => 'Preparing Sketches for Accurate CAD Conversion',
                'kicker' => 'Conversion',
                'accent' => '#10b981',
                'excerpt' => 'Better source files lead to better CAD output. Here is what to include before sending sketches, PDFs, or scans for redraw.',
                'tags' => ['CAD', 'Drafting', 'Documentation'],
            ],
            [
                'type' => 'blog',
                'slug' => 'shop-drawing-review-checklist',
                'title' => 'A Practical Shop Drawing Review Checklist',
                'kicker' => 'Fabrication',
                'accent' => '#f97316',
                'excerpt' => 'Use this checklist to review dimensions, tolerances, materials, revisions, and notes before releasing drawings to production.',
                'tags' => ['Manufacturing', 'Drafting', 'Documentation'],
            ],
        ];
    }

    private function body(array $item): string
    {
        $intro = $item['type'] === 'service'
            ? 'This service is designed for teams that need reliable CAD output without slowing down design, approval, or production workflows.'
            : 'CAD teams move faster when technical decisions are documented clearly and reviewed with the right level of detail.';

        return <<<HTML
<p>{$intro}</p>
<p>{$item['excerpt']}</p>
<h2>What this covers</h2>
<ul>
    <li>Clean file organization with consistent layers, naming, and deliverable structure.</li>
    <li>Professional drafting standards for readable dimensions, annotations, and sheet layouts.</li>
    <li>Review-ready outputs that support coordination between design, engineering, and production teams.</li>
</ul>
<h2>Why it matters</h2>
<p>Good CAD work reduces ambiguity. It helps stakeholders understand intent, catch issues earlier, and make confident decisions before work moves into the field or onto the shop floor.</p>
HTML;
    }

    private function createImage(string $slug, string $title, string $kicker, string $accent, string $type): string
    {
        $path = "contents/cad-{$slug}.svg";
        $escapedTitle = e($title);
        $escapedKicker = e($kicker);
        $label = strtoupper($type);

        $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="1280" height="820" viewBox="0 0 1280 820" role="img" aria-label="{$escapedTitle}">
  <defs>
    <linearGradient id="bg" x1="0" y1="0" x2="1" y2="1">
      <stop offset="0" stop-color="#111827"/>
      <stop offset="0.55" stop-color="#1f2937"/>
      <stop offset="1" stop-color="#0f172a"/>
    </linearGradient>
    <pattern id="grid" width="48" height="48" patternUnits="userSpaceOnUse">
      <path d="M48 0H0v48" fill="none" stroke="#ffffff" stroke-opacity="0.08" stroke-width="1"/>
    </pattern>
    <filter id="softShadow" x="-20%" y="-20%" width="140%" height="140%">
      <feDropShadow dx="0" dy="28" stdDeviation="28" flood-color="#000000" flood-opacity="0.35"/>
    </filter>
  </defs>
  <rect width="1280" height="820" fill="url(#bg)"/>
  <rect width="1280" height="820" fill="url(#grid)"/>
  <circle cx="1040" cy="130" r="220" fill="{$accent}" opacity="0.18"/>
  <circle cx="160" cy="710" r="260" fill="{$accent}" opacity="0.12"/>
  <g transform="translate(610 185)" filter="url(#softShadow)">
    <path d="M40 95 270 0 500 95v275L270 492 40 370Z" fill="#f8fafc" opacity="0.96"/>
    <path d="M40 95 270 202v290L40 370Z" fill="#dbeafe"/>
    <path d="M500 95 270 202v290l230-122Z" fill="#bfdbfe"/>
    <path d="M40 95 270 0l230 95-230 107Z" fill="#eff6ff"/>
    <path d="M40 95 270 202m230-107L270 202m0 0v290" fill="none" stroke="#1e3a8a" stroke-width="8" stroke-linejoin="round" opacity="0.55"/>
  </g>
  <g fill="none" stroke="{$accent}" stroke-width="5" stroke-linecap="round" opacity="0.95">
    <path d="M125 570h320v-210h-210v120h210"/>
    <path d="M155 615h260"/>
    <path d="M195 655h180"/>
    <path d="M185 360l50-50h210"/>
  </g>
  <g fill="#ffffff">
    <text x="96" y="126" font-family="Inter, Arial, sans-serif" font-size="22" font-weight="700" letter-spacing="4" opacity="0.72">{$label}</text>
    <text x="96" y="180" font-family="Inter, Arial, sans-serif" font-size="32" font-weight="800" fill="{$accent}">{$escapedKicker}</text>
    <foreignObject x="92" y="220" width="540" height="210">
      <div xmlns="http://www.w3.org/1999/xhtml" style="font-family: Inter, Arial, sans-serif; color: white; font-size: 54px; font-weight: 800; line-height: 1.08;">{$escapedTitle}</div>
    </foreignObject>
  </g>
  <g opacity="0.76">
    <rect x="92" y="708" width="210" height="10" rx="5" fill="{$accent}"/>
    <rect x="322" y="708" width="145" height="10" rx="5" fill="#ffffff"/>
    <rect x="488" y="708" width="88" height="10" rx="5" fill="#ffffff" opacity="0.55"/>
  </g>
</svg>
SVG;

        Storage::disk('public')->put($path, $svg);

        return $path;
    }
}
