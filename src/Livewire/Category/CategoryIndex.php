<?php

declare(strict_types=1);

namespace Stevymarlino\AddonShopperBlog\Livewire\Category;

use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\DeleteBulkAction;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Mckenziearts\Icons\Untitledui\Enums\Untitledui;
use Shopper\Livewire\Pages\AbstractPageComponent;
use Stevymarlino\AddonShopperBlog\Models\Category;

class CategoryIndex extends AbstractPageComponent implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithSchemas;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(Category::query()->latest())
            ->columns([
                TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('slug')
                    ->label(__('Slug'))
                    ->color('gray'),
                TextColumn::make('posts_count')
                    ->label(__('Posts'))
                    ->counts('posts')
                    ->badge(),
                TextColumn::make('updated_at')
                    ->label(__('Updated at'))
                    ->date()
                    ->sortable(),
            ])
            ->recordActions([
                Action::make('edit')
                    ->label(__('Edit'))
                    ->icon(Untitledui::Edit03)
                    ->iconButton()
                    ->action(fn (Category $record) => $this->dispatch(
                        'openPanel',
                        component: 'shopper-slide-overs.category-form',
                        arguments: ['category' => $record],
                    )),
                Action::make('delete')
                    ->label(__('Delete'))
                    ->icon(Untitledui::Trash03)
                    ->iconButton()
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(fn (Category $record) => $record->delete()),
            ])
            ->groupedBulkActions([
                DeleteBulkAction::make()
                    ->requiresConfirmation()
                    ->action(fn (Collection $records) => $records->each->delete())
                    ->deselectRecordsAfterCompletion(),
            ]);
    }

    public function render(): View
    {
        /** @phpstan-ignore-next-line argument.type */
        return view('shopper-blog::livewire.category-index')
            ->title(__('Blog Categories'));
    }
}
