<?php

declare(strict_types=1);

namespace Stevymarlino\AddonShopperBlog\Livewire\Category;

use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
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
use Stevymarlino\AddonShopperBlog\Actions\Category\CreateCategory;
use Stevymarlino\AddonShopperBlog\Actions\Category\UpdateCategory;
use Stevymarlino\AddonShopperBlog\Data\CategoryData;
use Stevymarlino\AddonShopperBlog\Models\Category;

/**
 * @property-read Schema $form
 */
class CategoryForm extends SlideOverComponent implements HasActions, HasSchemas, SlideOverForm
{
    use InteractsWithActions;
    use InteractsWithSchemas;
    use InteractsWithSlideOverForm;

    public Category $category;

    public string $action = 'save';

    public ?string $title = null;

    public ?string $description = null;

    /** @var array<string, mixed>|null */
    public ?array $data = [];

    public function mount(?Category $category = null): void
    {
        $this->category = $category ?? new Category();

        $this->title = $this->category->exists ? __('Edit category') : __('New category');

        $this->form->fill($this->category->exists ? $this->category->toArray() : []);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('General'))
                    ->compact()
                    ->schema([
                        TextInput::make('name')
                            ->label(__('Name'))
                            ->required(),
                        Textarea::make('description')
                            ->label(__('Description'))
                            ->rows(3),
                    ]),
            ])
            ->statePath('data')
            ->model($this->category);
    }

    public function save(): void
    {
        $data = CategoryData::fromArray($this->form->getState());

        $this->category = $this->category->exists
            ? app(UpdateCategory::class)->handle($this->category, $data)
            : app(CreateCategory::class)->handle($data);

        Notification::make()
            ->title(__('Category saved'))
            ->success()
            ->send();

        $this->redirectRoute('shopper.blog.categories.index', navigate: true);
    }
}
