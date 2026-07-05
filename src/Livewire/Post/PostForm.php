<?php

declare(strict_types=1);

namespace Stevymarlino\AddonShopperBlog\Livewire\Post;

use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Laravelcm\LivewireSlideOvers\SlideOverComponent;
use Shopper\Components\Section;
use Shopper\Contracts\SlideOverForm;
use Shopper\Traits\InteractsWithSlideOverForm;
use Stevymarlino\AddonShopperBlog\Enums\PostStatus;
use Stevymarlino\AddonShopperBlog\Models\Category;
use Stevymarlino\AddonShopperBlog\Models\Post;

/**
 * @property-read Schema $form
 */
class PostForm extends SlideOverComponent implements HasActions, HasSchemas, SlideOverForm
{
    use InteractsWithActions;
    use InteractsWithSchemas;
    use InteractsWithSlideOverForm;

    public Post $post;

    public string $action = 'save';

    public ?string $title = null;

    public ?string $description = null;

    /** @var array<string, mixed>|null */
    public ?array $data = [];

    public function mount(?Post $post = null): void
    {
        $this->post = $post ?? new Post();

        $this->title = $this->post->exists ? __('Edit post') : __('New post');

        $this->form->fill($this->post->exists ? $this->post->toArray() : []);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('General'))
                    ->compact()
                    ->schema([
                        TextInput::make('title')
                            ->label(__('Title'))
                            ->required(),
                        Select::make('category_id')
                            ->label(__('Category'))
                            ->options(Category::query()->pluck('name', 'id'))
                            ->searchable(),
                        Textarea::make('excerpt')
                            ->label(__('Excerpt'))
                            ->rows(2),
                        RichEditor::make('body')
                            ->label(__('Body')),
                    ]),
                Section::make(__('Publication'))
                    ->compact()
                    ->schema([
                        Select::make('status')
                            ->label(__('Status'))
                            ->options(collect(PostStatus::cases())
                                ->mapWithKeys(fn (PostStatus $status): array => [$status->value => $status->label()])
                                ->all())
                            ->default(PostStatus::Draft->value)
                            ->required(),
                        DateTimePicker::make('published_at')
                            ->label(__('Published at'))
                            ->seconds(false),
                    ]),
                Section::make(__('Cover image'))
                    ->compact()
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('cover')
                            ->label(__('Cover'))
                            ->collection('cover')
                            ->image(),
                    ]),
            ])
            ->statePath('data')
            ->model($this->post);
    }

    public function save(): void
    {
        /** @var array<string, mixed> $state */
        $state = $this->form->getState();

        if ($this->post->exists) {
            $this->post->update($state);
        } else {
            $this->post = Post::query()->create($state);
            $this->form->model($this->post)->saveRelationships();
        }

        Notification::make()
            ->title(__('Post saved'))
            ->success()
            ->send();

        $this->redirectRoute('shopper.blog.posts.index', navigate: true);
    }
}
