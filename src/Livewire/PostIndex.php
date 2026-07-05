<?php

declare(strict_types=1);

namespace Stevymarlino\AddonShopperBlog\Livewire;

use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\DeleteBulkAction;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Mckenziearts\Icons\Untitledui\Enums\Untitledui;
use Shopper\Livewire\Pages\AbstractPageComponent;
use Stevymarlino\AddonShopperBlog\Enums\PostStatus;
use Stevymarlino\AddonShopperBlog\Models\Post;

class PostIndex extends AbstractPageComponent implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithSchemas;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(Post::query()->latest())
            ->columns([
                SpatieMediaLibraryImageColumn::make('cover')
                    ->label(__('Cover'))
                    ->circular()
                    ->collection('cover')
                    ->grow(false),
                TextColumn::make('title')
                    ->label(__('Title'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category.name')
                    ->label(__('Category'))
                    ->placeholder('-')
                    ->sortable(),
                TextColumn::make('status')
                    ->label(__('Status'))
                    ->badge()
                    ->formatStateUsing(fn (PostStatus $state): string => $state->label())
                    ->color(fn (PostStatus $state): string => $state === PostStatus::Published ? 'success' : 'gray'),
                TextColumn::make('published_at')
                    ->label(__('Published at'))
                    ->dateTime()
                    ->placeholder('-')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('Status'))
                    ->options(fn (): array => collect(PostStatus::cases())
                        ->mapWithKeys(fn (PostStatus $status): array => [$status->value => $status->label()])
                        ->all()),
                SelectFilter::make('category_id')
                    ->label(__('Category'))
                    ->relationship('category', 'name'),
            ])
            ->recordActions([
                Action::make('edit')
                    ->label(__('Edit'))
                    ->icon(Untitledui::Edit03)
                    ->iconButton()
                    ->action(fn (Post $record) => $this->dispatch(
                        'openPanel',
                        component: 'shopper-slide-overs.post-form',
                        arguments: ['post' => $record],
                    )),

                Action::make('delete')
                    ->label(__('Delete'))
                    ->icon(Untitledui::Trash03)
                    ->iconButton()
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(fn (Post $record) => $record->delete()),
            ])
            ->groupedBulkActions([
                DeleteBulkAction::make()
                    ->requiresConfirmation()
                    ->action(fn (Collection $records) => $records->each->delete())
                    ->deselectRecordsAfterCompletion(),
            ])
            ->persistFiltersInSession();
    }

    public function render(): View
    {
        /** @phpstan-ignore-next-line argument.type */
        return view('shopper-blog::livewire.post-index')
            ->title(__('Blog Posts'));
    }
}
