<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PageContentResource\Pages;
use App\Models\PageContent;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\BulkActionGroup;

class PageContentResource extends Resource
{
    protected static ?string $model = PageContent::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Content Management';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form->schema([
            // Section Information
            Section::make('Section Information')
                ->description('Choose which section of the website to edit')
                ->icon('heroicon-o-cog-6-tooth')
                ->schema([
                    Grid::make(2)
                        ->schema([
                            TextInput::make('section_name')
                                ->label('Page Section Key')
                                ->helperText("Enter a section key. Use lowercase letters, numbers, and hyphens. Examples: 'statistics', 'about', 'initiatives', 'contact', 'hello'.")
                                ->placeholder('about, initiatives, contact, hello')
                                ->datalist(['statistics','about','initiatives','contact','hello'])
                                ->rule('alpha_dash')
                                ->required()
                                ->live(onBlur: true)
                                ->afterStateUpdated(function ($state, callable $set) {
                                    $defaultTitles = [
                                        'statistics' => 'Transparency Statistics',
                                        'about' => 'About YB Dato\' Zunita Begum',
                                        'initiatives' => 'Current Initiatives',
                                        'contact' => 'Contact Information',
                                    ];
                                    $key = strtolower((string) $state);
                                    if (isset($defaultTitles[$key])) {
                                        $set('title', $defaultTitles[$key]);
                                    }
                                }),

                            TextInput::make('title')
                                ->label('Section Title')
                                ->required()
                                ->placeholder('Enter a clear title for this section')
                                ->helperText('This title will be displayed on the website'),
                        ]),
                ]),

            // Content Editor
            Section::make('Content Editor')
                ->description('Edit the main content for this section')
                ->icon('heroicon-o-pencil-square')
                ->schema([
                    RichEditor::make('content')
                        ->label('Content')
                        ->toolbarButtons([
                            'bold', 'italic', 'underline', 'strike',
                            'h2', 'h3', 'h4', 'h5', 'h6',
                            'link', 'bulletList', 'orderedList',
                            'blockquote', 'undo', 'redo'
                        ])
                        ->placeholder('Write your content here...')
                        ->helperText('Use the toolbar above to format your text. You can add headings, links, and lists.')
                        ->columnSpanFull(),
                ]),

            // Image Management
            Section::make('Images')
                ->description('Add images to this section')
                ->icon('heroicon-o-photo')
                ->schema([
                    FileUpload::make('images')
                        ->label('Upload Images')
                        ->multiple()
                        ->image()
                        ->imageEditor()
                        ->imageCropAspectRatio('16:9')
                        ->imageResizeTargetWidth('1920')
                        ->imageResizeTargetHeight('1080')
                        ->directory('page-content')
                        ->maxSize(2048)
                        ->helperText('Upload images for this section. Drag to reorder. Recommended size: 1920x1080 pixels.')
                        ->columnSpanFull(),
                ])
                ->collapsible()
                ->collapsed(),

            // Display Settings
            Section::make('Display Settings')
                ->description('Control how this section appears on the website')
                ->icon('heroicon-o-eye')
                ->schema([
                    Grid::make(2)
                        ->schema([
                            Toggle::make('is_active')
                                ->label('Show this section on website')
                                ->default(true)
                                ->helperText('Turn off to hide this section temporarily'),

                            TextInput::make('sort_order')
                                ->label('Display Order')
                                ->numeric()
                                ->default(0)
                                ->helperText('Lower numbers appear first on the page'),
                        ]),
                ])
                ->collapsible()
                ->collapsed(),

            // Additional Settings
            Section::make('Additional Settings')
                ->description('Optional settings for advanced customization')
                ->icon('heroicon-o-adjustments-horizontal')
                ->schema([
                    Textarea::make('settings')
                        ->label('Custom Settings (JSON)')
                        ->helperText('Add custom settings in JSON format. Example: {"key": "value"}. Leave empty if not sure.')
                        ->placeholder('{"address": "123 Main St", "phone": "+1234567890", "email": "contact@example.com"}')
                        ->columnSpanFull(),
                ])
                ->collapsible()
                ->collapsed(),

            // Hidden fields
            Hidden::make('user_id')
                ->default(auth()->id()),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Visual section indicator
                TextColumn::make('section_name')
                    ->label('Section')
                    ->formatStateUsing(fn ($state) => match($state) {
                        'statistics' => '📊 Statistics',
                        'about' => '👤 About Section',
                        'initiatives' => '🎯 Initiatives',
                        'contact' => '📞 Contact Info',
                        default => ucfirst($state)
                    })
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'statistics' => 'success',
                        'about' => 'info',
                        'initiatives' => 'warning',
                        'contact' => 'danger',
                        default => 'gray',
                    }),

                // Section title
                TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable()
                    ->limit(50),

                // Active status
                ToggleColumn::make('is_active')
                    ->label('Active')
                    ->sortable(),

                // Display order
                TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                // Images count
                TextColumn::make('images')
                    ->label('Images')
                    ->formatStateUsing(fn ($state) => is_array($state) ? count($state) : 0)
                    ->badge()
                    ->color('info')
                    ->toggleable(isToggledHiddenByDefault: true),

                // Last updated
                TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                // Created by
                TextColumn::make('user.name')
                    ->label('Updated By')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('section_name')
                    ->label('Section Type')
                    ->options([
                        'carousel' => '🖼️ Carousel/Banner',
                        'statistics' => '📊 Statistics',
                        'about' => '👤 About Section',
                        'initiatives' => '🎯 Initiatives',
                        'contact' => '📞 Contact Info',
                    ]),

                TernaryFilter::make('is_active')
                    ->label('Active Status'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Edit')
                    ->icon('heroicon-o-pencil')
                    ->color('primary'),

                Tables\Actions\ViewAction::make()
                    ->label('Preview')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->url(fn (PageContent $record): string => route('home') . '#' . $record->section_name),

                Action::make('duplicate')
                    ->label('Duplicate')
                    ->icon('heroicon-o-document-duplicate')
                    ->color('warning')
                    ->action(function (PageContent $record) {
                        $newRecord = $record->replicate();
                        $newRecord->title = $record->title . ' (Copy)';
                        $newRecord->sort_order = $record->sort_order + 1;
                        $newRecord->save();
                    })
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    BulkAction::make('activate')
                        ->label('Activate Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update(['is_active' => true]);
                            });
                        })
                        ->requiresConfirmation(),

                    BulkAction::make('deactivate')
                        ->label('Deactivate Selected')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update(['is_active' => false]);
                            });
                        })
                        ->requiresConfirmation(),

                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order', 'asc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPageContents::route('/'),
            'create' => Pages\CreatePageContent::route('/create'),
            'edit' => Pages\EditPageContent::route('/{record}/edit'),
        ];
    }
}
